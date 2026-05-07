@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5 mt-5 text-center" style="max-width:480px;">
    <div class="card border-0 shadow-sm rounded-4 p-5">

        <div class="mb-4">
            <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                style="width:80px;height:80px;">
                <i class="fas fa-times-circle text-danger fa-3x"></i>
            </div>
            <h4 class="fw-bold mb-1">Pembayaran Gagal</h4>
            <p class="text-muted small">
                Pembayaran dibatalkan atau kadaluarsa.
                @if($pesanan)
                    Kode Pesanan: <span class="fw-semibold">{{ $pesanan->kode_pesanan }}</span>
                @endif
            </p>
        </div>

        <div class="alert alert-secondary rounded-3 small text-start mb-4">
            <i class="fas fa-info-circle me-2 text-warning"></i>
            Jangan khawatir, item di keranjang kamu tidak terhapus. Coba lagi kapanpun kamu mau.
        </div>

        <a href="{{ route('keranjang') }}" class="btn btn-warning text-white fw-bold py-3 w-100 rounded-3 mb-2">
            <i class="fas fa-redo me-2"></i>Coba Lagi
        </a>
        <a href="{{ route('session-customer.menu') }}" class="btn btn-outline-secondary w-100">
            Kembali ke Menu
        </a>
    </div>
</div>
@endsection
