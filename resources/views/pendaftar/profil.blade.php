@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-5xl mx-auto">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Profil Pribadi</h1>
            <p class="text-sm text-slate-500 mt-1">Lengkapi biodata diri dan data orang tua untuk keperluan seleksi.</p>
        </div>

        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8 flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
            <div>
                <h4 class="text-sm font-bold text-blue-800">Penting</h4>
                <p class="text-xs text-blue-700 mt-1">Pastikan seluruh data yang diinputkan adalah benar dan sesuai dengan
                    dokumen asli (KK/Akte/Ijazah). Data ini akan digunakan untuk verifikasi dan pencetakan kartu ujian.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">

            <form id="profilForm" enctype="multipart/form-data">
                @csrf
                @if ($profil)
                    @method('PUT')
                @endif

                <div class="p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center pb-4 border-b border-slate-100">
                        <span
                            class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-user"></i>
                        </span>
                        Data Diri Santri
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

                        <div class="md:col-span-4 lg:col-span-3">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Foto 3x4</label>
                            <div class="relative group">
                                <div
                                    class="w-full aspect-[3/4] bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden relative">
                                    @if ($profil && $profil->foto)
                                        <img src="{{ asset('storage/' . $profil->foto) }}" id="preview-foto"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="" id="preview-foto" class="w-full h-full object-cover hidden">
                                        <div id="placeholder-foto" class="text-center p-4">
                                            <i class="fas fa-camera text-3xl text-slate-300 mb-2"></i>
                                            <p class="text-[10px] text-slate-400">Upload Foto Resmi</p>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="foto" id="input-foto" accept="image/*" class="hidden"
                                    onchange="previewImage(this)">
                                <button type="button" onclick="document.getElementById('input-foto').click()"
                                    class="mt-3 w-full py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-50 transition">
                                    Pilih Foto
                                </button>
                                <p class="text-[10px] text-slate-400 mt-2 text-center">Format: JPG/PNG, Max 2MB. Wajah
                                    terlihat jelas.</p>
                            </div>
                        </div>

                        <div class="md:col-span-8 lg:col-span-9 space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">NIK (Nomor Induk
                                        Kependudukan) *</label>
                                    <input type="text" name="nik" value="{{ $profil->nik ?? old('nik') }}" required
                                        maxlength="16" placeholder="16 digit angka"
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition text-slate-700 font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Lengkap
                                        (Sesuai Ijazah) *</label>
                                    <input type="text" name="nama_lengkap"
                                        value="{{ $profil->nama_lengkap ?? old('nama_lengkap') }}" required
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition text-slate-700 font-medium">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tempat Lahir
                                        *</label>
                                    <input type="text" name="tempat_lahir"
                                        value="{{ $profil->tempat_lahir ?? old('tempat_lahir') }}" required
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Lahir
                                        *</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ $profil ? $profil->tanggal_lahir->format('Y-m-d') : old('tanggal_lahir') }}"
                                        required
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jenis Kelamin *</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="L" class="peer sr-only"
                                            {{ ($profil->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }} required>
                                        <div
                                            class="py-2.5 px-4 rounded-xl border border-slate-200 text-center text-sm font-medium text-slate-600 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition">
                                            Laki-laki
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="P" class="peer sr-only"
                                            {{ ($profil->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }} required>
                                        <div
                                            class="py-2.5 px-4 rounded-xl border border-slate-200 text-center text-sm font-medium text-slate-600 peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:text-pink-700 transition">
                                            Perempuan
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-slate-50/50 border-t border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center pb-4 border-b border-slate-200/60">
                        <span
                            class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        Alamat Domisili
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Alamat Lengkap (Jalan,
                                RT/RW, Dusun) *</label>
                            <textarea name="alamat_lengkap" rows="2" required placeholder="Contoh: Jl. Merpati No. 10 RT 01 RW 02"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700">{{ $profil->alamat_lengkap ?? old('alamat_lengkap') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Provinsi *</label>
                                <input type="text" name="provinsi" value="{{ $profil->provinsi ?? old('provinsi') }}"
                                    required
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kota / Kabupaten
                                    *</label>
                                <input type="text" name="kota" value="{{ $profil->kota ?? old('kota') }}" required
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kecamatan *</label>
                                <input type="text" name="kecamatan"
                                    value="{{ $profil->kecamatan ?? old('kecamatan') }}" required
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kelurahan / Desa
                                    *</label>
                                <input type="text" name="kelurahan"
                                    value="{{ $profil->kelurahan ?? old('kelurahan') }}" required
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kode Pos *</label>
                                <input type="text" name="kode_pos" value="{{ $profil->kode_pos ?? old('kode_pos') }}"
                                    required maxlength="5"
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 border-t border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center pb-4 border-b border-slate-100">
                        <span
                            class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-users"></i>
                        </span>
                        Data Orang Tua / Wali
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Ayah *</label>
                                <input type="text" name="nama_ayah"
                                    value="{{ $profil->nama_ayah ?? old('nama_ayah') }}" required
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Pekerjaan Ayah
                                    *</label>
                                <input type="text" name="pekerjaan_ayah"
                                    value="{{ $profil->pekerjaan_ayah ?? old('pekerjaan_ayah') }}" required
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Ibu *</label>
                                <input type="text" name="nama_ibu" value="{{ $profil->nama_ibu ?? old('nama_ibu') }}"
                                    required
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Pekerjaan Ibu
                                    *</label>
                                <input type="text" name="pekerjaan_ibu"
                                    value="{{ $profil->pekerjaan_ibu ?? old('pekerjaan_ibu') }}" required
                                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition">
                            </div>
                        </div>

                        <div class="md:col-span-2 pt-4">
                            <div class="p-4 bg-orange-50 rounded-xl border border-orange-100">
                                <label class="block text-xs font-bold text-orange-800 uppercase mb-2">Penghasilan Orang Tua
                                    (Total per bulan) *</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-orange-500 font-bold text-sm">Rp</span>
                                    <input type="number" name="penghasilan_ortu"
                                        value="{{ $profil->penghasilan_ortu ?? old('penghasilan_ortu') }}" required
                                        min="0"
                                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-orange-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 text-slate-700 font-bold"
                                        placeholder="Contoh: 3000000">
                                </div>
                                <p class="text-[10px] text-orange-600 mt-1.5"><i class="fas fa-info-circle mr-1"></i> Data
                                    ini akan digunakan sebagai kriteria penilaian ekonomi.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center gap-4">
                    <button type="button" onclick="window.location='{{ route('pendaftar.dashboard') }}'"
                        class="w-full md:w-auto px-6 py-2.5 bg-white border border-slate-300 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-100 transition shadow-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="w-full md:w-auto px-8 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm hover:bg-orange-700 transition shadow-lg shadow-orange-600/20 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Profil
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Ambil token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Preview Image Logic
        function previewImage(input) {
            const preview = document.getElementById('preview-foto');
            const placeholder = document.getElementById('placeholder-foto');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Handle Submit
        document.getElementById('profilForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Loading State
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const formData = new FormData(this);
            // Tentukan URL berdasarkan apakah profil sudah ada atau belum
            const url = @json($profil ? route('pendaftar.profil.update') : route('pendaftar.profil.store'));

            // Jika update, tambahkan _method PUT jika belum ada (meskipun sudah di blade)
            @if ($profil)
                formData.append('_method', 'PUT');
            @endif

            try {
                const response = await fetch(url, {
                    method: 'POST', // Gunakan POST dengan _method override
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#f97316',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl'
                        }
                    }).then(() => {
                        window.location.href = '{{ route('pendaftar.dashboard') }}';
                    });
                } else {
                    // Handle Validation Errors
                    let errorMessage = data.message || 'Terjadi kesalahan';
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0][0];
                        errorMessage = firstError;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMessage,
                        confirmButtonColor: '#f97316',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl'
                        }
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    confirmButtonColor: '#f97316',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl'
                    }
                });
            }
        });
    </script>
@endsection
