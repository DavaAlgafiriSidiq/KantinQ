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
                <tr><td colspan="5" class="text-center">Menghubungkan ke dapur...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<script>
// Menunggu sampai seluruh halaman selesai dimuat
document.addEventListener("DOMContentLoaded", function() {
    
    function refreshOrders() {
        let status = document.getElementById('filter-status').value;
        
        // Panggil data dari Controller
        fetch(`/seller/orders/data?status=${status}`)
            .then(response => response.json())
            .then(data => {
                let rows = '';
                
                // Kalau datanya kosong
                if(!data.orders || data.orders.length === 0) {
                    document.getElementById('order-list-body').innerHTML = '<tr><td colspan="5" class="text-center">Yeay, antrean kosong! Waktunya istirahat.</td></tr>';
                    return;
                }

                // Kalau ada data, kita gambar tabelnya
                data.orders.forEach(order => {
                    // Antisipasi perbedaan nama relasi (order_items vs orderItems)
                    let itemsArray = order.order_items || order.orderItems || [];
                    
                    let itemsHtml = itemsArray.map(i => {
                        // Antisipasi relasi menu vs produk
                        let namaMenu = (i.menu && i.menu.nama_produk) ? i.menu.nama_produk : ((i.produk && i.produk.nama_produk) ? i.produk.nama_produk : 'Menu KantinQ');
                        return `<li><small>${i.quantity}x ${namaMenu}</small></li>`;
                    }).join('');
                    
                    // Siapkan Tombol Aksi
                    let btn = '';
                    let badge = '';
                    
                    if(order.status == 'baru') {
                        badge = '<span class="badge bg-label-info">BARU</span>';
                        btn = `<button onclick="updateStatus(${order.id}, 'diproses')" class="btn btn-sm btn-info">Masak</button>`;
                    } else if(order.status == 'diproses') {
                        badge = '<span class="badge bg-label-warning">DIMASAK</span>';
                        btn = `<button onclick="updateStatus(${order.id}, 'siap_diambil')" class="btn btn-sm btn-warning">Selesai Masak</button>`;
                    } else if(order.status == 'siap_diambil') {
                        badge = '<span class="badge bg-label-primary">SIAP DIAMBIL</span>';
                        btn = `<button onclick="updateStatus(${order.id}, 'selesai')" class="btn btn-sm btn-success">Serahkan</button>`;
                    }

                    rows += `
                    <tr>
                        <td><strong>${order.time_formatted || ''}</strong> <br> <small class="text-danger">ETA: ${order.eta || 0} Mnt</small></td>
                        <td><ul class="mb-0 ps-3">${itemsHtml}</ul></td>
                        <td>Rp ${parseInt(order.total_amount).toLocaleString('id-ID')}</td>
                        <td>${badge}</td>
                        <td>${btn}</td>
                    </tr>`;
                });
                
                // Tampilkan ke layar!
                document.getElementById('order-list-body').innerHTML = rows;
            })
            .catch(error => {
                console.error("Error AJAX KantinQ:", error);
                document.getElementById('order-list-body').innerHTML = '<tr><td colspan="5" class="text-center text-danger">Gagal memuat antrean. Cek koneksi atau relasi database!</td></tr>';
            });
    }

    // Jalankan setiap filter diganti
    document.getElementById('filter-status').addEventListener('change', refreshOrders);
    
    // Auto-refresh setiap 5 detik
    setInterval(refreshOrders, 5000);
    
    // Panggil pertama kali
    refreshOrders();
});

// Fungsi untuk klik tombol aksi
function updateStatus(id, status) {
    fetch(`/seller/orders/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    }).then(() => {
        // Biarkan setInterval yang merefresh tabelnya
    });
}
</script>
    

    <script src="{{ asset('assets-dashboard/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets-dashboard/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets-dashboard/js/main.js') }}"></script>

@endsection