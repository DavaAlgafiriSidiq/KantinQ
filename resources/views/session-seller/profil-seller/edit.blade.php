@extends('session-seller.layout-seller')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <form action="{{ route('profil-seller.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-primary" style="height: 70px; border-radius: 0.5rem 0.5rem 0 0;"></div>
                
                <div class="card-body">
                    <div class="d-flex align-items-center mb-5" style="margin-top: -35px; position: relative; z-index: 1;">
                        <div class="flex-shrink-0">
                            <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('assets/img/avatars/1.png') }}" 
                                 alt="user-avatar" 
                                 class="rounded-circle border border-5 border-white shadow-sm" 
                                 height="120" width="120" 
                                 id="uploadedAvatar"
                                 style="object-fit: cover; background-color: white;" />
                        </div>
                        <div class="ms-4 mt-5"> <h4 class="fw-bold mb-1 text-dark">Edit Foto Profil</h4>
                            <div class="d-flex gap-2">
                                <label for="upload" class="btn btn-primary btn-sm" tabindex="0">
                                    <span class="d-none d-sm-block">Upload Foto Baru</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="foto_profil" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="resetFoto">
                                    Reset
                                </button>
                            </div>
                            <p class="text-muted mb-0 small mt-1">Format: JPG, PNG. Maks: 800KB.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-bold">Nama Toko</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-store text-primary"></i></span>
                                <input type="text" name="nama_toko" class="form-control" value="{{ old('nama_toko', $user->nama_toko) }}" required />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-bold">Nomor WhatsApp</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bxl-whatsapp text-success"></i></span>
                                <input type="text" name="nomor_hp" class="form-control" value="{{ old('nomor_hp', $user->nomor_hp) }}" required />
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-muted small text-uppercase fw-bold">Deskripsi Toko</label>
                            <textarea name="deskripsi_toko" class="form-control" rows="4" placeholder="Ceritakan tentang toko Anda...">{{ old('deskripsi_toko', $user->deskripsi_toko) }}</textarea>
                        </div>
                    </div>

                    <hr class="my-5 opacity-25" />

                    <div class="d-flex justify-content-between align-items-center mb-2 px-2">
                        <a href="{{ route('profil-seller.index') }}" class="btn btn-label-secondary border-0">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            <i class='bx bx-save me-2'></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function (e) {
        const fileInput = document.querySelector('#upload');
        const imgAvatar = document.querySelector('#uploadedAvatar');
        const resetBtn = document.querySelector('#resetFoto');
        const initialSrc = imgAvatar.src;

        if (fileInput) {
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    const fileReader = new FileReader();
                    fileReader.onload = (event) => {
                        imgAvatar.src = event.target.result;
                    };
                    fileReader.readAsDataURL(fileInput.files[0]);
                }
            };
        }

        if (resetBtn) {
            resetBtn.onclick = () => {
                fileInput.value = '';
                imgAvatar.src = initialSrc;
            };
        }
    });
</script>
@endsection