@extends('layouts.dashboard')

@section('title', 'Pendaftaran Santri Baru')

@section('content')
    <div class="max-w-4xl mx-auto">

        @if ($pendaftaran)
            <div
                class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden text-center">
                <div class="bg-emerald-50 p-8 border-b border-emerald-100">
                    <div
                        class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                        <i class="fas fa-check text-4xl text-emerald-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-emerald-800 mb-1">Pendaftaran Berhasil!</h2>
                    <p class="text-emerald-600 text-sm">Data Anda telah kami terima dan sedang diproses.</p>
                </div>

                <div class="p-8">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor Pendaftaran</p>
                    <div class="inline-block bg-slate-50 px-6 py-3 rounded-xl border border-slate-200 mb-8">
                        <span
                            class="text-4xl font-mono font-bold text-slate-800 tracking-wider">{{ $pendaftaran->no_pendaftaran }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto mb-8 text-left">
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-xs text-slate-400 mb-1 font-bold uppercase">Tanggal Submit</p>
                            <p class="text-slate-700 font-semibold">{{ $pendaftaran->tanggal_submit->format('d F Y, H:i') }}
                                WIB</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-xs text-slate-400 mb-1 font-bold uppercase">Status Verifikasi</p>
                            @if ($pendaftaran->status_verifikasi === 'pending')
                                <span class="inline-flex items-center text-amber-600 font-bold text-sm">
                                    <i class="fas fa-clock mr-2"></i> Menunggu Verifikasi
                                </span>
                            @elseif($pendaftaran->status_verifikasi === 'diterima')
                                <span class="inline-flex items-center text-emerald-600 font-bold text-sm">
                                    <i class="fas fa-check-circle mr-2"></i> Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center text-rose-600 font-bold text-sm">
                                    <i class="fas fa-times-circle mr-2"></i> Ditolak
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($pendaftaran->status_verifikasi === 'diterima')
                        {{-- Button Trigger Modal --}}
                        <button onclick="openPdfModal('{{ route('pendaftar.cetak-kartu', $pendaftaran->pendaftaran_id) }}')"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 group">
                            <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform"></i>
                            Lihat & Cetak Kartu Ujian
                        </button>
                    @else
                        <button disabled
                            class="inline-flex items-center px-6 py-3 bg-slate-100 text-slate-400 rounded-xl font-bold cursor-not-allowed">
                            <i class="fas fa-print mr-2"></i> Cetak Kartu (Menunggu Verifikasi)
                        </button>
                    @endif
                </div>
            </div>
        @else
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-800">Formulir Pendaftaran</h1>
                <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                    <span>Periode: <strong class="text-orange-600">{{ $periodeAktif->nama_periode }}</strong></span>
                    <span>&bull;</span>
                    <span>Sisa Kuota: <strong>{{ $periodeAktif->kuota_santri }}</strong></span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
                <form id="pendaftaranForm" enctype="multipart/form-data">
                    @csrf

                    <div class="p-8">
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center pb-4 border-b border-slate-100">
                            <span
                                class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mr-3 text-sm">
                                <i class="fas fa-school"></i>
                            </span>
                            Riwayat Pendidikan
                        </h3>

                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Asal Sekolah
                                        (SMP/MTs) *</label>
                                    <input type="text" name="asal_sekolah" required
                                        placeholder="Contoh: SMP Negeri 1 Bandung"
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition font-medium text-slate-700">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Rata-rata Nilai
                                        Rapor *</label>
                                    <input type="number" name="rata_nilai" required step="0.01" min="0"
                                        max="100" placeholder="85.50"
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition font-medium text-slate-700">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Prestasi Akademik /
                                    Non-Akademik (Opsional)</label>
                                <textarea name="prestasi" rows="3" placeholder="Jelaskan prestasi yang pernah diraih (jika ada)..."
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition text-slate-700"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 bg-slate-50/50 border-t border-slate-100">
                        <h3
                            class="text-lg font-bold text-slate-800 mb-6 flex items-center pb-4 border-b border-slate-200/60">
                            <span
                                class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3 text-sm">
                                <i class="fas fa-file-upload"></i>
                            </span>
                            Dokumen Persyaratan
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ([['name' => 'file_kk', 'label' => 'Kartu Keluarga (KK)', 'icon' => 'fa-users', 'req' => true], ['name' => 'file_akta', 'label' => 'Akta Kelahiran', 'icon' => 'fa-baby', 'req' => true], ['name' => 'file_ijazah', 'label' => 'Ijazah / SKL', 'icon' => 'fa-graduation-cap', 'req' => true], ['name' => 'file_foto', 'label' => 'Pas Foto 3x4 (Resmi)', 'icon' => 'fa-camera', 'req' => true], ['name' => 'file_sktm', 'label' => 'SKTM (Jika Ada)', 'icon' => 'fa-file-invoice', 'req' => false]] as $doc)
                                <div
                                    class="bg-white p-4 rounded-xl border border-slate-200 hover:border-blue-300 transition group">
                                    <label
                                        class="block text-xs font-bold text-slate-500 uppercase mb-2 flex justify-between">
                                        <span><i
                                                class="fas {{ $doc['icon'] }} mr-1.5 text-slate-400 group-hover:text-blue-500"></i>
                                            {{ $doc['label'] }}</span>
                                        @if ($doc['req'])
                                            <span class="text-rose-500">*</span>
                                        @endif
                                    </label>
                                    <input type="file" name="{{ $doc['name'] }}" {{ $doc['req'] ? 'required' : '' }}
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-600 hover:file:bg-blue-50 hover:file:text-blue-600 transition cursor-pointer">
                                    <p class="text-[10px] text-slate-400 mt-2">Max: 2MB (PDF/JPG)</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-8 border-t border-slate-100 bg-white">
                        <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 mb-6">
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" id="pernyataan" required
                                    class="mt-1 w-4 h-4 text-orange-600 bg-white border-slate-300 rounded focus:ring-orange-500 focus:ring-offset-0">
                                <span class="text-sm text-slate-600 leading-relaxed group-hover:text-slate-800 transition">
                                    Saya menyatakan bahwa data yang saya isikan adalah benar dan dapat
                                    dipertanggungjawabkan.
                                    Saya bersedia mengikuti seluruh proses seleksi yang ditetapkan oleh panitia Penerimaan
                                    Santri Baru.
                                </span>
                            </label>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                            <button type="button" onclick="window.location='{{ route('pendaftar.dashboard') }}'"
                                class="w-full md:w-auto px-6 py-2.5 bg-white border border-slate-300 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition">
                                Batal
                            </button>
                            <button type="submit" id="submitBtn"
                                class="w-full md:w-auto px-8 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm hover:bg-orange-700 transition shadow-lg shadow-orange-600/20 flex items-center justify-center gap-2">
                                <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        @endif
    </div>

    {{-- MODAL PREVIEW PDF (Dipindah ke Stack 'modals') --}}
    @push('modals')
        <div id="pdfModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

            <div class="fixed inset-0 z-[101] overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <!-- Modal Panel -->
                    <div id="modalPanel"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl opacity-0 scale-95">

                        <!-- Header -->
                        <div class="bg-white px-4 py-4 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                Preview Kartu Ujian
                            </h3>
                            <button type="button" onclick="closePdfModal()"
                                class="text-slate-400 hover:text-slate-500 hover:bg-slate-100 rounded-lg w-8 h-8 flex items-center justify-center transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Body (Iframe) -->
                        <div class="relative bg-slate-100 h-[70vh]">
                            {{-- Loading Indicator --}}
                            <div id="pdfLoading"
                                class="absolute inset-0 flex flex-col items-center justify-center text-slate-500 z-0">
                                <i class="fas fa-spinner fa-spin text-3xl text-blue-500 mb-2"></i>
                                <p class="text-sm font-medium">Memuat Kartu Ujian...</p>
                                <p class="text-xs text-slate-400 mt-2 font-medium bg-white/50 px-3 py-1 rounded-full">Mohon
                                    jangan refresh halaman selama proses ini.</p>
                            </div>
                            {{-- Iframe --}}
                            {{-- FIX: Tambah class bg-white agar menutupi loader jika onload gagal --}}
                            <iframe id="pdfFrame" class="w-full h-full relative z-10 bg-white" src=""
                                frameborder="0" onload="hidePdfLoading()"></iframe>
                        </div>

                        <!-- Footer -->
                        <div class="bg-slate-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-slate-100">
                            <a id="btnDownloadPdf" href="#" target="_blank"
                                class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 sm:w-auto gap-2 items-center">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                            <button type="button" onclick="closePdfModal()"
                                class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endsection

@section('scripts')
    <script>
        // === MODAL LOGIC ===
        function openPdfModal(url) {
            const modal = document.getElementById('pdfModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            const frame = document.getElementById('pdfFrame');
            const downloadBtn = document.getElementById('btnDownloadPdf');
            const loading = document.getElementById('pdfLoading');

            // Reset Loading
            loading.classList.remove('hidden');

            // Set URL - Tambahkan timestamp untuk mencegah cache browser yang bisa bikin stuck
            // Cache busting: menambahkan ?t=123123123 di akhir URL
            frame.src = url + (url.includes('?') ? '&' : '?') + 't=' + new Date().getTime();

            downloadBtn.href = url;

            // Show Modal Container
            modal.classList.remove('hidden');

            // Animate In (Sedikit delay agar transisi CSS jalan)
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
                panel.classList.add('opacity-100', 'scale-100');
            }, 50);

            // FALLBACK PENTING:
            // Banyak browser modern tidak menjalankan event 'onload' untuk PDF di iframe.
            // Kita paksa hilangkan loader setelah 3 detik agar user tidak melihat loading selamanya.
            setTimeout(() => {
                hidePdfLoading();
            }, 3000);
        }

        function closePdfModal() {
            const modal = document.getElementById('pdfModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            const frame = document.getElementById('pdfFrame');

            // Animate Out
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'scale-100');
            panel.classList.add('opacity-0', 'scale-95');

            // Hide Modal Container after animation
            setTimeout(() => {
                modal.classList.add('hidden');
                frame.src = ''; // Clear iframe agar stop loading/playing
            }, 300);
        }

        function hidePdfLoading() {
            const loading = document.getElementById('pdfLoading');
            if (loading) {
                loading.classList.add('hidden');
            }
        }

        // Close on Backdrop Click
        const backdrop = document.getElementById('modalBackdrop');
        if (backdrop) {
            backdrop.addEventListener('click', closePdfModal);
        }

        // === EXISTING LOGIC ===
        document.addEventListener('DOMContentLoaded', function() {
            // Cek token
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

            // 2. Script Form Pendaftaran (Hanya jika form ada)
            const form = document.getElementById('pendaftaranForm');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault(); // Mencegah refresh halaman
                    console.log("Submit Pendaftaran...");

                    const pernyataan = document.getElementById('pernyataan');
                    if (!pernyataan.checked) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pernyataan Belum Disetujui',
                            text: 'Silakan centang kotak pernyataan untuk melanjutkan.',
                            confirmButtonColor: '#f97316'
                        });
                        return;
                    }

                    const submitBtn = document.getElementById('submitBtn');
                    const originalBtnContent = submitBtn.innerHTML;

                    // Disable tombol
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

                    const formData = new FormData(this);

                    try {
                        const response = await fetch('{{ route('pendaftar.pendaftaran.store') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json' // Penting agar server mengembalikan JSON
                            },
                            body: formData
                        });

                        // Cek tipe konten respons
                        const contentType = response.headers.get("content-type");
                        let data;

                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            data = await response.json();
                        } else {
                            // Jika respons bukan JSON (misal error 500 HTML)
                            const text = await response.text();
                            console.error("Non-JSON Response:", text);
                            throw new Error("Terjadi kesalahan server (500).");
                        }

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pendaftaran Berhasil!',
                                html: `<p class="text-sm text-slate-600">${data.message}</p>
                                   <div class="mt-4 p-3 bg-slate-100 rounded-lg border border-slate-200">
                                     <span class="text-xs text-slate-500 uppercase font-bold">No. Pendaftaran</span><br>
                                     <span class="text-xl font-mono font-bold text-orange-600">${data.no_pendaftaran}</span>
                                   </div>`,
                                confirmButtonText: 'Lihat Status',
                                confirmButtonColor: '#f97316',
                                allowOutsideClick: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan saat memproses data.');
                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengirim',
                            text: error.message ||
                                'Terjadi kesalahan sistem. Silakan coba lagi.',
                            confirmButtonColor: '#f97316'
                        });

                        // Reset Button jika gagal
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnContent;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                });
            }
        });
    </script>
@endsection
