@push('styles')
    @once
        <style>
            :root {
                --pakistan-green: #143109;
                --sage: #aaae7f;
                --beige: #d0d6b3;
                --seasalt: #f7f7f7;
                --antiflash-white: #efefef;
                --primary-color: var(--pakistan-green);
                --success-color: var(--sage);
                --danger-color: #ef4444;
                --warning-color: var(--beige);
                --info-color: var(--sage);
                --dark-color: var(--pakistan-green);
                --light-color: var(--seasalt);
                --border-radius: 16px;
                --box-shadow: 0 32px 64px -12px rgba(20, 49, 9, 0.25);
                --glass-effect: rgba(255, 255, 255, 0.1);
            }
        </style>
    @endonce
@endpush

{{-- Enhanced HTML structure with better accessibility and modern elements --}}
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup notifikasi"></button>
            </div>
            <div class="modal-body">
                <div class="modal-icon" id="notificationIcon" role="img" aria-hidden="true">
                    <i class="fas fa-check" id="notificationIconSymbol"></i>
                </div>
                <h4 class="modal-title" id="notificationTitle">Notifikasi</h4>
                <p class="modal-text" id="notificationMessage">Pesan notifikasi akan ditampilkan di sini</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modern btn-primary-modern" data-bs-dismiss="modal"
                    aria-label="Tutup notifikasi">
                    <i class="fas fa-check me-2" aria-hidden="true"></i>Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
    aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup konfirmasi"></button>
            </div>
            <div class="modal-body">
                <div class="modal-icon modal-icon-warning" id="confirmationIcon" role="img" aria-hidden="true">
                    <i class="fas fa-question" id="confirmationIconSymbol"></i>
                </div>
                <h4 class="modal-title" id="confirmationTitle">Konfirmasi Tindakan</h4>
                <p class="modal-text" id="confirmationMessage">Apakah Anda yakin ingin melanjutkan tindakan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modern btn-outline-modern" data-bs-dismiss="modal"
                    id="confirmationCancelBtn" aria-label="Batalkan tindakan">
                    <i class="fas fa-times me-2" aria-hidden="true"></i>Batal
                </button>
                <button type="button" class="btn btn-modern btn-danger-modern" id="confirmationConfirmBtn"
                    aria-label="Konfirmasi tindakan">
                    <i class="fas fa-check me-2" aria-hidden="true"></i>Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>
</div>
</parameter>
</invoke>


{{-- Bagian 3: Mendorong JavaScript ke akhir <body> hanya sekali --}}
@push('scripts')
    @once
        <script>
            // Modal instances
            let notificationModal;
            let confirmationModal;
            let confirmationCallback = null;

            // Initialize modals when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                if (document.getElementById('notificationModal')) {
                    notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
                }
                if (document.getElementById('confirmationModal')) {
                    confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                }
            });

            function showNotification(type = 'info', title = 'Notification', message = '', buttonText = 'OK') {
                const modal = document.getElementById('notificationModal');
                if (!modal) return;
                const icon = document.getElementById('notificationIcon');
                const iconSymbol = document.getElementById('notificationIconSymbol');
                const titleElement = document.getElementById('notificationTitle');
                const messageElement = document.getElementById('notificationMessage');
                const okButton = modal.querySelector('.modal-footer .btn');

                icon.className = 'modal-icon';

                switch (type) {
                    case 'success':
                        icon.classList.add('modal-icon-success');
                        iconSymbol.className = 'fas fa-check';
                        okButton.className = 'btn btn-modern btn-success-modern';
                        okButton.innerHTML = '<i class="fas fa-check me-2"></i>' + buttonText;
                        break;
                    case 'error':
                    case 'danger':
                        icon.classList.add('modal-icon-danger');
                        iconSymbol.className = 'fas fa-times';
                        okButton.className = 'btn btn-modern btn-danger-modern';
                        okButton.innerHTML = '<i class="fas fa-times me-2"></i>' + buttonText;
                        break;
                    case 'warning':
                        icon.classList.add('modal-icon-warning');
                        iconSymbol.className = 'fas fa-exclamation-triangle';
                        okButton.className = 'btn btn-modern btn-warning-modern';
                        okButton.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + buttonText;
                        break;
                    case 'info':
                    default:
                        icon.classList.add('modal-icon-info');
                        iconSymbol.className = 'fas fa-info';
                        okButton.className = 'btn btn-modern btn-primary-modern';
                        okButton.innerHTML = '<i class="fas fa-info me-2"></i>' + buttonText;
                        break;
                }

                titleElement.textContent = title;
                messageElement.textContent = message;
                notificationModal.show();
            }

            function showConfirmation(type = 'primary', title = 'Konfirmasi', message = 'Apakah Anda yakin?', confirmText =
                'Ya', cancelText = 'Batal', callback = null) {
                const modal = document.getElementById('confirmationModal');
                if (!modal) return;
                const icon = document.getElementById('confirmationIcon');
                const iconSymbol = document.getElementById('confirmationIconSymbol');
                const titleElement = document.getElementById('confirmationTitle');
                const messageElement = document.getElementById('confirmationMessage');
                const confirmBtn = document.getElementById('confirmationConfirmBtn');
                const cancelBtn = document.getElementById('confirmationCancelBtn');

                icon.className = 'modal-icon';

                switch (type) {
                    case 'danger':
                        icon.classList.add('modal-icon-danger');
                        iconSymbol.className = 'fas fa-exclamation-triangle';
                        confirmBtn.className = 'btn btn-modern btn-danger-modern';
                        confirmBtn.innerHTML = '<i class="fas fa-trash me-2"></i>' + confirmText;
                        break;
                    case 'warning':
                        icon.classList.add('modal-icon-warning');
                        iconSymbol.className = 'fas fa-exclamation-triangle';
                        confirmBtn.className = 'btn btn-modern btn-warning-modern';
                        confirmBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + confirmText;
                        break;
                    case 'success':
                        icon.classList.add('modal-icon-success');
                        iconSymbol.className = 'fas fa-check';
                        confirmBtn.className = 'btn btn-modern btn-success-modern';
                        confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>' + confirmText;
                        break;
                    case 'primary':
                    default:
                        icon.classList.add('modal-icon-info');
                        iconSymbol.className = 'fas fa-question';
                        confirmBtn.className = 'btn btn-modern btn-primary-modern';
                        confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>' + confirmText;
                        break;
                }

                titleElement.textContent = title;
                messageElement.textContent = message;
                cancelBtn.innerHTML = '<i class="fas fa-times me-2"></i>' + cancelText;
                confirmationCallback = callback;
                confirmationModal.show();
            }

            // Handle confirmation button click
            if (document.getElementById('confirmationConfirmBtn')) {
                document.getElementById('confirmationConfirmBtn').addEventListener('click', function() {
                    if (confirmationCallback && typeof confirmationCallback === 'function') {
                        confirmationCallback();
                    }
                    confirmationModal.hide();
                });
            }

            /**
             * Show notification from Laravel session
             * Panggil helper ini di Blade View Anda
             */
            function showNotificationFromSession(sessionData) {
                showNotification(
                    sessionData.type || 'info',
                    sessionData.title || 'Notification',
                    sessionData.message || ''
                );
            }
        </script>
    @endonce
@endpush
