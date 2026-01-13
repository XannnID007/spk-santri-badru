@extends('layouts.dashboard')

@section('title', 'Perhitungan SMART')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Metode SMART</h1>
        <p class="text-sm text-slate-500 mt-1">Simple Multi Attribute Rating Technique untuk seleksi santri.</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
            <span class="w-6 h-6 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs mr-3">1</span>
            Pilih Periode Seleksi
        </h3>

        <form id="periodeForm" class="flex flex-col md:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Periode Pendaftaran</label>
                <div class="relative">
                    <select id="periodeSelect"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition appearance-none text-slate-700 font-medium">
                        <option value="">-- Pilih Periode --</option>
                        @foreach ($periodes as $periode)
                            <option value="{{ $periode->periode_id }}"
                                {{ request('periode_id') == $periode->periode_id ? 'selected' : '' }}>
                                {{ $periode->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-4 text-xs text-slate-400"></i>
                </div>
            </div>
            <button type="button" onclick="loadProcess()"
                class="w-full md:w-auto px-6 py-3 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-slate-700 transition shadow-lg shadow-slate-800/20 flex items-center justify-center gap-2">
                <i class="fas fa-arrow-right"></i> Lanjutkan Proses
            </button>
        </form>
    </div>

    <div id="processMenu" class="hidden">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
            <span
                class="w-6 h-6 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs mr-3">2</span>
            Tahapan Perhitungan
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div onclick="goToInputNilai()"
                class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-edit text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-1">Input Nilai</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Masukkan nilai tes tulis dan wawancara calon santri.
                    </p>
                </div>
            </div>

            <div onclick="hitungSMART()"
                class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-orange-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 mb-4 group-hover:bg-orange-600 group-hover:text-white transition">
                        <i class="fas fa-calculator text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-1">Hitung Ranking</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Jalankan algoritma SMART untuk mendapatkan ranking.
                    </p>
                </div>
            </div>

            <div onclick="goToHasil()"
                class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 mb-4 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i class="fas fa-trophy text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-1">Hasil Akhir</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Lihat ranking final dan tentukan status kelulusan.</p>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Auto load jika ada parameter di URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const periodeId = urlParams.get('periode_id');
            if (periodeId) {
                document.getElementById('periodeSelect').value = periodeId;
                document.getElementById('processMenu').classList.remove('hidden');
            }
        });

        function getSelectedPeriode() {
            const periodeId = document.getElementById('periodeSelect').value;
            if (!periodeId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Periode',
                    text: 'Silakan pilih periode pendaftaran terlebih dahulu.',
                    confirmButtonColor: '#f97316'
                });
                return null;
            }
            return periodeId;
        }

        function loadProcess() {
            const periodeId = getSelectedPeriode();
            if (periodeId) {
                document.getElementById('processMenu').classList.remove('hidden');
                // Smooth scroll ke menu
                document.getElementById('processMenu').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        function goToInputNilai() {
            const periodeId = getSelectedPeriode();
            if (periodeId) window.location.href = `{{ route('admin.perhitungan.input-nilai') }}?periode_id=${periodeId}`;
        }

        function goToHasil() {
            const periodeId = getSelectedPeriode();
            if (periodeId) window.location.href = `{{ route('admin.perhitungan.hasil') }}?periode_id=${periodeId}`;
        }

        function hitungSMART() {
            const periodeId = getSelectedPeriode();
            if (!periodeId) return;

            Swal.fire({
                title: 'Mulai Perhitungan?',
                text: "Sistem akan menghitung ulang nilai akhir dan ranking untuk periode ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Hitung Sekarang',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(
                            `{{ route('admin.perhitungan.hitung-smart') }}?periode_id=${periodeId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            });

                        if (!response.ok) throw new Error(response.statusText);
                        return await response.json();
                    } catch (error) {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Selesai!',
                        text: result.value.message,
                        confirmButtonColor: '#f97316'
                    }).then(() => {
                        goToHasil();
                    });
                }
            });
        }
    </script>
@endsection
