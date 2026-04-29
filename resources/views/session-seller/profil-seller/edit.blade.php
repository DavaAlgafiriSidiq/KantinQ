@extends('session-seller.layout-seller')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <form action="{{ route('profil-seller.update') }}" method="POST" enctype="multipart/form-data" id="formEditProfil">
            @csrf
            @method('PUT')

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 0.5rem text-dark;">
                {{-- Header Biru Tipis --}}
                <div class="card-header bg-primary" style="height: 70px; border-radius: 0.5rem 0.5rem 0 0;"></div>
                
                <div class="card-body">
                    {{-- SEKSI FOTO PROFIL --}}
                    <div class="d-flex align-items-center mb-5" style="margin-top: -35px; position: relative; z-index: 1;">
                        <div class="flex-shrink-0">
                            <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y&s=120' }}" 
                                 alt="user-avatar" 
                                 class="rounded-circle border border-5 border-white shadow-sm" 
                                 height="120" width="120" 
                                 id="uploadedAvatar"
                                 style="object-fit: cover; background-color: #f8f9fa;" />
                        </div>
                        <div class="ms-4 mt-5"> 
                            <h4 class="fw-bold mb-1 text-dark">Edit Foto Profil</h4>
                            <div class="d-flex gap-2">
                                <label for="upload" class="btn btn-primary btn-sm" tabindex="0">
                                    <span>Upload Foto Baru</span>
                                    <input type="file" id="upload" name="foto_profil" hidden accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="resetFoto">
                                    Reset
                                </button>
                            </div>
                            <p class="text-muted mb-0 small mt-1">Format: JPG, PNG. Maks: 2MB.</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        {{-- INPUT NAMA TOKO --}}
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(105, 108, 255, 0.08); border: 1px solid rgba(105, 108, 255, 0.15);">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-2 d-block">Nama Toko</label>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-store text-primary me-2 fs-4"></i>
                                    {{-- Border 0 dan Background Transparent agar menyatu dengan kotak luar --}}
                                    <input type="text" name="nama_toko" 
                                           class="form-control border-0 bg-transparent p-0 shadow-none fw-medium text-dark" 
                                           value="{{ old('nama_toko', $user->nama_toko) }}" 
                                           required />
                                </div>
                            </div>
                        </div>

                        {{-- INPUT NOMOR WHATSAPP --}}
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(40, 167, 69, 0.08); border: 1px solid rgba(40, 167, 69, 0.15);">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-2 d-block">Nomor WhatsApp</label>
                                <div class="d-flex align-items-center">
                                    <i class="bx bxl-whatsapp text-success me-2 fs-4"></i>
                                    <input type="number" name="nomor_hp" 
                                           class="form-control border-0 bg-transparent p-0 shadow-none fw-medium text-dark" 
                                           value="{{ old('nomor_hp', $user->nomor_hp) }}" 
                                           required />
                                </div>
                            </div>
                        </div>

                        {{-- INPUT DESKRIPSI TOKO --}}
                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.03); border: 1px dashed #d9dee3;">
                                <label class="form-label text-muted small text-uppercase fw-bold mb-2 d-block">Deskripsi Toko</label>
                                <textarea name="deskripsi_toko" 
                                          class="form-control border-0 bg-transparent p-0 shadow-none text-dark" 
                                          rows="4" 
                                          placeholder="Ceritakan tentang toko Anda..." 
                                          style="resize: none;">{{ old('deskripsi_toko', $user->deskripsi_toko) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5 opacity-25" />

                    {{-- TOMBOL AKSI --}}
                    <div class="d-flex justify-content-between align-items-center mb-2 px-2">
                        <a href="{{ route('profil-seller.index') }}" class="btn btn-label-secondary border-0">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm" id="btnSimpan">
                            <i class='bx bx-save me-2'></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Script preview foto tetap sama seperti sebelumnya
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