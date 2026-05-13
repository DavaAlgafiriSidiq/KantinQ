{{-- =============================================
     checkout-sukses.blade.php
     ============================================= --}}
@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5 mt-5 text-center" style="max-width:480px;">
    <div class="card border-0 shadow-sm rounded-4 p-5">

        {{-- Animasi centang --}}
        <div class="mb-4">
            <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                style="width:80px;height:80px;">
                <i class="fas fa-check-circle text-success fa-3x"></i>
            </div>
            <h4 class="fw-bold mb-1">Pesanan Berhasil!</h4>
            <p class="text-muted small">Terima kasih sudah memesan di <span class="fw-semibold text-warning">foodwaGon</span></p>
        </div>

        @if($pesanan)
        <div class="rounded-3 bg-light p-3 mb-4 text-start">
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Kode Pesanan</span>
                <span class="fw-bold">{{ $pesanan->kode_pesanan }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Total Bayar</span>
                {{-- Pastikan nama kolom total_harga atau total_amount sesuai database --}}
                <span class="fw-bold text-warning">Rp {{ number_format($pesanan->total_harga ?? $pesanan->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between small">
                <span class="text-muted">Status</span>
                <span class="badge bg-success-subtle text-success rounded-pill px-3">Lunas</span>
            </div>
        </div>

        <div class="alert alert-warning rounded-3 small text-start mb-4">
            <i class="fas fa-store me-2"></i>
            <strong>Pickup Reminder:</strong> Silakan ambil pesananmu langsung di warung/toko ya!
        </div>
        @endif

        <a href="{{ route('session-customer.menu') }}" class="btn btn-warning text-white fw-bold py-3 w-100 rounded-3">
            <i class="fas fa-utensils me-2"></i>Pesan Lagi
        </a>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($pesanan && $pesanan->orderItems->count() > 0)
            
            const idProduk = "{{ $pesanan->orderItems->first()->id_produk }}";
            const namaProduk = "{{ $pesanan->orderItems->first()->produk->nama_produk }}";
            const idOrder = "{{ $pesanan->id }}";

            setTimeout(() => {
                Swal.fire({
                    title: 'Suka dengan Menunya?',
                    text: `Apakah kamu ingin menambahkan "${namaProduk}" ke daftar favorit agar lebih mudah dipesan lagi nanti?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fas fa-heart me-2"></i>Ya, Tambahkan!',
                    cancelButtonText: 'Nanti saja',
                    borderRadius: '15px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('favorites.toggle', ':id') }}".replace(':id', idProduk);
                        
                        form.innerHTML = `
                            @csrf
                            <input type="hidden" name="id_order" value="${idOrder}">
                        `;
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }, 1000); 
        @endif
    });
</script>
@endsection