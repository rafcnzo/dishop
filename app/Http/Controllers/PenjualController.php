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
            'transaksi'   => DB::table('transaksi')->count(),
            'total30hari' => DB::table('transaksi')
                ->whereBetween('waktu_transaksi', [
                    now()->startOfMonth()->toDateString(),
                    now()->toDateString(),
                ])->sum('total'),
            'totalorders' => DB::table('transaksi')->sum('total'),
            'totaltoday'  => DB::table('transaksi')
                ->whereDate('waktu_transaksi', now()->toDateString())
                ->sum('total'),
        ];

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
        return view('penjual.laporan.index');
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
            );

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            // PERBAIKAN DI SINI
            $tanggalMulai   = $request->tanggal_mulai . ' 00:00:00';
            $tanggalSelesai = $request->tanggal_selesai . ' 23:59:59';
            $query->whereBetween('transaksi.waktu_transaksi', [$tanggalMulai, $tanggalSelesai]);
        }

        if ($request->filled('status')) {
            $query->where('transaksi.keterangan', $request->status);
        }

        // Fix: Make sure DataTables ordering uses the correct column name
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('waktu_transaksi', function ($row) {
                return Carbon::parse($row->waktu_transaksi)->format('d/m/Y H:i');
            })
            ->editColumn('pelanggan', function ($row) {
                return $row->nama_pelanggan ? $row->nama_pelanggan : 'Guest';
            })
            ->editColumn('total_formatted', function ($row) {
                return 'Rp ' . number_format($row->total, 0, ',', '.');
            })
            ->editColumn('status_badge', function ($row) {
                $badgeClass = match ($row->keterangan) {
                    'selesai'    => 'badge bg-success',
                    'pending'    => 'badge bg-warning',
                    'dibatalkan' => 'badge bg-danger',
                    default      => 'badge bg-secondary'
                };
                return '<span class="' . $badgeClass . '">' . ucfirst($row->keterangan) . '</span>';
            })
            ->editColumn('metode_bayar', function ($row) {
                return ucfirst(str_replace('_', ' ', $row->metode_bayar));
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-info" onclick="viewDetail(' . $row->id . ')" title="Detail">
                            <i class="bx bx-show"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-success" onclick="printInvoice(' . $row->id . ')" title="Print">
                            <i class="bx bx-printer"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['status_badge', 'action'])
        // Explicitly set the order columns to match the actual DB columns
            ->orderColumn('waktu_transaksi', 'transaksi.waktu_transaksi $1')
            ->make(true);
    }

    public function chartPenjualan(Request $request): JsonResponse
    {
        $startDate = $request->tanggal_mulai ?? now()->startOfMonth()->format('Y-m-d');
        $endDate   = $request->tanggal_selesai ?? now()->format('Y-m-d');

        // Ambil total penjualan per hari (jumlah transaksi * total per transaksi)
        $data = DB::table('transaksi')
            ->selectRaw('DATE(waktu_transaksi) as tanggal, SUM(total) as total_penjualan')
            ->where('pelanggan_id', auth()->id())
            ->where('keterangan', 'selesai')
            ->whereBetween('waktu_transaksi', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total_penjualan', 'tanggal');

        // Buat periode tanggal harian
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
            'diterima',
            'menunggu konfirmasi',
            'diproses',
        ];

        $query = DB::table('transaksi');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $tanggalMulai   = $request->tanggal_mulai . ' 00:00:00';
            $tanggalSelesai = $request->tanggal_selesai . ' 23:59:59';
            $query->whereBetween('waktu_transaksi', [$tanggalMulai, $tanggalSelesai]);
        }

        // Ambil status dan total, lalu normalisasi ke lowercase dan trim untuk pencocokan tidak case sensitive
        $statusCountsRaw = $query->select('keterangan', DB::raw('count(*) as total'))
            ->groupBy('keterangan')
            ->get();

        // Buat array mapping status yang sudah dinormalisasi
        $statusCounts = [];
        foreach ($statusCountsRaw as $row) {
            // Normalisasi: lowercase dan trim spasi
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
        // Query produk terlaris sesuai instruksi prompt
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
            );

        // Filter keterangan jika ada di request, jika tidak ada, jangan filter
        if ($request->filled('status')) {
            $query->where('t.keterangan', $request->status);
        }

        // Filter tanggal jika ada
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

    public function exportDetail($tgl_awal, $tgl_akhir, $status)
    {
        $error_level = error_reporting();
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        ob_end_clean();
        ob_start();

        try {
            $awal_decoded   = base64_decode($tgl_awal);
            $akhir_decoded  = base64_decode($tgl_akhir);
            $status_decoded = base64_decode($status);

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

            // Gunakan Laravel Excel versi 3.x ke atas (Maatwebsite\Excel\Facades\Excel)
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
                            // Membuat baris heading menjadi bold
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
            ->first();

        if (! $transaksi) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $detail = DB::table('transaksi_detail')
            ->join('products', 'transaksi_detail.barang_id', '=', 'products.id')
            ->select(
                'products.nama_barang as produk_nama',
                'transaksi_detail.harga',
                'transaksi_detail.qty',
                DB::raw('transaksi_detail.qty * transaksi_detail.harga as subtotal')
            )
            ->get();

        return response()->json([
            'transaksi' => $transaksi,
            'detail'    => $detail,
        ]);
    }

    public function invoice($id)
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
            ->first();

        if (! $transaksi) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $detail = DB::table('transaksi_detail')
            ->join('products', 'transaksi_detail.barang_id', '=', 'products.id')
            ->select(
                'products.nama_barang as produk_nama',
                'transaksi_detail.harga',
                'transaksi_detail.qty',
                DB::raw('transaksi_detail.harga * transaksi_detail.qty as subtotal')
            )
            ->where('transaksi_detail.transaksi_id', $id)
            ->get();

        return view('penjual.laporan.invoice', [
            'transaksi' => $transaksi,
            'detail'    => $detail,
        ]);
    }

    public function laporanPeriode(Request $request)
    {
        $periode = $request->periode ?? 'bulanan';
        $tahun   = $request->tahun ?? now()->year;
        $bulan   = $request->bulan ?? now()->month;

        $query = DB::table('transaksi')
            ->where('pelanggan_id', auth()->id())
            ->where('keterangan', 'selesai');

        switch ($periode) {
            case 'harian':
                $data = $query->whereYear('waktu_transaksi', $tahun)
                    ->whereMonth('waktu_transaksi', $bulan)
                    ->selectRaw('DAY(waktu_transaksi) as periode, SUM(total) as total')
                    ->groupBy('periode')
                    ->orderBy('periode')
                    ->get();
                break;

            case 'mingguan':
                $data = $query->whereYear('waktu_transaksi', $tahun)
                    ->selectRaw('WEEK(waktu_transaksi) as periode, SUM(total) as total')
                    ->groupBy('periode')
                    ->orderBy('periode')
                    ->get();
                break;

            case 'bulanan':
                $data = $query->whereYear('waktu_transaksi', $tahun)
                    ->selectRaw('MONTH(waktu_transaksi) as periode, SUM(total) as total')
                    ->groupBy('periode')
                    ->orderBy('periode')
                    ->get();
                break;

            case 'tahunan':
                $data = $query
                    ->selectRaw('YEAR(waktu_transaksi) as periode, SUM(total) as total')
                    ->groupBy('periode')
                    ->orderBy('periode')
                    ->get();
                break;
            default:
                $data = collect();
        }

        return response()->json($data);
    }

    public function analytics(Request $request)
    {
        $startDate = now()->startOfMonth();
        $endDate   = now();

        // Penjualan hari ini
        $penjualanHariIni = DB::table('transaksi')
            ->where('pelanggan_id', auth()->id())
            ->where('keterangan', 'selesai')
            ->whereDate('waktu_transaksi', now()->toDateString())
            ->sum('total');

        // Penjualan bulan ini
        $penjualanBulanIni = DB::table('transaksi')
            ->where('pelanggan_id', auth()->id())
            ->where('keterangan', 'selesai')
            ->whereBetween('waktu_transaksi', [$startDate, $endDate])
            ->sum('total');

        // Penjualan bulan lalu
        $penjualanBulanLalu = DB::table('transaksi')
            ->where('pelanggan_id', auth()->id())
            ->where('keterangan', 'selesai')
            ->whereBetween('waktu_transaksi', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth(),
            ])
            ->sum('total');

        // Persentase pertumbuhan
        $growthPercentage = 0;
        if ($penjualanBulanLalu > 0) {
            $growthPercentage = (($penjualanBulanIni - $penjualanBulanLalu) / $penjualanBulanLalu) * 100;
        }

        // Top produk bulan ini
        $topProduk = DB::table('transaksi_detail')
            ->join('transaksi', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->join('products', 'transaksi_detail.barang_id', '=', 'products.id')
            ->where('transaksi.keterangan', 'selesai')
            ->whereBetween('transaksi.waktu_transaksi', [$startDate, $endDate])
            ->select(
                'transaksi_detail.barang_id',
                'products.nama_barang',
                DB::raw('SUM(transaksi_detail.qty) as total_qty'),
                DB::raw('SUM(transaksi_detail.harga * transaksi_detail.qty) as total_penjualan')
            )
            ->groupBy('transaksi_detail.barang_id', 'products.nama_barang')
            ->orderByDesc('total_penjualan')
            ->limit(5)
            ->get();

        return response()->json([
            'penjualan_hari_ini'   => $penjualanHariIni,
            'penjualan_bulan_ini'  => $penjualanBulanIni,
            'penjualan_bulan_lalu' => $penjualanBulanLalu,
            'growth_percentage'    => round($growthPercentage, 2),
            'top_produk'           => $topProduk->map(function ($item) {
                return [
                    'nama'      => $item->nama_barang,
                    'qty'       => $item->total_qty,
                    'penjualan' => $item->total_penjualan,
                ];
            }),
        ]);
    }
}
