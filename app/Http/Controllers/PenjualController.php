<?php
namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class PenjualController extends Controller
{
    public function DashboardPenjual()
    {
        $data = [
            'produk'      => DB::table('products')->count(),
            'users'       => DB::table('users')->count(),
            'transaksi'   => DB::table('transaksi')->where('keterangan', 'selesai')->count(),
            'total30hari' => DB::table('transaksi')
                ->where('keterangan', 'selesai')
                ->whereBetween('waktu_transaksi', [
                    now()->subDays(29)->startOfDay()->toDateTimeString(),
                    now()->endOfDay()->toDateTimeString(),
                ])->sum('total'),
            'totalorders' => DB::table('transaksi')->where('keterangan', 'selesai')->sum('total'),
            'totaltoday'  => DB::table('transaksi')
                ->where('keterangan', 'selesai')
                ->whereDate('waktu_transaksi', now()->toDateString())
                ->sum('total'),
        ];

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

        $data['stok_rendah'] = $stok_rendah;
        $data['order_konfirmasi'] = $order_konfirmasi;

        return view('penjual.index', $data);
    }

    public function ProfilPenjual()
    {
        $id    = Auth::user()->id;
        $pData = User::find($id);

        return view('penjual.profil', compact('pData'));
    }

    public function ProfilPenjualStore(Request $request)
    {
        $id           = Auth::user()->id;
        $data         = User::find($id);
        $data->nama   = $request->nama;
        $data->email  = $request->email;
        $data->phone  = $request->phone;
        $data->alamat = $request->alamat;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/images_penjual/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/images_penjual'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notif = [
            'message'    => 'Profil Berhasil Diupdated!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notif);
    }

    public function GantiSandiPenjual()
    {
        return view('penjual.ganti_sandi');
    }

    public function PenjualUpdateSandi(Request $request)
    {
        // validasi form
        $request->validate([
            'sandi_lama' => 'required',
            'sandi_baru' => 'required|confirmed',
        ]);

        // cek password lama
        if (! Hash::check($request->sandi_lama, auth::user()->password)) {
            return back()->with('error', 'Sandi lama tidak sesuai!');
        }

        // update sandi baru
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->sandi_baru),
        ]);

        return back()->with('status', 'Sandi Berhasil Diupdate!');
    }

    public function LogoutPenjual(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/penjual/login');
    }

    public function laporanIndex()
    {
        // Ambil produk dengan stok rendah (misal <= 5)
        $stok_rendah = DB::table('products')
            ->where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->get();

        // Ambil order yang menunggu konfirmasi
        $order_konfirmasi = DB::table('transaksi')
            ->where('keterangan', 'menunggu konfirmasi')
            ->orderBy('waktu_transaksi', 'desc')
            ->get();

        return view('penjual.laporan.index', [
            'stok_rendah' => $stok_rendah,
            'order_konfirmasi' => $order_konfirmasi,
        ]);
    }

    public function laporanData(Request $request): JsonResponse
    {
        $query = DB::table('transaksi')
            ->leftJoin('users as u', 'transaksi.pelanggan_id', '=', 'u.id')
            ->leftJoin('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
            ->select(
                'transaksi.id',
                'transaksi.waktu_transaksi',
                'transaksi.total',
                'transaksi.keterangan',
                'pembayaran.metode as metode_bayar',
                'transaksi.pelanggan_id',
                'u.nama as nama_pelanggan'
            )
            ->whereIn('transaksi.keterangan', ['selesai', 'dibatalkan']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $tanggalMulai   = $request->tanggal_mulai . ' 00:00:00';
            $tanggalSelesai = $request->tanggal_selesai . ' 23:59:59';
            $query->whereBetween('transaksi.waktu_transaksi', [$tanggalMulai, $tanggalSelesai]);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('waktu_transaksi', function ($row) {
                return \Carbon\Carbon::parse($row->waktu_transaksi)->format('d/m/Y H:i');
            })
            ->addColumn('pelanggan', function ($row) {
                return $row->nama_pelanggan ? $row->nama_pelanggan : 'Guest';
            })
            ->addColumn('total_formatted', function ($row) {
                return 'Rp ' . number_format($row->total, 0, ',', '.');
            })
            ->addColumn('status_badge', function ($row) {
                $badgeClass = '';
                switch ($row->keterangan) {
                    case 'selesai':
                        $badgeClass = 'badge bg-success';
                        break;
                    case 'pending':
                        $badgeClass = 'badge bg-warning';
                        break;
                    case 'dibatalkan':
                        $badgeClass = 'badge bg-danger';
                        break;
                    default:
                        $badgeClass = 'badge bg-secondary';
                        break;
                }
                return '<span class="' . $badgeClass . '">' . ucfirst($row->keterangan) . '</span>';
            })
            ->addColumn('metode_bayar', function ($row) {
                return $row->metode_bayar ? ucfirst(str_replace('_', ' ', $row->metode_bayar)) : '-';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-info" onclick="viewDetail(\'' . $row->id . '\')" title="Detail">
                            <i class="bx bx-show"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['status_badge', 'action'])
            ->orderColumn('waktu_transaksi', 'transaksi.waktu_transaksi $1')
            ->make(true);
    }

    public function chartPenjualan(Request $request): JsonResponse
    {
        $startDate = $request->tanggal_mulai ?? now()->startOfMonth()->format('Y-m-d');
        $endDate   = $request->tanggal_selesai ?? now()->format('Y-m-d');

        $data = DB::table('transaksi')
            ->selectRaw('DATE(waktu_transaksi) as tanggal, SUM(total) as total_penjualan')
            ->where('keterangan', 'selesai')
            ->whereBetween('waktu_transaksi', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total_penjualan', 'tanggal');

        $period    = [];
        $labels    = [];
        $chartData = [];

        $start = Carbon::parse($startDate);
        $end   = Carbon::parse($endDate);

        while ($start->lte($end)) {
            $dateString  = $start->format('Y-m-d');
            $labels[]    = $start->format('d/m');
            $chartData[] = $data[$dateString] ?? 0;
            $start->addDay();
        }

        return response()->json([
            'labels' => $labels,
            'data'   => $chartData,
        ]);
    }

    public function chartStatus(Request $request): JsonResponse
    {
        $statusOrder = [
            'selesai',
            'pending',
            'dibatalkan',
            'menunggu konfirmasi'
        ];

        $query = DB::table('transaksi');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $tanggalMulai   = $request->tanggal_mulai . ' 00:00:00';
            $tanggalSelesai = $request->tanggal_selesai . ' 23:59:59';
            $query->whereBetween('waktu_transaksi', [$tanggalMulai, $tanggalSelesai]);
        }

        $statusCountsRaw = $query->select('keterangan', DB::raw('count(*) as total'))
            ->groupBy('keterangan')
            ->get();

        $statusCounts = [];
        foreach ($statusCountsRaw as $row) {
            $key                = strtolower(trim($row->keterangan));
            $statusCounts[$key] = $row->total;
        }

        $chartData = [];
        foreach ($statusOrder as $status) {
            $key         = strtolower(trim($status));
            $chartData[] = $statusCounts[$key] ?? 0;
        }

        return response()->json([
            'data' => $chartData,
        ]);
    }

    public function produkTerlaris(Request $request)
    {
        $query = DB::table('transaksi_detail as td')
            ->join('transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('products as p', 'td.barang_id', '=', 'p.id')
            ->select(
                'td.barang_id',
                'p.kode_barang',
                'p.nama_barang',
                DB::raw('COUNT(td.barang_id) as jumlah_transaksi'),
                DB::raw('SUM(td.qty) as total_qty'),
                DB::raw('SUM(td.qty * td.harga) as total_penjualan'),
                DB::raw('MAX(p.stok) as stok_terakhir'),
                'p.harga as harga_satuan'
            )
            ->where('t.keterangan', '=', 'selesai');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $tanggalMulai   = $request->tanggal_mulai . ' 00:00:00';
            $tanggalSelesai = $request->tanggal_selesai . ' 23:59:59';
            $query->whereBetween('t.waktu_transaksi', [$tanggalMulai, $tanggalSelesai]);
        }

        $query->groupBy(
            'td.barang_id',
            'p.kode_barang',
            'p.nama_barang',
            'p.harga'
        )
            ->orderByDesc('total_qty');

        return datatables()->of($query)
            ->addIndexColumn()
            ->editColumn('total_penjualan', function ($row) {
                return 'Rp ' . number_format($row->total_penjualan, 0, ',', '.');
            })
            ->editColumn('harga_satuan', function ($row) {
                return 'Rp ' . number_format($row->harga_satuan, 0, ',', '.');
            })
            ->make(true);
    }

    public function exportDetail($tgl_awal, $tgl_akhir)
    {
        $error_level = error_reporting();
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        ob_end_clean();
        ob_start();

        try {
            $awal_decoded   = base64_decode($tgl_awal);
            $akhir_decoded  = base64_decode($tgl_akhir);

            $query = DB::table('transaksi as t')
                ->join('transaksi_detail as td', 't.id', '=', 'td.transaksi_id')
                ->join('products as p', 'td.barang_id', '=', 'p.id')
                ->leftJoin('users as u', 't.pelanggan_id', '=', 'u.id')
                ->select(
                    't.id as no_transaksi',
                    't.waktu_transaksi',
                    'u.nama as nama_pelanggan',
                    't.total',
                    't.keterangan as status_transaksi',
                    'td.qty',
                    'td.harga',
                    DB::raw('td.qty * td.harga as subtotal'),
                    'p.kode_barang',
                    'p.nama_barang',
                    'p.harga as harga_satuan'
                );

            if ($awal_decoded != 'ALL' && $akhir_decoded != 'ALL') {
                $query->whereBetween('t.waktu_transaksi', [
                    Carbon::parse($awal_decoded)->startOfDay(),
                    Carbon::parse($akhir_decoded)->endOfDay(),
                ]);
            }

            if ($status_decoded != 'ALL') {
                $query->where('t.keterangan', $status_decoded);
            }

            $query->orderBy('t.id', 'asc')->orderBy('td.id', 'asc');

            $results = $query->get();

            $nama_file = 'Laporan_Penjualan_Detail_' . date('Ymd_His') . '.xlsx';
            $headings  = [
                'No.', 'ID Transaksi', 'Tanggal', 'Pelanggan', 'Status', 'Kode Barang', 'Nama Barang',
                'Harga Satuan', 'Qty', 'Subtotal', 'Total Transaksi',
            ];

            $data          = [];
            $no            = 1;
            $lastTransaksi = null;

            foreach ($results as $row) {
                $noCol = '';
                if ($row->no_transaksi !== $lastTransaksi) {
                    $noCol = $no;
                    $no++;
                    $lastTransaksi = $row->no_transaksi;
                }

                $data[] = [
                    $noCol,
                    $row->no_transaksi,
                    $row->waktu_transaksi ? Carbon::parse($row->waktu_transaksi)->format('d-m-Y H:i') : '-',
                    $row->nama_pelanggan,
                    $row->status_transaksi,
                    $row->kode_barang,
                    $row->nama_barang,
                    'Rp ' . number_format($row->harga_satuan, 0, ',', '.'),
                    $row->qty,
                    'Rp ' . number_format($row->subtotal, 0, ',', '.'),
                    $row->total ? 'Rp ' . number_format($row->total, 0, ',', '.') : '-',
                ];
            }

            return \Maatwebsite\Excel\Facades\Excel::download(new class($data, $headings) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle, \Maatwebsite\Excel\Concerns\WithEvents
            {
                private $data;
                private $headings;

                public function __construct($data, $headings)
                {
                    $this->data     = $data;
                    $this->headings = $headings;
                }

                public function array(): array
                {
                    return $this->data;
                }

                public function headings(): array
                {
                    return $this->headings;
                }

                public function title(): string
                {
                    return 'Detail Penjualan';
                }

                public function registerEvents(): array
                {
                    return [
                        \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                            $cellRange = 'A1:K1';
                            $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                        },
                    ];
                }
            }, $nama_file);

        } catch (\Throwable $e) {
            dd(
                "TERJADI ERROR SAAT EKSPOR:",
                "Pesan: " . $e->getMessage(),
                "File: " . $e->getFile(),
                "Baris: " . $e->getLine()
            );
        }
    }

    public function detail($id): JsonResponse
    {
        $transaksi = DB::table('transaksi')
            ->leftJoin('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
            ->leftJoin('users', 'transaksi.pelanggan_id', '=', 'users.id')
            ->select(
                'transaksi.*',
                'pelanggan.nama as nama_pelanggan',
                'users.nama as nama_user'
            )
            ->where('transaksi.id', $id)
            ->where('transaksi.keterangan', 'selesai')
            ->first();

        if (! $transaksi) {
            abort(404, 'Transaksi tidak ditemukan atau belum selesai');
        }

        $detail = DB::table('transaksi_detail')
            ->join('products', 'transaksi_detail.barang_id', '=', 'products.id')
            ->select(
                'products.nama_barang as produk_nama',
                'transaksi_detail.harga',
                'transaksi_detail.qty',
                DB::raw('transaksi_detail.qty * transaksi_detail.harga as subtotal')
            )
            ->where('transaksi_detail.transaksi_id', $id)
            ->get();

        return response()->json([
            'transaksi' => $transaksi,
            'detail'    => $detail,
        ]);
    }
}
