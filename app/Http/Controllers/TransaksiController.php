<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function konfirmasiTransaksi(Request $request)
    {
        // Ambil produk dengan stok rendah (misal < 2)
        $stok_rendah = DB::table('products')
            ->where('stok', '<', 2)
            ->select('id', 'nama_barang', 'stok')
            ->orderBy('stok', 'asc')
            ->get();

        // Ambil order yang menunggu konfirmasi
        $order_konfirmasi = DB::table('transaksi')
            ->where('keterangan', 'menunggu konfirmasi')
            ->join('users', 'transaksi.pelanggan_id', '=', 'users.id')
            ->select(
                'transaksi.id',
                'users.username as nama_pelanggan',
                'transaksi.total',
                'transaksi.waktu_transaksi',
                'transaksi.keterangan'
            )
            ->orderBy('transaksi.waktu_transaksi', 'asc')
            ->get();

        if ($request->ajax()) {
            $query = DB::table('transaksi')
                ->join('users', 'transaksi.pelanggan_id', '=', 'users.id')
                ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                ->select(
                    'transaksi.id',
                    'transaksi.waktu_transaksi',
                    'users.username as pelanggan',
                    'transaksi.total',
                    'transaksi.keterangan',
                    'pembayaran.status_pembayaran'
                )
                ->orderByRaw("CASE WHEN pembayaran.status_pembayaran IS NULL OR pembayaran.status_pembayaran = '' THEN 0 ELSE 1 END");

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if (is_null($row->status_pembayaran) || $row->status_pembayaran === '') {
                        return '<button onclick="showDetailModal(\'' . $row->id . '\')" class="btn btn-success btn-sm">Konfirmasi</button>';
                    }
                    return '';
                })
                ->editColumn('waktu_transaksi', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->waktu_transaksi));
                })
                ->editColumn('total', function ($row) {
                    return 'Rp ' . number_format($row->total, 0, ',', '.');
                })
                ->editColumn('status_pembayaran', function ($row) {
                    if ($row->status_pembayaran === 'T') {
                        return '<span class="badge bg-success">Dikonfirmasi</span>';
                    } elseif ($row->status_pembayaran === 'F') {
                        return '<span class="badge bg-danger">Ditolak</span>';
                    } elseif (is_null($row->status_pembayaran) || $row->status_pembayaran === '') {
                        return '<span class="badge bg-warning text-dark">Perlu Konfirmasi</span>';
                    } else {
                        return '<span class="badge bg-secondary">' . e($row->status_pembayaran) . '</span>';
                    }
                })
                ->rawColumns(['action', 'status_pembayaran'])
                ->make(true);

        }
        return view('penjual.transaksi.konfirmasi', [
            'stok_rendah' => $stok_rendah,
            'order_konfirmasi' => $order_konfirmasi,
        ]);
    }

    public function getDetailTransaksi($id)
    {
        try {
            $transaksi = DB::table('transaksi as t')
                ->join('users as u', 't.pelanggan_id', '=', 'u.id')
                ->select('t.id', 'u.username as pelanggan', 't.waktu_transaksi', 't.total')
                ->where('t.id', $id)
                ->firstOrFail();

            $detail_items = DB::table('transaksi_detail as dt')
                ->join('products as b', 'dt.barang_id', '=', 'b.id')
                ->select('b.nama_barang', 'dt.qty', 'dt.harga')
                ->where('dt.transaksi_id', $id)
                ->get();

            $pembayaran = DB::table('pembayaran')
                ->select('bukti_transfer', 'status_pembayaran', 'keterangan')
                ->where('transaksi_id', $id)
                ->first();

            $bukti_transfer_url = null;
            if ($pembayaran && $pembayaran->bukti_transfer) {
                $bukti_transfer_url = asset('storage/proofs/' . $pembayaran->bukti_transfer);
            }

            return response()->json([
                'success'            => true,
                'transaksi'          => $transaksi,
                'detail_items'       => $detail_items,
                'pembayaran'         => $pembayaran,
                'bukti_transfer_url' => $bukti_transfer_url,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function setujuiTransaksi($id, Request $request)
    {
        try {
            $affected = DB::table('pembayaran')
                ->where('transaksi_id', $id)
                ->update([
                    'status_pembayaran' => 'T',
                    'dtmodi'            => now(),
                ]);

            if ($affected) {
                DB::table('transaksi')
                    ->where('id', $id)
                    ->update([
                        'keterangan' => 'selesai',
                        'dtmodi'            => now(),
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil disetujui.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan atau sudah diproses.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function tolakTransaksi($id, Request $request)
    {
        $alasan = $request->input('alasan');
        try {
            $affected = DB::table('pembayaran')
                ->where('transaksi_id', $id)
                ->update([
                    'status_pembayaran' => 'F',
                    'dtmodi'            => now(),
                    'keterangan'        => $alasan,
                ]);

            if ($affected) {

                $itemsToRestore = DB::table('transaksi_detail')->where('transaksi_id', $id)->get();

                foreach ($itemsToRestore as $item) {
                    DB::table('products')->where('id', $item->barang_id)->increment('stok', $item->qty);
                }

                DB::table('transaksi')
                    ->where('id', $id)
                    ->update([
                        'keterangan' => 'dibatalkan',
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil disetujui.',
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil ditolak.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan atau sudah diproses.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function riwayatTransaksi(Request $request)
    {
        // Ambil data stok rendah dan order konfirmasi seperti di PenjualController
        $stok_rendah = DB::table('products')
            ->where('stok', '<', 2)
            ->select('id', 'nama_barang', 'stok')
            ->orderBy('stok', 'asc')
            ->get();

        $order_konfirmasi = DB::table('transaksi')
            ->where('keterangan', 'menunggu konfirmasi')
            ->join('users', 'transaksi.pelanggan_id', '=', 'users.id')
            ->select(
                'transaksi.id',
                'users.username as nama_pelanggan',
                'transaksi.total',
                'transaksi.waktu_transaksi',
                'transaksi.keterangan'
            )
            ->orderBy('transaksi.waktu_transaksi', 'asc')
            ->get();

        if ($request->ajax()) {
            $query = DB::table('transaksi')
                ->join('users', 'transaksi.pelanggan_id', '=', 'users.id')
                ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                ->select(
                    'transaksi.id',
                    'transaksi.waktu_transaksi',
                    'users.username as pelanggan',
                    'transaksi.total',
                    'transaksi.keterangan'
                )
                ->orderBy('transaksi.waktu_transaksi', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('waktu_transaksi', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->waktu_transaksi));
                })
                ->editColumn('total', function ($row) {
                    return 'Rp ' . number_format($row->total, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<button onclick="showDetailModal(' . $row->id . ')" class="btn btn-success btn-sm" title="Lihat Detail"><i class="bx bx-show"></i></button> ';
                    $btn .= '<a href="' . route('invoice.show', $row->id) . '" target="_blank" class="btn btn-warning btn-sm" title="Lihat Invoice"><i class="bx bx-receipt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('penjual.transaksi.riwayat', [
            'stok_rendah' => $stok_rendah,
            'order_konfirmasi' => $order_konfirmasi,
        ]);
    }

    // public function pesananDikirim($id, Request $request)
    // {
    //     try {
    //         $affected = DB::table('transaksi')
    //             ->where('id', $id)
    //             ->update([
    //                 'keterangan' => 'diterima',
    //                 'dtmodi'     => now(),
    //             ]);

    //         if ($affected) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Transaksi berhasil disetujui.',
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Transaksi tidak ditemukan atau sudah diproses.',
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function showInvoice($id)
    {
        // Ambil data transaksi
        $transaksi = \DB::table('transaksi as t')
            ->join('users as pelanggan', 't.pelanggan_id', '=', 'pelanggan.id')
            ->select(
                't.id',
                't.waktu_transaksi',
                'pelanggan.nama as nama_pelanggan',
                'pelanggan.alamat as alamat_pelanggan',
                'pelanggan.phone as telp_pelanggan'
            )
            ->where('t.id', $id)
            ->first();

        if (! $transaksi) {
            return abort(404, 'Transaksi tidak ditemukan');
        }

        $items = \DB::table('transaksi_detail as td')
            ->join('products as p', 'td.barang_id', '=', 'p.id')
            ->select(
                'p.nama_barang',
                'td.qty',
                'td.harga',
                \DB::raw('(td.qty * td.harga) as total_item')
            )
            ->where('td.transaksi_id', $id)
            ->get();

        $pembayaran = \DB::table('pembayaran')
            ->where('transaksi_id', $id)
            ->orderByDesc('waktu')
            ->first();

        $atas_nama_customer = null;
        $no_rek_customer    = null;
        if ($pembayaran && isset($pembayaran->keterangan) && ! empty($pembayaran->keterangan)) {
            $parts = explode('-', $pembayaran->keterangan, 2);
            if (count($parts) == 2) {
                $atas_nama_customer = trim($parts[0]);
                $no_rek_customer    = trim($parts[1]);
            }
        }

        $subtotal     = $items->sum('total_item');
        $total_diskon = 0;
        $total        = ($subtotal - $total_diskon);

        $summary = [
            'subtotal' => $subtotal,
            'diskon'   => $total_diskon,
            'total'    => $total,
        ];

        $company = [
            'name'             => config('app.company_name', 'Toko Bintang Motor Batam'),
            'address'          => config('app.company_address', 'Alamat Perusahaan'),
            'phone'            => config('app.company_phone', '-'),
            'email'            => config('app.company_email', '-'),
            'npwp'             => config('app.company_npwp', '-'),
            'bank'             => config('app.company_bank', 'Bank'),
            'bank_account'     => config('app.company_bank_account', '-'),
            'bank_name'        => config('app.company_bank_name', '-'),
            'payment_due_days' => config('app.company_payment_due_days', 14),
        ];
        $sales = \Auth::user();

        return view('layouts.invoice', [
            'transaksi'          => $transaksi,
            'items'              => $items,
            'pembayaran'         => $pembayaran,
            'sales'              => $sales,
            'summary'            => $summary,
            'company'            => $company,
            'print_mode'         => true, // Tambahan untuk mode print jika dibutuhkan di blade
            'atas_nama_customer' => $atas_nama_customer,
            'no_rek_customer'    => $no_rek_customer,
        ]);
    }
}
