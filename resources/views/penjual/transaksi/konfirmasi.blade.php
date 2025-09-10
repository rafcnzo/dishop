@extends('penjual.dashboard_penjual')
@section('penjual')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Konfirmasi Transaksi</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Konfirmasi Transaksi</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl-konfirmasi" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
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
    </div> <!-- end page-content -->

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
                                <!-- Data diisi via ajax -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" id="btnLihatBukti">Lihat Bukti Transaksi</button>
                    </div>
                    <div id="buktiTransaksiContainer" class="mt-3" style="display:none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnTolakTransaksi">Tolak</button>
                    <button type="button" class="btn btn-success" id="btnSetujuiTransaksi">Setujui</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Alasan Penolakan -->
    <div class="modal fade" id="modalAlasanTolak" tabindex="-1" aria-labelledby="modalAlasanTolakLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlasanTolakLabel">Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="alasanTolak" class="form-label">Silakan masukkan alasan penolakan:</label>
                        <textarea class="form-control" id="alasanTolak" rows="3" placeholder="Contoh: Bukti transfer tidak valid"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnKirimTolak">Kirim Penolakan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function initKonfirmasiTransaksiTable() {
            $('#tbl-konfirmasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('transaksi.konfirmasi') }}",
                    type: 'GET',
                    beforeSend: function() {
                        showLoading();
                    },
                    complete: function() {
                        hideLoading();
                    }
                },
                columns: [{
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
                        data: 'status_pembayaran',
                        name: 'status_pembayaran'
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

        function handleTolakTransaksi() {
            $(document).on('click', '#btnTolakTransaksi', function() {
                var transaksiId = $(this).data('transaksi-id');
                $('#btnKirimTolak').data('transaksi-id', transaksiId);
                $('#alasanTolak').val('');
                $('#modalAlasanTolak').modal('show');
            });
        }

        function handleSetujuiTransaksi() {
            $(document).on('click', '#btnSetujuiTransaksi', function() {
                var transaksiId = $(this).data('transaksi-id');
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyetujui transaksi ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Setujui',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/transaksi/setujui/${transaksiId}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                showLoading();
                            },
                            success: function(res) {
                                hideLoading();
                                if (res.success) {
                                    Swal.fire('Berhasil', 'Transaksi berhasil disetujui.',
                                        'success');
                                    $('#modalDetailTransaksi').modal('hide');
                                    $('#tbl-konfirmasi').DataTable().ajax.reload();
                                } else {
                                    Swal.fire('Gagal', res.message || 'Terjadi kesalahan.',
                                        'error');
                                }
                            },
                            error: function(xhr) {
                                hideLoading();
                                Swal.fire('Gagal', 'Terjadi kesalahan pada server.', 'error');
                            }
                        });
                    }
                });
            });
        }

        function handleKirimTolak() {
            $(document).on('click', '#btnKirimTolak', function() {
                var transaksiId = $(this).data('transaksi-id');
                var alasan = $('#alasanTolak').val().trim();

                if (alasan === '') {
                    Swal.fire('Peringatan', 'Alasan penolakan harus diisi.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Penolakan',
                    text: 'Apakah Anda yakin ingin menolak transaksi ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/transaksi/tolak/${transaksiId}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                alasan: alasan
                            },
                            beforeSend: function() {
                                showLoading();
                            },
                            success: function(res) {
                                hideLoading();
                                if (res.success) {
                                    Swal.fire('Ditolak', 'Transaksi berhasil ditolak.',
                                        'success');
                                    $('#modalAlasanTolak').modal('hide');
                                    $('#modalDetailTransaksi').modal('hide');
                                    $('#tbl-konfirmasi').DataTable().ajax.reload();
                                } else {
                                    Swal.fire('Gagal', res.message || 'Terjadi kesalahan.',
                                        'error');
                                }
                            },
                            error: function(xhr) {
                                hideLoading();
                                Swal.fire('Gagal', 'Terjadi kesalahan pada server.', 'error');
                            }
                        });
                    }
                });
            });
        }

        $(document).ready(function() {
            initKonfirmasiTransaksiTable();

            $(document).on('click', '#btnLihatBukti', function() {
                tampilkanBuktiPembayaran();
            });

            handleTolakTransaksi();
            handleSetujuiTransaksi();
            handleKirimTolak();
        });
    </script>
@endsection
