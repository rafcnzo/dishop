<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $transaksi->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        :root {
            --color-primary: #1a237e;
            --color-secondary: #5c6bc0;
            --color-dark: #2c3e50;
            --color-medium: #7f8c8d;
            --color-light: #ecf0f1;
            --color-white: #ffffff;
            --color-danger: #c0392b;
            --color-danger-bg: #f2dede;
            --base-font-size: 11pt;
            --border-radius: 8px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            color: var(--color-dark);
            font-size: var(--base-font-size);
            line-height: 1.6;
            padding: 20px;
        }

        .invoice-wrapper {
            width: 297mm;
            min-height: 210mm;
            margin: 0 auto;
            background: var(--color-white);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            padding: 25mm;
            display: flex;
            flex-direction: column;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--color-light);
            margin-bottom: 20px;
        }

        .company-info .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 10px;
        }

        .company-info p {
            font-size: 0.9em;
            color: var(--color-medium);
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-details h1 {
            font-size: 36px;
            color: var(--color-primary);
            margin-bottom: 5px;
        }

        .invoice-details .invoice-id {
            font-size: 1.1em;
            color: var(--color-medium);
            margin-bottom: 15px;
        }

        .status {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 0.9em;
        }

        .status-rejected {
            background-color: var(--color-danger-bg);
            color: var(--color-danger);
            border: 1px solid var(--color-danger);
        }

        .billing-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .billing-box {
            width: 48%;
            background-color: #fdfdfd;
            border: 1px solid var(--color-light);
            padding: 20px;
            border-radius: var(--border-radius);
        }

        .billing-box h3 {
            font-size: 1.1em;
            color: var(--color-secondary);
            border-bottom: 1px solid var(--color-light);
            padding-bottom: 8px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .billing-box p {
            margin-bottom: 5px;
            font-size: 0.95em;
        }

        .billing-box p strong {
            display: inline-block;
            width: 120px;
            font-weight: 500;
            color: var(--color-medium);
        }

        .billing-box .customer-name {
            font-weight: 600;
            color: var(--color-dark);
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .items-table th {
            font-weight: 600;
            padding: 15px;
            text-align: left;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.85em;
        }

        .items-table th.text-center,
        .items-table td.text-center {
            text-align: center;
        }

        .items-table th.text-right,
        .items-table td.text-right {
            text-align: right;
        }

        .items-table tbody td {
            padding: 15px;
            border-bottom: 1px solid var(--color-light);
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .items-table .item-name {
            font-weight: 600;
        }

        .invoice-summary-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 20px;
            border-top: 2px solid var(--color-light);
        }

        .payment-info {
            font-size: 0.9em;
        }

        .payment-info h4 {
            font-size: 1.1em;
            color: var(--color-secondary);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .payment-info p {
            color: var(--color-medium);
        }

        .totals {
            width: 300px;
            text-align: right;
        }

        .totals p {
            font-size: 1em;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .totals p span {
            color: var(--color-medium);
        }

        .totals p.grand-total {
            font-size: 1.4em;
            font-weight: 700;
            color: var(--color-primary);
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--color-light);
        }

        .totals p.grand-total span {
            color: var(--color-primary);
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }

            body {
                padding: 0;
                background-color: var(--color-white);
            }

            .invoice-wrapper {
                box-shadow: none;
                width: 297mm;
                height: 210mm;
                padding: 20mm;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-wrapper">
        <header class="invoice-header">
            <div class="company-info">
                <div class="logo">{{ $company['name'] }}</div>
                <p>{{ $company['address'] }}</p>
                <p>Telp: {{ $company['phone'] }} | Email: {{ $company['email'] }}</p>
                <p>NPWP: {{ $company['npwp'] }}</p>
            </div>
            <div class="invoice-details">
                <h1>INVOICE</h1>
                <div class="invoice-id">#{{ $transaksi->id }}</div>
                @if ($pembayaran && isset($pembayaran->status) && $pembayaran->status == 'ditolak')
                    <div class="status status-rejected">PEMBAYARAN DITOLAK</div>
                @endif
            </div>
        </header>

        <section class="billing-info">
            <div class="billing-box">
                <h3>Pelanggan</h3>
                <p class="customer-name">{{ $transaksi->nama_pelanggan }}</p>
                <p>Alamat: {{ $transaksi->alamat_pelanggan }}</p>
                <p>Telepon: {{ $transaksi->telp_pelanggan }}</p>
            </div>
            <div class="billing-box">
                <h3>Detail Transaksi</h3>
                <p>
                    <strong>Tanggal Invoice:</strong>
                    {{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->translatedFormat('d F Y, H:i') }}
                </p>
                <p>
                    <strong>Tanggal Bayar:</strong>
                    @if ($pembayaran)
                        {{ \Carbon\Carbon::parse($pembayaran->waktu)->translatedFormat('d F Y, H:i') }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Metode Bayar:</strong>
                    @if ($pembayaran)
                        {{ strtoupper($pembayaran->metode) }}
                    @else
                        -
                    @endif
                </p>
                <p>
                    <strong>Catatan:</strong>
                    @if ($pembayaran && isset($pembayaran->status) && $pembayaran->status == 'ditolak')
                        Pembayaran ditolak
                    @elseif($pembayaran && isset($pembayaran->catatan))
                        {{ $pembayaran->catatan }}
                    @else
                        -
                    @endif
                </p>
            </div>
        </section>

        <main>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 5%;" class="text-center">No.</th>
                        <th style="width: 45%;">Deskripsi</th>
                        <th style="width: 15%;" class="text-center">Kuantitas</th>
                        <th style="width: 15%;" class="text-right">Harga Satuan</th>
                        <th style="width: 20%;" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i => $item)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td class="item-name">{{ $item->nama_barang }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($item->total_item, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>

        <footer class="invoice-summary-footer">
            <div class="payment-info">
                <h4>Informasi Pembayaran Customer</h4>
                <p>Bank Transfer</p>
                <p>No. Rekening: 
                    @if (!empty($no_rek_customer))
                        {{ $no_rek_customer }}
                    @else
                        -
                    @endif
                </p>
                <p>Atas Nama: 
                    @if (!empty($atas_nama_customer))
                        {{ $atas_nama_customer }}
                    @else
                        -
                    @endif
                </p>
                <br>
                <p>Hormat kami, <br>
                    <strong>
                        @if ($sales)
                            {{ $sales->nama }}
                        @else
                            Penjual (Sistem)
                        @endif
                    </strong>
                </p>
            </div>
            <div class="totals">
                <p><span>Subtotal:</span> <strong>Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</strong>
                </p>
                <p><span>Diskon:</span> <strong>Rp {{ number_format($summary['diskon'], 0, ',', '.') }}</strong></p>
                <p class="grand-total"><span>Total Dibayar:</span> <strong>Rp
                        {{ number_format($summary['total'], 0, ',', '.') }}</strong></p>
            </div>
        </footer>
    </div>

    <script>
        // Ketika halaman selesai dimuat, langsung panggil print
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
