@extends('penjual.dashboard_penjual')
@section('penjual')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Laporan Penjualan</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Laporan Penjualan</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />

        <!-- Filter Section -->
        <div class="card mb-3">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="fs-5 me-2"><i class="bx bx-filter-alt"></i></div>
                    <div class="fs-5">Filter Laporan</div>
                </div>
            </div>
            <div class="card-body">
                <form id="filter-form">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                value="{{ request('tanggal_mulai', date('Y-m-01')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                value="{{ request('tanggal_selesai', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-primary me-2" onclick="applyFilter()">
                                <i class="bx bx-search"></i> Filter
                            </button>
                            <button type="button" class="btn btn-secondary me-2" onclick="resetFilter()">
                                <i class="bx bx-refresh"></i> Reset
                            </button>
                            <button type="button" class="btn btn-success" onclick="exportData()">
                                <i class="bx bx-download"></i> Export
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-3">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="fs-5 me-2"><i class="bx bx-line-chart"></i></div>
                            <div class="fs-5">Grafik Penjualan Harian</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chartPenjualan" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="fs-5 me-2"><i class="bx bx-pie-chart-alt-2"></i></div>
                            <div class="fs-5">Status Transaksi</div>
                        </div>
                    </div>
                    <div class="card-body" style="position: relative; height:400px">
                        <div id="chartStatus" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="card mb-3">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="fs-5 me-2"><i class="bx bx-trending-up"></i></div>
                    <div class="fs-5">Top 10 Produk Terlaris</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl-produk-terlaris" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Qty Terjual</th>
                                <th>Total Penjualan</th>
                                <th>Stok Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detail Transaksi -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="fs-5 me-2"><i class="bx bx-list-ul"></i></div>
                    <div class="fs-5">Detail Transaksi</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl-laporan" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Metode Bayar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetailTransaksi" tabindex="-1" aria-labelledby="modalDetailTransaksiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailTransaksiLabel">Detail Transaksi <span
                            id="detailTransaksiId"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Pelanggan:</strong> <span id="detailPelanggan"></span><br>
                        <strong>Waktu Transaksi:</strong> <span id="detailWaktu"></span><br>
                        <strong>Total:</strong> <span id="detailTotal"></span>
                    </div>
                    <div class="table-responsive">
                        <table id="tbl-detail-barang" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" id="btnLihatBukti">Lihat Bukti Transaksi</button>
                    </div>
                    <div id="buktiTransaksiContainer" class="mt-3" style="display:none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- CDN ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        let chartPenjualan, chartStatus;
        let tableLaporan, tableProdukTerlaris;

        function initCharts() {
            var optionsPenjualan = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Penjualan Harian',
                    data: []
                }],
                xaxis: {
                    categories: [],
                    labels: {
                        style: {
                            fontSize: '13px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    }
                },
                stroke: {
                    curve: 'smooth'
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    }
                },
                colors: ['#4bc0c0'],
                dataLabels: {
                    enabled: false
                }
            };
            chartPenjualan = new ApexCharts(document.querySelector("#chartPenjualan"), optionsPenjualan);
            chartPenjualan.render();

            var optionsStatus = {
                chart: {
                    type: 'donut',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                labels: [
                    'Selesai',
                    'Pending',
                    'Dibatalkan',
                    'Menunggu Konfirmasi'
                ],
                series: [0, 0, 0, 0],
                colors: [
                    'rgba(54, 162, 235, 0.8)', // Selesai
                    'rgba(255, 206, 86, 0.8)', // Pending
                    'rgba(255, 99, 132, 0.8)', // Dibatalkan
                    'rgba(153, 102, 255, 0.8)' // Menunggu Konfirmasi
                ],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " transaksi";
                        }
                    }
                }
            };
            chartStatus = new ApexCharts(document.querySelector("#chartStatus"), optionsStatus);
            chartStatus.render();
        }

        function initTables() {
            // Table Laporan
            tableLaporan = $('#tbl-laporan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan.data') }}",
                    type: 'GET',
                    data: function(d) {
                        d.tanggal_mulai = $('#tanggal_mulai').val();
                        d.tanggal_selesai = $('#tanggal_selesai').val();
                    },
                    beforeSend: function() {
                        showLoading();
                    },
                    complete: function() {
                        hideLoading();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'waktu_transaksi',
                        name: 'waktu_transaksi'
                    },
                    {
                        data: 'pelanggan',
                        name: 'pelanggan'
                    },
                    {
                        data: 'total_formatted',
                        name: 'total'
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'metode_bayar',
                        name: 'metode_bayar'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        exportable: false, // kolom action tidak diexport
                        printable: false // kolom action tidak diprint
                    }
                ],
                order: [
                    [2, 'desc']
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)' // kolom terakhir (action) tidak diexport
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            // Table Produk Terlaris
            tableProdukTerlaris = $('#tbl-produk-terlaris').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan.produk-terlaris') }}",
                    type: 'GET',
                    data: function(d) {
                        d.tanggal_mulai = $('#tanggal_mulai').val();
                        d.tanggal_selesai = $('#tanggal_selesai').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'harga_satuan',
                        name: 'harga_satuan'
                    },
                    {
                        data: 'total_qty',
                        name: 'total_qty'
                    },
                    {
                        data: 'total_penjualan',
                        name: 'total_penjualan'
                    },
                    {
                        data: 'stok_terakhir',
                        name: 'stok_terakhir'
                    }
                ],
                order: [
                    [4, 'desc']
                ],
                pageLength: 10,
                lengthChange: false,
                searching: false,
                info: false
            });
        }

        function loadChartData() {
            // Load chart penjualan harian
            $.ajax({
                url: "{{ route('laporan.chart-penjualan') }}",
                type: 'GET',
                data: {
                    tanggal_mulai: $('#tanggal_mulai').val(),
                    tanggal_selesai: $('#tanggal_selesai').val(),
                },
                success: function(response) {
                    chartPenjualan.updateOptions({
                        xaxis: {
                            categories: response.labels
                        }
                    });
                    chartPenjualan.updateSeries([{
                        name: 'Penjualan Harian',
                        data: response.data
                    }]);
                }
            });

            // Load chart status transaksi
            $.ajax({
                url: "{{ route('laporan.chart-status') }}",
                type: 'GET',
                data: {
                    tanggal_mulai: $('#tanggal_mulai').val(),
                    tanggal_selesai: $('#tanggal_selesai').val()
                },
                success: function(response) {
                    // Update ApexChart Status
                    chartStatus.updateSeries(response.data);
                }
            });
        }

        function applyFilter() {
            // Validate date range
            const startDate = new Date($('#tanggal_mulai').val());
            const endDate = new Date($('#tanggal_selesai').val());

            if (startDate > endDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai!'
                });
                return;
            }

            loadChartData();
            tableLaporan.ajax.reload();
            tableProdukTerlaris.ajax.reload();
        }

        function resetFilter() {
            $('#tanggal_mulai').val('{{ date('Y-m-01') }}');
            $('#tanggal_selesai').val('{{ date('Y-m-d') }}');
            $('#status').val('');

            applyFilter();
        }

        function exportData() {
            const tanggalMulai = $('#tanggal_mulai').val();
            const tanggalSelesai = $('#tanggal_selesai').val();

            const tglAwalEncoded = btoa(tanggalMulai ? tanggalMulai : 'ALL');
            const tglAkhirEncoded = btoa(tanggalSelesai ? tanggalSelesai : 'ALL');

            const url = "{{ url('laporan/export-detail') }}/" + tglAwalEncoded + "/" + tglAkhirEncoded;

            window.open(url, '_blank');
        }

        function viewDetail(transaksiId) {
            $('#detailPelanggan, #detailWaktu, #detailTotal').text('');
            $('#tbl-detail-barang tbody').empty();
            $('#buktiTransaksiContainer').hide().empty();

            const url = `{{ url('/transaksi/detail') }}/${transaksiId}`;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        const trx = data.transaksi;
                        const pembayaran = data.pembayaran;

                        $('#detailTransaksiId').text(`#${trx.id}`);
                        $('#detailPelanggan').text(trx.pelanggan);
                        $('#detailWaktu').text(new Date(trx.waktu_transaksi).toLocaleString('id-ID'));

                        const totalFormatted = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(trx.total);
                        $('#detailTotal').text(totalFormatted);

                        const detailTableBody = $('#tbl-detail-barang tbody');
                        detailTableBody.empty();
                        data.detail_items.forEach((item, idx) => {
                            const subtotal = item.qty * item.harga;
                            const row = `<tr>
                                <td>${idx + 1}</td>
                                <td>${item.nama_barang}</td>
                                <td>${item.qty}</td>
                                <td>${new Intl.NumberFormat('id-ID').format(item.harga)}</td>
                                <td>${new Intl.NumberFormat('id-ID').format(subtotal)}</td>
                            </tr>`;
                            detailTableBody.append(row);
                        });

                        if (pembayaran) {
                            const buktiUrl =
                                `{{ asset('storage/bukti_pembayaran') }}/${pembayaran.bukti_pembayaran}`;
                            $('#btnLihatBukti').show().data('bukti-url', buktiUrl);
                        } else {
                            $('#btnLihatBukti').hide();
                        }

                        $('#modalDetailTransaksi').modal('show');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('Gagal memuat detail transaksi. Silakan coba lagi.');
                }
            });
        }

        function tampilkanBuktiPembayaran() {
            const url = $('#btnLihatBukti').data('bukti-url');
            const container = $('#buktiTransaksiContainer');

            container.html(
                `<hr><h5>Bukti Pembayaran:</h5><img src="${url}" class="img-fluid" alt="Bukti Pembayaran">`
            );
            container.slideDown();
        }

        $(document).ready(function() {
            showLoading();
            initCharts();
            initTables();
            loadChartData();

            setInterval(function() {
                applyFilter();
            }, 300000);

            $(document).on('click', '#btnLihatBukti', function() {
                tampilkanBuktiPembayaran();
            });
        });
    </script>
@endsection
