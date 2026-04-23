@extends('session-seller.layout-seller') 

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Manajemen Produk /</span> Edit Produk
        </h4>

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Produk: {{ $produk->nama_produk }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') 

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                                           name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required />
                                    @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                                        <option value="">--Pilih Kategori--</option>
                                        @foreach ($kategori as $c)
                                            <option value="{{ $c->id }}" {{ (old('id_kategori', $produk->id_kategori) == $c->id) ? 'selected' : '' }}>
                                                {{ $c->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Harga</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                               value="{{ old('harga', $produk->harga) }}" required />
                                    </div>
                                    @error('harga') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Stok</label>
                                <div class="col-sm-10">
                                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" 
                                           value="{{ old('stok', $produk->stok) }}" required />
                                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-4 pb-4 border-bottom">
                                <h5 class="mb-3">Foto Produk</h5>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <p class="small text-muted">Foto Saat Ini:</p>
                                        @if($produk->foto_produk)
                                            <img src="{{ asset($produk->foto_produk) }}" alt="Current Photo" class="img-fluid rounded shadow-sm" style="max-height: 100px">
                                        @else
                                            <span class="badge bg-label-secondary">Tidak ada foto</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-10">
                                        <label class="form-label">Ganti Foto Produk (Opsional)</label>
                                        <input type="file" class="form-control @error('foto_produk') is-invalid @enderror" name="foto_produk">
                                        @error('foto_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengganti foto. Maksimal 2MB.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-warning">Update Data</button>
                                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection