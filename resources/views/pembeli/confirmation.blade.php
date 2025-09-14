@extends('layouts.app')

@section('title', 'Payment Confirmation')

@push('styles')
    <style>
        /* Color Variables */
        :root {
            --pakistan-green: #1a5f3f;
            --sage: #aabe7f;
            --beige: #c7d2cc;
            --seasalt: #f8f9fa;
            --antiflash-white: #f1f3f4;
        }

        /* Header Styles */
        .confirmation-header {
            background: linear-gradient(135deg, var(--pakistan-green) 0%, var(--sage) 100%);
            position: relative;
            overflow: hidden;
            padding: 4rem 0;
            margin-bottom: 2rem;
        }

        .confirmation-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, rgba(255, 255, 255, 0.1) 75%),
                linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 0.1) 75%);
            background-size: 30px 30px;
            background-position: 0 0, 0 15px, 15px -15px, -15px 0px;
            opacity: 0.3;
        }

        .confirmation-header .container {
            position: relative;
            z-index: 2;
        }

        .confirmation-header h1 {
            color: white;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .confirmation-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* Payment Steps */
        .payment-steps {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(26, 95, 63, 0.1);
            margin-bottom: 2rem;
            border: 1px solid var(--beige);
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--sage);
            z-index: 1;
            transform: translateY(-50%);
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            background: white;
            padding: 0 1rem;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .step.completed .step-number {
            background: var(--sage);
            color: white;
        }

        .step.active .step-number {
            background: var(--pakistan-green);
            color: white;
            box-shadow: 0 0 0 4px rgba(26, 95, 63, 0.2);
        }

        .step-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--pakistan-green);
            text-align: center;
        }

        /* Confirmation Cards */
        .confirmation-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(26, 95, 63, 0.1);
            border: 1px solid var(--beige);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .confirmation-card h3 {
            color: var(--pakistan-green);
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .confirmation-card h3 i {
            font-size: 1.2rem;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .status-badge.pending {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-badge.confirmed {
            background: rgba(40, 167, 69, 0.1);
            color: #155724;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed var(--beige);
            border-radius: 15px;
            padding: 3rem 2rem;
            text-align: center;
            background: var(--seasalt);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: var(--sage);
            background: white;
            transform: translateY(-2px);
        }

        .upload-area.dragover {
            border-color: var(--pakistan-green);
            background: rgba(26, 95, 63, 0.05);
        }

        .upload-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--pakistan-green) 0%, var(--sage) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 2rem;
        }

        .upload-text {
            color: var(--pakistan-green);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .upload-subtext {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* File Preview */
        .file-preview {
            display: none;
            background: white;
            border: 1px solid var(--beige);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .file-preview.show {
            display: flex !important;
            align-items: center;
            gap: 1rem;
        }

        .file-icon {
            width: 50px;
            height: 50px;
            background: var(--pakistan-green);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-weight: 600;
            color: var(--pakistan-green);
            margin-bottom: 0.25rem;
        }

        .file-size {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .file-remove {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .file-remove:hover {
            background: rgba(220, 53, 69, 0.1);
        }

        /* Payment Info */
        .payment-info {
            background: linear-gradient(135deg, var(--seasalt) 0%, white 100%);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid var(--beige);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--beige);
        }

        .info-row:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--pakistan-green);
        }

        .info-label {
            color: #6c757d;
            font-weight: 500;
        }

        .info-value {
            color: var(--pakistan-green);
            font-weight: 600;
        }

        /* Bank Details */
        .bank-details {
            background: rgba(26, 95, 63, 0.05);
            border: 1px solid var(--sage);
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .bank-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .bank-item:last-child {
            margin-bottom: 0;
        }

        .copy-btn {
            background: var(--pakistan-green);
            border: none;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            background: var(--sage);
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--pakistan-green) 0%, var(--sage) 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 95, 63, 0.3);
            color: white;
        }

        .btn-secondary-custom {
            background: transparent;
            border: 2px solid var(--beige);
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: var(--pakistan-green);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-secondary-custom:hover {
            background: var(--beige);
            color: var(--pakistan-green);
            transform: translateY(-2px);
        }

        /* Alert */
        .alert-custom {
            background: rgba(26, 95, 63, 0.1);
            border: 1px solid var(--sage);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .alert-custom i {
            color: var(--pakistan-green);
            margin-right: 0.5rem;
        }

        .alert-custom p {
            color: var(--pakistan-green);
            margin: 0;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .confirmation-header h1 {
                font-size: 2rem;
            }

            .confirmation-card {
                padding: 1.5rem;
            }

            .step-indicator {
                flex-direction: column;
                gap: 1rem;
            }

            .step-indicator::before {
                display: none;
            }

            .upload-area {
                padding: 2rem 1rem;
            }

            .upload-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate__fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate__delay-1s {
            animation-delay: 0.2s;
        }

        .animate__delay-2s {
            animation-delay: 0.4s;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        .row-equal-height {
            display: flex;
            flex-wrap: wrap;
        }

        .card-full-height {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-full-height>.card-body {
            flex-grow: 1;
            /* Memastikan body card mengisi ruang tersisa */
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <div class="confirmation-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="animate__animated animate__fadeInUp">Payment Confirmation</h1>
                    <p class="animate__animated animate__fadeInUp animate__delay-1s">Complete your payment by uploading proof
                        of payment</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="payment-steps animate__animated animate__fadeInUp">
            <div class="step-indicator">
                <div class="step completed">
                    <div class="step-number">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="step-label">Cart Review</div>
                </div>
                <div class="step completed">
                    <div class="step-number">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="step-label">Payment Info</div>
                </div>
                <div class="step active">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
        </div>

        <!-- Alert -->
        <div class="alert-custom animate__animated animate__fadeInUp">
            <i class="fas fa-info-circle"></i>
            <p>Silakan selesaikan pembayaran Anda dan unggah bukti pembayaran di bawah ini. Pesanan Anda akan diproses
                setelah pembayaran diverifikasi.</p>
        </div>

        <div class="row mb-4 row-equal-height">
            <!-- Payment Confirmation Form -->
            <div class="col-lg-8">
                <!-- Order Status -->
                <div class="confirmation-card card-full-height">
                    <div class="card-body">
                        <h3><i class="fas fa-receipt"></i> Status Pesanan</h3>
                        <div class="status-badge pending pulse"><i class="fas fa-clock"></i> Menunggu Pembayaran</div>
                        <div class="alert alert-info mt-3 text-center">
                            <h6 class="alert-heading">Batas Waktu Pembayaran</h6>
                            <div id="countdown-timer" class="fs-4 fw-bold"
                                data-expire-at="{{ $expirationTime->toIso8601String() }}">
                                --:--:--
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>ID Pesanan:</strong> #{{ $order->id }}</p>
                                <p><strong>Tanggal Pesanan:</strong>
                                    {{ \Carbon\Carbon::parse($order->waktu_transaksi)->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Metode Pembayaran:</strong> Transfer Bank</p>
                                <p><strong>Total:</strong> <span class="text-success fw-bold">Rp
                                        {{ number_format($order->total, 0, ',', '.') }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-lg-4">
                <div class="payment-info card-full-height">
                    <div class="card-body d-flex flex-column">
                        <h3><i class="fas fa-shopping-cart"></i> Ringkasan Pesanan</h3>

                        {{-- Loop untuk menampilkan item pesanan --}}
                        @foreach ($orderItems as $item)
                            <div class="info-row">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->image ? asset('upload/images_produk/' . $item->image) : asset('images/no-image.png') }}"
                                        alt="{{ $item->nama_barang }}"
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.9rem;">{{ $item->nama_barang }}</div>
                                        <div class="text-muted small">Jumlah: {{ $item->qty }}</div>
                                    </div>
                                </div>
                                <div class="info-value">Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</div>
                            </div>
                        @endforeach

                        <div class="info-row">
                            <span><strong>Total</strong></span>
                            <span><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></span>
                        </div>

                        {{-- Tombol kembali dihilangkan --}}

                        <div class="alert-custom mt-3">
                            <i class="fas fa-shield-alt"></i>
                            <p>Pembayaran Anda akan diverifikasi dalam 1-2 jam kerja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- KODE BARU YANG SUDAH DIPERBAIKI --}}
        <div class="row mb-3 row-equal-height">

            <div class="col-lg-7">
                {{-- Hapus d-flex align-items-stretch dari kolom --}}
                <div class="confirmation-card card-full-height">
                    {{-- Bungkus konten dengan card-body agar flexbox bekerja --}}
                    <div class="card-body">
                        <h3><i class="fas fa-university"></i> Detail Transfer Bank</h3>
                        <p class="mb-3">Silakan transfer sejumlah total pesanan ke salah satu rekening bank berikut:</p>
                        <div class="bank-details">
                            <div class="bank-item">
                                <span><strong>Bank BCA</strong></span>
                                <span></span>
                            </div>
                            <div class="bank-item">
                                <span>No. Rekening:</span>
                                <span>
                                    1234567890
                                    <button class="copy-btn ms-2" onclick="copyToClipboard('1234567890')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="bank-item">
                                <span>Atas Nama:</span>
                                <span>PT. Online Shop Indonesia</span>
                            </div>
                        </div>
                        <div class="bank-details">
                            <div class="bank-item">
                                <span><strong>Bank Mandiri</strong></span>
                                <span></span>
                            </div>
                            <div class="bank-item">
                                <span>No. Rekening:</span>
                                <span>
                                    0987654321
                                    <button class="copy-btn ms-2" onclick="copyToClipboard('0987654321')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="bank-item">
                                <span>Atas Nama:</span>
                                <span>PT. Online Shop Indonesia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="confirmation-card card-full-height">
                    <div class="card-body d-flex flex-column"> {{-- Tambahkan d-flex flex-column di sini --}}
                        <h3><i class="fas fa-upload"></i> Unggah Bukti Pembayaran</h3>

                        <form id="confirmationForm" action="{{ route('payment.confirm') }}" method="POST"
                            enctype="multipart/form-data" class="flex-grow-1 d-flex flex-column">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            {{-- Konten form (upload area, preview, catatan) --}}
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="upload-text">Klik untuk unggah atau seret file ke sini</div>
                                <div class="upload-subtext">PNG, JPG, PDF maksimal 5MB</div>
                                <input type="file" name="payment_proof" class="file-input" id="fileInput"
                                    accept=".png,.jpg,.jpeg,.pdf">
                            </div>

                            <div class="file-preview flex-column" id="filePreview" style="display: none;">
                                <div class="w-100 d-flex justify-content-center mb-3">
                                    <div class="file-icon" id="preview-container"
                                        style="width:120px;height:120px;font-size:2.5rem;display:flex;align-items:center;justify-content:center;">
                                        {{-- Preview gambar atau ikon akan ditampilkan di sini oleh JavaScript --}}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="file-info">
                                        <div class="file-name" id="fileName"></div>
                                        <div class="file-size" id="fileSize"></div>
                                    </div>
                                    <button type="button" class="file-remove ms-3" id="fileRemove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-auto"> {{-- mt-auto akan mendorong tombol ke bawah --}}
                                <button type="submit" class="btn btn-primary-custom btn-lg" id="submitBtn" disabled>
                                    <i class="fas fa-check me-2"></i>Konfirmasi Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-warning mt-3 d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Penting:</strong> Mohon transfer dengan nominal <strong>Rp
                            {{ number_format($order->total, 0, ',', '.') }}</strong> sesuai tagihan agar pesanan Anda dapat
                        segera diproses.
                    </div>
                    <button type="button" class="btn btn-danger ms-lg-3" id="btn-cancel-order"
                        data-order-id="{{ $order->id }}">
                        <i class="fas fa-times-circle me-1"></i> Batalkan Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Countdown timer tetap
            const countdownElement = document.getElementById('countdown-timer');
            if (countdownElement) {
                const expirationTime = new Date(countdownElement.dataset.expireAt).getTime();

                const countdownInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = expirationTime - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        countdownElement.innerHTML = "WAKTU HABIS";
                        document.getElementById('confirmationForm').style.opacity = '0.5';
                        document.getElementById('submitBtn').disabled = true;

                        showNotification('warning', 'Waktu Habis',
                            'Waktu pembayaran untuk pesanan ini telah berakhir. Halaman akan dimuat ulang.'
                            );

                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);

                        return; // Hentikan interval
                    }

                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    const formattedTime =
                        String(hours).padStart(2, '0') + ":" +
                        String(minutes).padStart(2, '0') + ":" +
                        String(seconds).padStart(2, '0');

                    countdownElement.innerHTML = formattedTime;
                }, 1000);
            }

            // Upload area tetap
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            const filePreview = document.getElementById('filePreview');
            const fileNameElement = document.getElementById('fileName');
            const fileSizeElement = document.getElementById('fileSize');
            const fileRemoveBtn = document.getElementById('fileRemove');

            if (uploadArea) {
                uploadArea.addEventListener('click', (event) => {
                    if (event.target !== fileInput) {
                        fileInput.click();
                    }
                });

                fileInput.addEventListener('change', handleFileSelect);

                uploadArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    uploadArea.classList.add('dragover');
                });
                uploadArea.addEventListener('dragleave', () => {
                    uploadArea.classList.remove('dragover');
                });
                uploadArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    uploadArea.classList.remove('dragover');
                    if (e.dataTransfer.files.length > 0) {
                        fileInput.files = e.dataTransfer.files;
                        handleFileSelect({
                            target: fileInput
                        });
                    }
                });
            }

            function handleFileSelect(event) {
                const previewContainer = document.getElementById('preview-container');
                const file = event.target.files[0];
                console.log(file.type);

                if (file) {
                    if (file.size > 5 * 1024 * 1024) {
                        showNotification('error', 'Ukuran File Terlalu Besar', 'Ukuran file maksimal adalah 5MB.');
                        fileInput.value = '';
                        return;
                    }

                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            previewContainer.innerHTML =
                                `<img src="${e.target.result}" alt="${file.name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">`;
                        }
                        reader.readAsDataURL(file); // Baca file sebagai URL data

                    } else {
                        previewContainer.innerHTML = '<i class="fas fa-file-alt" style="font-size: 1.5rem;"></i>';
                    }

                    fileNameElement.textContent = file.name;
                    fileSizeElement.textContent = (file.size / 1024).toFixed(2) + ' KB';

                    uploadArea.style.display = 'none';
                    filePreview.classList.add('show');

                    submitBtn.disabled = false;
                }
            }

            if (fileRemoveBtn) {
                fileRemoveBtn.addEventListener('click', () => {
                    fileInput.value = '';
                    uploadArea.style.display = 'block';
                    filePreview.classList.remove('show');
                    submitBtn.disabled = true;
                });
            }

            // Konfirmasi untuk tombol batal pesanan (sudah ada)
            const cancelButton = document.getElementById('btn-cancel-order');
            if (cancelButton) {
                cancelButton.addEventListener('click', function() {
                    const orderId = this.dataset.orderId;

                    showConfirmation(
                        'danger',
                        'Batalkan Pesanan?',
                        'Anda yakin ingin membatalkan pesanan ini? Aksi ini tidak dapat diurungkan.',
                        'Ya, Batalkan',
                        'Tidak',
                        function() {
                            fetch(`/order/cancel/${orderId}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(async response => {
                                    if (response.redirected) {
                                        showNotification('warning', 'Sesi Habis',
                                            'Sesi login Anda telah berakhir. Halaman akan dimuat ulang.'
                                        );
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2500);
                                        return;
                                    }

                                    let data;
                                    try {
                                        data = await response.json();
                                    } catch (e) {
                                        const text = await response.text();
                                        showNotification('error', 'Gagal',
                                            'Terjadi kesalahan: ' + text);
                                        return;
                                    }

                                    if (data && data.success) {
                                        showNotification('success', 'Berhasil',
                                            'Pesanan Anda telah dibatalkan.');
                                        setTimeout(() => {
                                            window.location.href =
                                                '{{ route('orders') }}';
                                        }, 2000);
                                    } else if (data) {
                                        showNotification('error', 'Gagal', data.message || (data
                                            .error ? data.error :
                                            'Pesanan tidak dapat dibatalkan.'));
                                    }
                                })
                                .catch(error => {
                                    console.error('Fetch Error:', error);
                                    showNotification('error', 'Error',
                                        'Terjadi kesalahan: ' + error.message);
                                });
                        }
                    );
                });
            }

            // Konfirmasi untuk tombol submit pembayaran
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                // Simpan referensi ke form
                const paymentForm = submitBtn.closest('form');
                // Hindari double binding
                submitBtn.addEventListener('click', function(e) {
                    // Cegah submit default
                    e.preventDefault();

                    showConfirmation(
                        'primary',
                        'Konfirmasi Pembayaran',
                        'Apakah Anda yakin ingin mengirimkan konfirmasi pembayaran ini? Pastikan data sudah benar.',
                        'Ya, Konfirmasi',
                        'Batal',
                        function() {
                            // Submit form secara manual setelah konfirmasi
                            if (paymentForm) {
                                // Ganti submit form dengan AJAX
                                const formData = new FormData(paymentForm);
                                submitBtn.disabled = true;
                                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

                                fetch(paymentForm.action, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(async response => {
                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Konfirmasi Pembayaran';

                                    if (response.redirected) {
                                        // Jika redirect, kemungkinan sukses
                                        showNotification('success', 'Berhasil', 'Konfirmasi pembayaran Anda telah diterima. Anda akan diarahkan ke halaman pesanan.');
                                        setTimeout(() => {
                                            window.location.href = response.url;
                                        }, 2000);
                                        return;
                                    }

                                    let data;
                                    try {
                                        data = await response.json();
                                    } catch (e) {
                                        const text = await response.text();
                                        showNotification('error', 'Gagal', 'Terjadi kesalahan: ' + text);
                                        return;
                                    }

                                    if (data && data.errors) {
                                        // Tampilkan error validasi
                                        let pesan = '';
                                        Object.values(data.errors).forEach(function(msgArr) {
                                            pesan += msgArr.join('<br>');
                                        });
                                        showNotification('error', 'Validasi Gagal', pesan);
                                    } else if (data && data.success) {
                                        showNotification('success', 'Berhasil', 'Konfirmasi pembayaran Anda telah diterima. Anda akan diarahkan ke halaman pesanan.');
                                        setTimeout(() => {
                                            window.location.href = '{{ route('orders') }}';
                                        }, 2000);
                                    } else {
                                        showNotification('error', 'Gagal', data.message || 'Terjadi kesalahan.');
                                    }
                                })
                                .catch(error => {
                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Konfirmasi Pembayaran';
                                    showNotification('error', 'Error', 'Terjadi kesalahan: ' + error.message);
                                });
                            }
                        }
                    );
                });
            }
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                toastr.success('Nomor rekening berhasil disalin!');
            }, function(err) {
                toastr.error('Gagal menyalin teks.');
            });
        }
    </script>
@endpush
