@extends('layouts.dashboard')

@section('title', 'Input Nilai Tes')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.perhitungan') }}"
                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-orange-600 hover:border-orange-200 transition shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Input Nilai Seleksi</h1>
                <p class="text-sm text-slate-500">Periode: <span
                        class="font-semibold text-orange-600">{{ $periode->nama_periode }}</span></p>
            </div>
        </div>
    </div>

    @if ($pendaftarans->count() == 0)
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-100 shadow-sm">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                <i class="fas fa-inbox text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Data</h3>
            <p class="text-slate-500 text-sm max-w-md mx-auto">Belum ada pendaftar yang lolos verifikasi berkas pada periode
                ini.</p>
        </div>
    @else
        <div class="bg-orange-50 rounded-2xl p-6 border border-orange-100 mb-8">
            <h3 class="text-sm font-bold text-orange-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle"></i> Komponen Penilaian
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach ($kriterias as $kriteria)
                    <div class="bg-white p-4 rounded-xl border border-orange-100 shadow-sm">
                        <div class="flex justify-between items-start mb-1">
                            <span
                                class="text-xs font-mono font-bold text-slate-400 bg-slate-100 px-1.5 rounded">{{ $kriteria->kode_kriteria }}</span>
                            <span class="text-xs font-bold text-orange-600">{{ $kriteria->bobot * 100 }}%</span>
                        </div>
                        <p class="font-bold text-slate-700 text-sm">{{ $kriteria->nama_kriteria }}</p>
                        @if ($kriteria->kode_kriteria === 'C3')
                            <p class="text-[10px] text-slate-400 mt-1 italic">* Otomatis dari sistem</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th
                                class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-16">
                                No</th>
                            <th class="text-left py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Identitas Pendaftar</th>
                            <th
                                class="text-center py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-40">
                                Kelengkapan</th>
                            <th class="text-right py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider w-32">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($pendaftarans as $index => $pendaftaran)
                            <tr class="hover:bg-slate-50/50 transition group">
                                <td class="py-4 px-6 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>

                                <td class="py-4 px-6">
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">
                                            {{ $pendaftaran->pengguna->profil->nama_lengkap ?? $pendaftaran->pengguna->nama }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span
                                                class="text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 font-mono">
                                                {{ $pendaftaran->no_pendaftaran }}
                                            </span>
                                            <span class="text-[10px] text-slate-400">•
                                                {{ $pendaftaran->asal_sekolah }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    @php
                                        $totalNilai = $pendaftaran->nilaiTes->count();
                                        $expectedNilai = $kriterias->where('kode_kriteria', '!=', 'C3')->count();
                                    @endphp

                                    @if ($totalNilai >= $expectedNilai)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            <i class="fas fa-check-circle mr-1.5"></i> Lengkap
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                            {{ $totalNilai }}/{{ $expectedNilai }} Input
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 text-right">
                                    <button
                                        onclick="openModalInput({{ $pendaftaran->pendaftaran_id }}, '{{ $pendaftaran->pengguna->profil->nama_lengkap ?? '' }}', {{ json_encode($pendaftaran->nilaiTes) }})"
                                        class="px-3 py-2 bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-200 rounded-lg text-xs font-bold transition shadow-sm flex items-center justify-center ml-auto gap-2">
                                        <i class="fas fa-pen"></i> Input
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div id="modalInput" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"
            onclick="closeModalInput()"></div>

        <div class="bg-white w-full max-w-md p-0 rounded-2xl relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 overflow-hidden"
            id="modalContent">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Input Nilai</h3>
                    <p class="text-xs text-slate-500 truncate max-w-[200px]" id="modalNama">-</p>
                </div>
                <button onclick="closeModalInput()" class="text-slate-400 hover:text-slate-600 transition"><i
                        class="fas fa-times"></i></button>
            </div>

            <form id="formNilai" onsubmit="submitNilai(event)">
                <input type="hidden" id="pendaftaranId">
                <div class="p-6 space-y-5 max-h-[60vh] overflow-y-auto custom-scroll">
                    @foreach ($kriterias as $kriteria)
                        @if ($kriteria->kode_kriteria !== 'C3')
                            <div>
                                <label class="flex justify-between text-xs font-bold text-slate-500 uppercase mb-2">
                                    <span>{{ $kriteria->nama_kriteria }}</span>
                                    <span class="text-orange-500">{{ $kriteria->bobot * 100 }}%</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="nilai[{{ $kriteria->kriteria_id }}]" min="0"
                                        max="100" step="0.01" required
                                        class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 transition font-medium"
                                        placeholder="0 - 100">
                                </div>
                            </div>
                        @else
                            <div class="p-3 bg-blue-50 rounded-xl border border-blue-100 text-center">
                                <p class="text-xs font-bold text-blue-700">{{ $kriteria->nama_kriteria }}</p>
                                <p class="text-[10px] text-blue-500 mt-0.5">Nilai diambil otomatis dari data prestasi.</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="px-6 pb-6 flex gap-3">
                    <button type="button" onclick="closeModalInput()"
                        class="flex-1 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition">Batal</button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm hover:bg-orange-700 transition shadow-lg shadow-orange-600/20">Simpan
                        Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const modal = document.getElementById('modalInput');
        const backdrop = document.getElementById('modalBackdrop');
        const content = document.getElementById('modalContent');

        // --- MODAL FUNCTIONS ---
        window.openModalInput = function(pendaftaranId, nama, existingNilai) {
            document.getElementById('pendaftaranId').value = pendaftaranId;
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('formNilai').reset();

            // Fill existing nilai
            if (existingNilai && existingNilai.length > 0) {
                existingNilai.forEach(nilai => {
                    const input = document.querySelector(`input[name="nilai[${nilai.kriteria_id}]"]`);
                    if (input) input.value = nilai.nilai;
                });
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        window.closeModalInput = function() {
            backdrop.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // --- SUBMIT NILAI ---
        window.submitNilai = async function(e) {
            e.preventDefault();

            const pendaftaranId = document.getElementById('pendaftaranId').value;
            const formData = new FormData(document.getElementById('formNilai'));

            const data = {
                pendaftaran_id: pendaftaranId,
                nilai: {}
            };

            // Convert FormData to JSON structure expected by controller
            for (let [key, value] of formData.entries()) {
                const match = key.match(/nilai\[(\d+)\]/);
                if (match) {
                    data.nilai[match[1]] = value;
                }
            }

            try {
                Swal.fire({
                    title: 'Menyimpan...',
                    didOpen: () => Swal.showLoading()
                });

                const response = await fetch('{{ route('admin.perhitungan.simpan-nilai') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                        confirmButtonColor: '#f97316'
                    }).then(() => {
                        closeModalInput();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: result.message,
                        confirmButtonColor: '#f97316'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem',
                    confirmButtonColor: '#f97316'
                });
            }
        }
    </script>
@endsection
