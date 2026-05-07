@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5 mt-5 text-center" style="max-width:540px;">

    <div class="card border-0 shadow-sm rounded-4 p-5">
        <div class="mb-4">
            <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                style="width:72px;height:72px;">
                <i class="fas fa-credit-card text-warning fa-2x"></i>
            </div>
            <h5 class="fw-bold mb-1">Selesaikan Pembayaran</h5>
            <p class="text-muted small mb-0">Kode Pesanan: <span class="fw-semibold text-dark">{{ $pesanan->kode_pesanan }}</span></p>
        </div>

        <div class="rounded-3 bg-light p-3 mb-4">
            <p class="text-muted small mb-1">Total yang harus dibayar</p>
            <p class="fw-bold fs-4 text-warning mb-0">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
        </div>

        <button id="pay-button" class="btn btn-warning text-white fw-bold py-3 w-100 rounded-3 mb-3">
            <i class="fas fa-wallet me-2"></i>Pilih Metode Pembayaran
        </button>

        <p class="text-muted small mb-0">
            <i class="fas fa-shield-alt me-1 text-success"></i>
            Pembayaran aman & terenkripsi oleh Midtrans
        </p>
    </div>

    {{-- Logo metode pembayaran --}}
    <div class="mt-4">
        <p class="text-muted small mb-2">Metode yang tersedia:</p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @foreach(['QRIS', 'GoPay', 'ShopeePay', 'BCA', 'BNI', 'BRI', 'Mandiri', 'Visa/MC'] as $metode)
            <span class="badge bg-white border text-muted fw-normal px-3 py-2 rounded-pill small">{{ $metode }}</span>
            @endforeach
        </div>
    </div>
</div>

{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    const snapToken = "{{ $snapToken }}";

    // Auto-buka popup Midtrans
    window.addEventListener('load', function () {
        setTimeout(() => openSnap(), 500);
    });

    document.getElementById('pay-button').addEventListener('click', openSnap);

    function openSnap() {
        snap.pay(snapToken, {
            onSuccess: function (result) {
                window.location.href = "{{ route('checkout.sukses') }}?order_id=" + result.order_id;
            },
            onPending: function (result) {
                window.location.href = "{{ route('checkout.sukses') }}?order_id=" + result.order_id;
            },
            onError: function (result) {
                window.location.href = "{{ route('checkout.gagal') }}?order_id=" + result.order_id;
            },
            onClose: function () {
                // User tutup popup tanpa bayar — biarkan di halaman ini
            }
        });
    }
</script>
@endsection