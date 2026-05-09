@extends('session-seller.layout-seller') 

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Toko {{ $seller->nama_toko ?? 'Kantin' }}</h4>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-{{ $isTokoBuka ? 'success' : 'danger' }} text-white">
                        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <h5 class="card-title text-white mb-0">
                                Status Operasional: <strong>{{ $isTokoBuka ? 'BUKA' : 'TUTUP' }}</strong>
                            </h5>
                            
                            <form action="{{ route('seller.toggle-status') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-{{ $isTokoBuka ? 'light' : 'dark' }}">
                                    <i class='bx bx-power-off me-1'></i> 
                                    Ubah jadi {{ $isTokoBuka ? 'TUTUP' : 'BUKA' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Total Pendapatan Hari Ini</span>
                            <h3 class="card-title mb-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Pesanan Diselesaikan</span>
                            <h3 class="card-title mb-2">{{ $pesananSelesai }} Pesanan</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Antrean Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2"><h6 class="mb-0">Pesanan Baru</h6></div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">{{ $pesananBaru }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2"><h6 class="mb-0 text-warning">Sedang Diproses</h6></div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">{{ $pesananDiproses }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2"><h6 class="mb-0 text-success">Siap Diambil</h6></div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">{{ $pesananSiap }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Top 3 Menu Terlaris Hari Ini</h5>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                @foreach($topMenus as $menu)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2"><h6 class="mb-0">{{ $menu->name }}</h6></div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">{{ $menu->total_sold }} porsi</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Riwayat Pesanan Masuk</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Nama Pembeli</th>
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse($riwayatPesanan as $order)
                                    <tr>
                                        <td>{{ $order->created_at->format('H:i') }} <small class="text-muted">({{ $order->created_at->format('d/m') }})</small></td>
                                        <td><strong>{{ $order->profilCustomer?->name ?? 'Customer' }}</strong></td>
                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->status == 'baru')
                                                <span class="badge bg-label-info">BARU</span>
                                            @elseif($order->status == 'diproses')
                                                <span class="badge bg-label-warning">DIPROSES</span>
                                            @elseif($order->status == 'siap_diambil')
                                                <span class="badge bg-label-primary">SIAP DIAMBIL</span>
                                            @elseif($order->status == 'selesai')
                                                <span class="badge bg-label-success">SELESAI</span>
                                            @else
                                                <span class="badge bg-label-secondary">{{ strtoupper($order->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada pesanan masuk hari ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    <div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Antrean Pesanan Real-Time</h5>
        <select id="filter-status" class="form-select w-auto">
            <option value="semua">Semua Status</option>
            <option value="baru">Pesanan Baru</option>
            <option value="diproses">Sedang Dimasak</option>
            <option value="siap_diambil">Siap Diambil</option>
        </select>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Waktu & ETA</th>
                    <th>Detail Pesanan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="order-list-body">
                </tbody>
        </table>
    </div>
</div>

<script>
function refreshOrders() {
    let status = $('#filter-status').val();
    $.ajax({
        url: "{{ route('seller.orders.data') }}",
        type: "GET",
        data: { status: status },
        success: function(response) {
            let rows = '';
            response.orders.forEach(order => {
                let items = order.order_items.map(i => `<li>${i.quantity}x ${i.menu?.nama_produk || 'Menu'}</li>`).join('');
                
                // Logika Tombol Aksi (AC 2)
                let btn = '';
                if(order.status == 'baru') btn = `<button onclick="updateStatus(${order.id}, 'diproses')" class="btn btn-sm btn-info">Terima & Masak</button>`;
                else if(order.status == 'diproses') btn = `<button onclick="updateStatus(${order.id}, 'siap_diambil')" class="btn btn-sm btn-warning">Siap Diambil</button>`;
                else if(order.status == 'siap_diambil') btn = `<button onclick="updateStatus(${order.id}, 'selesai')" class="btn btn-sm btn-success">Selesai</button>`;

                rows += `
                <tr>
                    <td>${order.time_formatted} <br> <small class="text-danger">ETA: ${order.eta} Menit</small></td>
                    <td><ul class="mb-0">${items}</ul></td>
                    <td>Rp ${parseInt(order.total_amount).toLocaleString()}</td>
                    <td><span class="badge bg-label-secondary">${order.status.toUpperCase()}</span></td>
                    <td>${btn}</td>
                </tr>`;
            });
            $('#order-list-body').html(rows || '<tr><td colspan="5" class="text-center">Tidak ada antrean</td></tr>');
        }
    });
}

function updateStatus(id, status) {
    $.post(`/seller/orders/${id}/status`, { _token: '{{ csrf_token() }}', status: status }, function() {
        refreshOrders();
    });
}

// Auto Refresh setiap 5 detik (AC 6)
setInterval(refreshOrders, 5000);
$(document).ready(refreshOrders);
</script>
    

    <script src="{{ asset('assets-dashboard/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets-dashboard/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets-dashboard/js/main.js') }}"></script>

@endsection