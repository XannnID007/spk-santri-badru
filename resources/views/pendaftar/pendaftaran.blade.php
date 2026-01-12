@extends('layouts.dashboard')

@section('title', 'Pendaftaran Santri Baru')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="max-w-4xl mx-auto">
            @if ($pendaftaran)
                <!-- Sudah Mendaftar -->
                <div class="glass-orange rounded-xl p-8 text-center">
                    <i class="fas fa-check-circle text-6xl text-green-400 mb-4"></i>
                    <h2 class="text-3xl font-bold text-white mb-4">Pendaftaran Berhasil!</h2>
                    <p class="text-gray-300 mb-2">No. Pendaftaran:</p>
                    <p class="text-4xl font-bold text-orange-500 mb-6">{{ $pendaftaran->no_pendaftaran }}</p>

                    <div class="glass-dark rounded-xl p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                            <div>
                                <p class="text-gray-400 text-sm">Tanggal Submit</p>
                                <p class="text-white font-semibold">{{ $pendaftaran->tanggal_submit->format('d F Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Status Verifikasi</p>
                                @if ($pendaftaran->status_verifikasi === 'pending')
                                    <span
                                        class="inline-block px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm">
                                        <i class="fas fa-clock mr-1"></i>Menunggu
                                    </span>
                                @elseif($pendaftaran->status_verifikasi === 'diterima')
                                    <span
                                        class="inline-block px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                        <i class="fas fa-check-circle mr-1"></i>Diverifikasi
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm">
                                        <i class="fas fa-times-circle mr-1"></i>Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('pendaftar.cetak-kartu', $pendaftaran->pendaftaran_id) }}" target="_blank"
                        class="inline-block px-8 py-4 bg-blue-500 hover:bg-blue-600 rounded-lg font-semibold transition">
                        <i class="fas fa-print mr-2"></i>Cetak Kartu Ujian
                    </a>
                </div>
            @else
                <!-- Form Pendaftaran -->
                <div class="glass-orange rounded-xl p-6 mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">
                        <i class="fas fa-file-alt mr-2"></i>Form Pendaftaran Santri Baru
                    </h2>
                    <p class="text-gray-300">{{ $periodeAktif->nama_periode }}</p>
                    <p class="text-sm text-gray-400">Kuota: {{ $periodeAktif->kuota_santri }} santri</p>
                </div>

                <div class="glass-dark rounded-xl p-8">
                    <form id="pendaftaranForm" enctype="multipart/form-data">
                        @csrf

                        <!-- Data Pendidikan -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-orange-500 mb-4 border-b border-orange-500/30 pb-2">
                                <i class="fas fa-school mr-2"></i>Data Pendidikan
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">Asal Sekolah *</label>
                                    <input type="text" name="asal_sekolah" required
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                        placeholder="SMP/MTs ...">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">Rata-rata Nilai Rapor
                                        *</label>
                                    <input type="number" name="rata_nilai" required step="0.01" min="0"
                                        max="100"
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                        placeholder="85.50">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-200 mb-2">Prestasi (Opsional)</label>
                                    <textarea name="prestasi" rows="3"
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none"
                                        placeholder="Tuliskan prestasi akademik/non-akademik yang pernah diraih"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Dokumen -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-orange-500 mb-4 border-b border-orange-500/30 pb-2">
                                <i class="fas fa-file-upload mr-2"></i>Upload Dokumen Persyaratan
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">
                                        <i class="fas fa-id-card mr-2"></i>Kartu Keluarga (KK) *
                                    </label>
                                    <input type="file" name="file_kk" required accept=".pdf,.jpg,.jpeg,.png"
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600">
                                    <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, PNG (Max: 2MB)</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">
                                        <i class="fas fa-certificate mr-2"></i>Akta Kelahiran *
                                    </label>
                                    <input type="file" name="file_akta" required accept=".pdf,.jpg,.jpeg,.png"
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600">
                                    <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, PNG (Max: 2MB)</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">
                                        <i class="fas fa-graduation-cap mr-2"></i>Ijazah / Surat Keterangan Lulus *
                                    </label>
                                    <input type="file" name="file_ijazah" required accept=".pdf,.jpg,.jpeg,.png"
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600">
                                    <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, PNG (Max: 2MB)</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">
                                        <i class="fas fa-image mr-2"></i>Pas Foto 3x4 *
                                    </label>
                                    <input type="file" name="file_foto" required accept=".jpg,.jpeg,.png"
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600">
                                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max: 1MB)</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-200 mb-2">
                                        <i class="fas fa-file-alt mr-2"></i>Surat Keterangan Tidak Mampu (SKTM) - Opsional
                                    </label>
                                    <input type="file" name="file_sktm" accept=".pdf,.jpg,.jpeg,.png"
                                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg text-white focus:border-orange-500 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600">
                                    <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, PNG (Max: 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pernyataan -->
                        <div class="mb-6">
                            <div class="glass-orange rounded-lg p-4">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" id="pernyataan" required
                                        class="mt-1 w-4 h-4 text-orange-500 bg-gray-800 border-gray-700 rounded focus:ring-orange-500">
                                    <span class="ml-3 text-sm text-gray-200">
                                        Saya menyatakan bahwa data yang saya isikan adalah benar dan dapat
                                        dipertanggungjawabkan.
                                        Saya bersedia mengikuti seluruh proses seleksi yang ditetapkan oleh panitia.
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="window.location='{{ route('pendaftar.dashboard') }}'"
                                class="px-6 py-3 bg-gray-600 hover:bg-gray-700 rounded-lg font-semibold transition">
                                <i class="fas fa-times mr-2"></i>Batal
                            </button>
                            <button type="submit" id="submitBtn"
                                class="px-6 py-3 gradient-orange rounded-lg font-semibold hover:opacity-90 transition">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @if (!$pendaftaran)
        document.getElementById('pendaftaranForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const pernyataan = document.getElementById('pernyataan');
        if (!pernyataan.checked) {
        Swal.fire({
        icon: 'warning',
        title: 'Perhatian!',
        text: 'Harap centang pernyataan terlebih dahulu',
        confirmButtonColor: '#ea580c',
        });
        return;
        }

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

        const formData = new FormData(this);

        try {
        const response = await fetch('{{ route('pendaftar.pendaftaran.store') }}', {
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
        html: `
        <p>${data.message}</p>
        <p class="text-xl font-bold text-orange-500 mt-2">No. Pendaftaran: ${data.no_pendaftaran}</p>
        `,
        confirmButtonColor: '#ea580c',
        }).then(() => {
        window.location.reload();
        });
        } else {
        Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: data.message || 'Terjadi kesalahan',
        confirmButtonColor: '#ea580c',
        });
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit Pendaftaran';
        }
        } catch (error) {
        Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Terjadi kesalahan sistem',
        confirmButtonColor: '#ea580c',
        });
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit Pendaftaran';
        }
        });
    @endif
@endsection
