@extends('landing')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profil-customer.update') }}" method="POST" enctype="multipart/form-data" id="formEditProfil">
                @csrf
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="card-header bg-warning" style="height: 70px;"></div>
                    
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-5" style="margin-top: -35px; position: relative; z-index: 1;">
                            <div class="flex-shrink-0">
                                {{-- PERBAIKAN: Ambil foto dari $profile --}}
                                <img src="{{ $profile && $profile->foto ? asset($profile->foto) : 'https://www.gravatar.com/avatar/000?d=mp&s=120' }}" 
                                     id="uploadedAvatar" class="rounded-circle border border-5 border-white shadow-sm" 
                                     height="120" width="120" style="object-fit: cover; background-color: #f8f9fa;" />
                            </div>
                            <div class="ms-4 mt-5"> 
                                <h4 class="fw-bold mb-1 text-dark">Ubah Foto Profil</h4>
                                <div class="d-flex gap-2">
                                    <label for="upload" class="btn btn-warning btn-sm fw-bold text-white">
                                        <span>Upload Foto Baru</span>
                                        <input type="file" id="upload" name="foto" hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary btn-sm fw-bold" id="resetFoto">Reset</button>
                                </div>
                                <p class="text-muted mb-0 small mt-1">Format: JPG, PNG. Maks: 2MB.</p>
                                <div id="error-message" class="text-danger small fw-bold mt-1" style="display: none;">File terlalu besar! Maksimal 2MB.</div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control bg-light border-0 shadow-none" value="{{ old('name', $user->name) }}" required style="padding: 12px; border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase">Nomor Handphone</label>
                                <input type="text" 
                                    name="nomor_handphone" 
                                    class="form-control bg-light border-0 shadow-none" 
                                    value="{{ old('nomor_handphone', $profile->phone ?? $user->nomor_handphone) }}" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                                    required 
                                    style="padding: 12px; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between align-items-center">
                            <a href="{{ route('profil-customer.index') }}" class="btn btn-danger px-5 fw-bold shadow-sm" style="border-radius: 8px; padding: 10px 30px;">Batal</a>
                            <button type="submit" id="btnSimpan" class="btn btn-warning px-5 fw-bold shadow-sm text-white" style="border-radius: 8px; padding: 10px 30px;">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.querySelector('#upload');
        const imgAvatar = document.querySelector('#uploadedAvatar');
        const resetBtn = document.querySelector('#resetFoto');
        const initialSrc = imgAvatar.src;

        if (fileInput) {
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    const file = fileInput.files[0];
                    if (file.size / 1024 / 1024 > 2) {
                        document.querySelector('#error-message').style.display = 'block';
                        fileInput.value = '';
                    } else {
                        document.querySelector('#error-message').style.display = 'none';
                        const reader = new FileReader();
                        reader.onload = (e) => { imgAvatar.src = e.target.result; };
                        reader.readAsDataURL(file);
                    }
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