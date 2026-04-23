@extends('session-seller.layout-seller') 

@section('content')

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manajemen Produk/</span> Tambah Produk</h4>
              <div class="row">
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Tambah Produk</h5>
                    </div>
                    <div class="card-body">
                    <!-- Form Tambah Produk -->
<form action="{{ route('produk.simpan') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Nama Produk</label>
        <div class="col-sm-10">
            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                   name="nama_produk" value="{{ old('nama_produk') }}" required />
            @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-10">
            <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                <option value="">--Pilih Kategori--</option>
                @foreach ($kategori as $c)
                    <option value="{{ $c->id }}" {{ old('id_kategori') == $c->id ? 'selected' : '' }}>
                        {{ $c->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Deskripsi</label>
        <div class="col-sm-10">
            <textarea name="deskripsi" class="form-control" required>{{ old('deskripsi') }}</textarea>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Harga</label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <span class="input-group-text">Rp</span>
                <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required />
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Stok</label>
        <div class="col-sm-10">
            <input type="number" name="stok" class="form-control" value="{{ old('stok') }}" required />
        </div>
    </div>

    <div class="mb-4 pb-4 border-bottom">
        <h5 class="mb-3">Foto Produk</h5>
        <div class="mb-3">
            <label class="form-label">Upload Foto Produk <span class="text-danger">*</span></label>
            <input type="file" class="form-control @error('foto_produk') is-invalid @enderror" name="foto_produk" required>
            @error('foto_produk') 
            <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="text-muted">Ukuran maksimal 2MB. Format: JPG, JPEG, PNG.</small>
        </div>
    </div>

    <div class="row justify-content-end">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</form>
            <!-- / Form Tambah Produk -->
@endsection