@extends('session-seller.layout-seller') 

@section('content')
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tabel /</span> Tabel Produk</h4>
              <!-- Tabel Produk -->
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Tabel Produk</h5>
                  <a href="{{ route('produk.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Tambah Produk
                  </a>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table table-striped style="table-layout: fixed; width: 100%;">
                    <thead>
                      <tr>
                        <th>Foto Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @if($produk->isEmpty())
                        <tr>
                          <td colspan="7" class="text-center">
                            @if(request('search'))
                              Produk "{{ request('search') }}" tidak ditemukan
                            @else
                              Data produk belum ada
                            @endif
                          </td>
                        </tr>
                      @else
                      @foreach ($produk as $item)
                      <tr>
                        <td>
                          @if($item->foto_produk)
                            <img src="{{ asset($item->foto_produk) }}" alt="{{ $item->nama_produk }}" width="100">
                          @else
                            <i class="fab fa-angular fa-lg text-danger me-3">tidak ada foto</i>
                          @endif
                        </td>
                        <td><strong>{{ $item->nama_produk }}</strong></td>
                        <!-- badge kategori diambil dari model produk dari fungsi badgeKategori -->
                        <!-- { !!  !! } digunakan agar diproses sebagai HTML, bukan string biasa -->
                        <td>{!! $item->badgeKategori() !!}</td>
                        <td style="min-width: 200px;">
                            <div style="width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $item->deskripsi }}
                            </div>
                        </td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>
                          @if($item->stok > 0)
                            <span class="badge bg-label-success me-1">{{ $item->stok }}</span>
                          @else
                            <span class="badge bg-label-danger me-1">Out of Stock</span>
                          @endif
                        </td>
                        <td>
                          @if($item->status == 'available')
                            <span class="badge bg-label-primary me-1">Available</span>
                          @else
                            <span class="badge bg-label-secondary me-1">Not Available</span>
                          @endif
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="{{ route('produk.edit', $item->id) }}">
                                <i class="bx bx-edit-alt me-1"></i> Edit
                              </a>
                              
                              <form action="{{ route('produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item">
                                  <i class="bx bx-trash me-1"></i> Hapus
                                </button>
                              </form>
                            </div>
                          </div> 
                        </td>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Striped Rows -->
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
@endsection