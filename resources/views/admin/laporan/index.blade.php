@extends('layouts.dashboard')

@section('title', 'Laporan & Rekapitulasi')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Pusat Laporan</h1>
        <p class="text-sm text-slate-500 mt-1">Cetak laporan data pendaftar dan hasil seleksi akhir.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-5 space-y-6">

            <div
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-orange-500"></div>

                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                    <i class="fas fa-print mr-2 text-orange-500"></i> Buat Laporan
                </h3>

                <form method="GET" target="_blank" id="formLaporan">
                    @csrf
                    <div class="space-y-5">

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Periode Pendaftaran</label>
                            <div class="relative">
                                <select name="periode_id" id="periodeSelect" required onchange="updatePreview()"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition appearance-none text-slate-700 font-medium">
                                    <option value="" disabled selected>Pilih Periode...</option>
                                    @foreach ($periodes as $p)
                                        <option value="{{ $p->periode_id }}" data-nama="{{ $p->nama_periode }}"
                                            data-kuota="{{ $p->kuota_santri }}">
                                            {{ $p->nama_periode }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-4 text-xs text-slate-400"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jenis Laporan</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_laporan" value="pendaftaran" class="peer sr-only"
                                        checked onchange="updatePreview()">
                                    <div
                                        class="p-3 rounded-xl border border-slate-200 bg-slate-50 text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 transition">
                                        <div class="mb-1"><i class="fas fa-users"></i></div>
                                        <span class="text-xs font-bold">Data Pendaftar</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_laporan" value="seleksi" class="peer sr-only"
                                        onchange="updatePreview()">
                                    <div
                                        class="p-3 rounded-xl border border-slate-200 bg-slate-50 text-center peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition">
                                        <div class="mb-1"><i class="fas fa-trophy"></i></div>
                                        <span class="text-xs font-bold">Hasil Seleksi</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="pt-4 grid grid-cols-2 gap-3">
                            <button type="button" onclick="submitForm('pdf')"
                                class="flex items-center justify-center gap-2 py-3 bg-rose-50 text-rose-600 border border-rose-100 rounded-xl font-bold text-sm hover:bg-rose-500 hover:text-white transition shadow-sm">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </button>

                            <button type="button" onclick="submitForm('excel')"
                                class="flex items-center justify-center gap-2 py-3 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl font-bold text-sm hover:bg-emerald-500 hover:text-white transition shadow-sm">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 text-xs text-blue-800 space-y-2">
                <p class="font-bold flex items-center gap-2"><i class="fas fa-info-circle"></i> Informasi:</p>
                <ul class="list-disc list-inside space-y-1 ml-1 text-blue-700/80">
                    <li><strong>Laporan Pendaftar:</strong> Berisi data lengkap seluruh calon santri yang sudah submit.</li>
                    <li><strong>Hasil Seleksi:</strong> Berisi ranking, nilai akhir, dan status kelulusan
                        (Diterima/Cadangan/Ditolak).</li>
                </ul>
            </div>

        </div>

        <div class="lg:col-span-7">
            <div
                class="bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] h-full flex flex-col items-center justify-center text-center min-h-[450px]">

                <div id="previewDefault" class="block">
                    <div
                        class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                        <i class="fas fa-print text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Siap Mencetak Laporan</h3>
                    <p class="text-slate-400 text-sm max-w-xs mx-auto">Silakan pilih periode dan jenis laporan di panel
                        sebelah kiri.</p>
                </div>

                <div id="previewActive" class="hidden w-full max-w-md mx-auto">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm transition-colors duration-300"
                        id="previewIconBg">
                        <i class="fas fa-file-alt text-3xl" id="previewIcon"></i>
                    </div>

                    <h3 class="text-lg font-bold text-slate-800 mb-1" id="previewTitle">Judul Laporan</h3>
                    <p class="text-sm text-slate-500 mb-8" id="previewSubtitle">Periode: -</p>

                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 text-left">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Ringkasan Data</p>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Periode</span>
                                <span class="font-bold text-slate-800" id="summaryPeriode">-</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Kuota Penerimaan</span>
                                <span class="font-bold text-slate-800" id="summaryKuota">0</span>
                            </div>
                            <div class="flex justify-between text-sm border-t border-slate-200 pt-3 mt-3">
                                <span class="text-slate-600">Format Output</span>
                                <span class="font-bold text-orange-600" id="summaryFormat">PDF Document</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Route Definition (Diambil dari nama route Laravel Anda)
        const routes = {
            pendaftaran: "{{ route('admin.laporan.pendaftaran') }}", // Route ke method laporanPendaftaran
            seleksi: "{{ route('admin.laporan.hasil-seleksi') }}", // Route ke method laporanHasilSeleksi
            excel: "{{ route('admin.laporan.export-excel') }}" // Route ke method exportExcel
        };

        function updatePreview() {
            const select = document.getElementById('periodeSelect');
            const jenis = document.querySelector('input[name="jenis_laporan"]:checked').value;

            // Jika belum pilih periode
            if (select.value === "") return;

            // Toggle UI View
            document.getElementById('previewDefault').classList.add('hidden');
            document.getElementById('previewActive').classList.remove('hidden');

            // Ambil Data dari Option
            const selectedOption = select.options[select.selectedIndex];
            const namaPeriode = selectedOption.getAttribute('data-nama');
            const kuota = selectedOption.getAttribute('data-kuota');

            // Update Text UI
            document.getElementById('summaryPeriode').innerText = namaPeriode;
            document.getElementById('summaryKuota').innerText = kuota + ' Santri';
            document.getElementById('previewSubtitle').innerText = 'Periode: ' + namaPeriode;

            // Update Icon & Title berdasarkan Jenis
            const iconBg = document.getElementById('previewIconBg');
            const icon = document.getElementById('previewIcon');
            const title = document.getElementById('previewTitle');

            if (jenis === 'pendaftaran') {
                title.innerText = 'Laporan Data Pendaftar';
                iconBg.className =
                    "w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm bg-orange-100 text-orange-600";
                icon.className = "fas fa-users text-3xl";
            } else {
                title.innerText = 'Laporan Hasil Seleksi';
                iconBg.className =
                    "w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm bg-emerald-100 text-emerald-600";
                icon.className = "fas fa-trophy text-3xl";
            }
        }

        function submitForm(format) {
            const select = document.getElementById('periodeSelect');
            if (select.value === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Periode',
                    text: 'Silakan pilih periode pendaftaran terlebih dahulu.',
                    confirmButtonColor: '#f97316'
                });
                return;
            }

            const form = document.getElementById('formLaporan');
            const jenis = document.querySelector('input[name="jenis_laporan"]:checked').value;

            // Update Text Preview Format
            document.getElementById('summaryFormat').innerText = format === 'pdf' ? 'PDF Document' : 'Excel Spreadsheet';

            // Tentukan Action URL Form berdasarkan logika tombol & jenis
            if (format === 'excel') {
                form.action = routes.excel;
            } else {
                // Jika PDF, cek jenis laporannya
                if (jenis === 'pendaftaran') {
                    form.action = routes.pendaftaran;
                } else {
                    form.action = routes.seleksi;
                }
            }

            // Submit Form
            form.submit();
        }
    </script>
@endsection
