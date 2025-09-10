@extends('penjual.dashboard_penjual')
@section('penjual')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Riwayat Transaksi</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Riwayat Transaksi</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl-transaksi" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Transaksi</th>
                                <th>Waktu Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
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

    <!-- Modal Detail Transaksi -->
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
    <script>
        function initTransaksiTable() {
            $('#tbl-transaksi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('transaksi.riwayat') }}",
                    type: 'GET',
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
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }

        function showDetailModal(transaksiId) {
            $('#btnTolakTransaksi, #btnSetujuiTransaksi').data('transaksi-id', transaksiId);
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
            initTransaksiTable();

            $(document).on('click', '#btnLihatBukti', function() {
                tampilkanBuktiPembayaran();
            });
        });
    </script>
@endsection
