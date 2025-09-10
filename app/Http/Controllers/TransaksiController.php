<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function konfirmasiTransaksi(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('transaksi')
                ->join('users', 'transaksi.pelanggan_id', '=', 'users.id')
                ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                ->select(
                    'transaksi.id',
                    'transaksi.waktu_transaksi',
                    'users.username as pelanggan',
                    'transaksi.total',
                    'pembayaran.status_pembayaran'
                )
                ->orderByRaw("CASE WHEN pembayaran.status_pembayaran IS NULL OR pembayaran.status_pembayaran = '' THEN 0 ELSE 1 END");

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->status_pembayaran === 'F' || is_null($row->status_pembayaran) || $row->status_pembayaran === '') {
                        return '<button onclick="showDetailModal(' . $row->id . ')" class="btn btn-success btn-sm">Konfirmasi</button>';
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
        return view('penjual.transaksi.konfirmasi');
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
                ->select('bukti_transfer', 'status_pembayaran')
                ->where('transaksi_id', $id)
                ->first();

            return response()->json([
                'success'      => true,
                'transaksi'    => $transaksi,
                'detail_items' => $detail_items,
                'pembayaran'   => $pembayaran,
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

}
