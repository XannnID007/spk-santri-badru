@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="glass-orange rounded-xl p-6 mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">
                    <i class="fas fa-user-circle mr-2"></i>Profil Pribadi
                </h2>
                <p class="text-gray-300">Lengkapi data profil Anda dengan benar</p>
            </div>

            <!-- Form -->
            <div class="glass-dark rounded-xl p-8">
                <form id="profilForm" enctype="multipart/form-data">
                    @csrf
                    @if ($profil)
                        @method('PUT')
                    @endif

                    <!-- Data Pribadi -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-orange-500 mb-4 border-b border-orange-500/30 pb-2">
                            <i class="fas fa-user mr-2"></i>Data Pribadi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">NIK *</label>
                                <input type="text" name="nik" value="{{ $profil->nik ?? old('nik') }}" required
                                    maxlength="16"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Nama Lengkap *</label>
                                <input type="text" name="nama_lengkap"
                                    value="{{ $profil->nama_lengkap ?? old('nama_lengkap') }}" required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Tempat Lahir *</label>
                                <input type="text" name="tempat_lahir"
                                    value="{{ $profil->tempat_lahir ?? old('tempat_lahir') }}" required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Tanggal Lahir *</label>
                                <input type="date" name="tanggal_lahir"
                                    value="{{ $profil ? $profil->tanggal_lahir->format('Y-m-d') : old('tanggal_lahir') }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Jenis Kelamin *</label>
                                <select name="jenis_kelamin" required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L"
                                        {{ ($profil->jenis_kelamin ?? old('jenis_kelamin')) == 'L' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="P"
                                        {{ ($profil->jenis_kelamin ?? old('jenis_kelamin')) == 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Foto 3x4</label>
                                <input type="file" name="foto" accept="image/*"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                @if ($profil && $profil->foto)
                                    <img src="{{ asset('storage/' . $profil->foto) }}" alt="Foto"
                                        class="mt-2 w-24 h-32 object-cover rounded">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-orange-500 mb-4 border-b border-orange-500/30 pb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>Alamat
                        </h3>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Alamat Lengkap *</label>
                                <textarea name="alamat_lengkap" rows="3" required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">{{ $profil->alamat_lengkap ?? old('alamat_lengkap') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">Provinsi *</label>
                                    <input type="text" name="provinsi" value="{{ $profil->provinsi ?? old('provinsi') }}"
                                        required
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">Kota/Kabupaten *</label>
                                    <input type="text" name="kota" value="{{ $profil->kota ?? old('kota') }}" required
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">Kecamatan *</label>
                                    <input type="text" name="kecamatan"
                                        value="{{ $profil->kecamatan ?? old('kecamatan') }}" required
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">Kelurahan/Desa *</label>
                                    <input type="text" name="kelurahan"
                                        value="{{ $profil->kelurahan ?? old('kelurahan') }}" required
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">Kode Pos *</label>
                                    <input type="text" name="kode_pos"
                                        value="{{ $profil->kode_pos ?? old('kode_pos') }}" required maxlength="5"
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-orange-500 mb-4 border-b border-orange-500/30 pb-2">
                            <i class="fas fa-users mr-2"></i>Data Orang Tua / Wali
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Nama Ayah *</label>
                                <input type="text" name="nama_ayah" value="{{ $profil->nama_ayah ?? old('nama_ayah') }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Nama Ibu *</label>
                                <input type="text" name="nama_ibu" value="{{ $profil->nama_ibu ?? old('nama_ibu') }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Pekerjaan Ayah *</label>
                                <input type="text" name="pekerjaan_ayah"
                                    value="{{ $profil->pekerjaan_ayah ?? old('pekerjaan_ayah') }}" required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200 mb-2">Pekerjaan Ibu *</label>
                                <input type="text" name="pekerjaan_ibu"
                                    value="{{ $profil->pekerjaan_ibu ?? old('pekerjaan_ibu') }}" required
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-200 mb-2">Penghasilan Orang Tua (per
                                    bulan) *</label>
                                <input type="number" name="penghasilan_ortu"
                                    value="{{ $profil->penghasilan_ortu ?? old('penghasilan_ortu') }}" required
                                    min="0"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                    placeholder="Contoh: 3000000">
                                <p class="text-xs text-gray-400 mt-1">* Data ini akan digunakan untuk kriteria ekonomi
                                    dalam seleksi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="window.location='{{ route('pendaftar.dashboard') }}'"
                            class="px-6 py-3 bg-gray-600 hover:bg-gray-700 rounded-lg font-semibold transition">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                            <i class="fas fa-save mr-2"></i>Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    document.getElementById('profilForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const url = @json($profil ? route('pendaftar.profil.update') : route('pendaftar.profil.store'));

    try {
    const response = await fetch(url, {
    method: 'POST',
    headers: {
    'X-CSRF-TOKEN': csrfToken,
    },
    body: formData
    });

    const data = await response.json();

    if (data.success) {
    Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: data.message,
    confirmButtonColor: '#ea580c',
    }).then(() => {
    window.location.href = '{{ route('pendaftar.dashboard') }}';
    });
    } else {
    Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: data.message || 'Terjadi kesalahan',
    confirmButtonColor: '#ea580c',
    });
    }
    } catch (error) {
    Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: 'Terjadi kesalahan sistem',
    confirmButtonColor: '#ea580c',
    });
    }
    });
@endsection
