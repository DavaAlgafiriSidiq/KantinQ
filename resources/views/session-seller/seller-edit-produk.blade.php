@extends('session-seller.layout-seller') 

@section('content')
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                                <label class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" 
                                           value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                                    @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
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
                                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $produk->stok) }}" min="0">
                                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="available" {{ old('status', $produk->status) == 'available' ? 'selected' : '' }}>Available (Tampilkan)</option>
                                        <option value="unavailable" {{ old('status', $produk->status) == 'unavailable' ? 'selected' : '' }}>Unavailable (Arsipkan)</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label">Foto Produk</label>
                                <div class="col-sm-10">
                                    <div class="d-flex align-items-start gap-4">
                                        @if($produk->foto_produk)
                                            <img src="{{ asset($produk->foto_produk) }}" alt="Current Photo" class="d-block rounded shadow-sm" height="100" width="100" id="uploadedAvatar">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:100px; height:100px;">
                                                <i class="bx bx-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="button-wrapper">
                                            <label for="upload" class="btn btn-primary btn-sm me-2 mb-2" tabindex="0">
                                                <span class="d-none d-sm-block">Upload Foto Baru</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" id="upload" name="foto_produk" class="account-file-input" hidden accept="image/png, image/jpeg">
                                            </label>
                                            <p class="text-muted mb-0 small">JPG atau PNG. Maksimal 2MB.</p>
                                        </div>
                                    </div>
                                    @error('foto_produk') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-warning text-white fw-bold">
                                        <i class="bx bx-save me-1"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Batal</a>
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