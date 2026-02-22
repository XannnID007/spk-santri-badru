{{-- MODAL DETAIL PERHITUNGAN SMART - FIXED VERSION --}}
<div id="modalDetailPerhitungan" class="fixed inset-0 z-[100] hidden items-center justify-center px-4" role="dialog"
    aria-modal="true">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="detailBackdrop"
        onclick="closeDetailModal()"></div>

    {{-- Content --}}
    <div class="bg-white w-full max-w-5xl p-0 rounded-2xl relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 overflow-hidden max-h-[90vh] flex flex-col"
        id="detailContent">

        {{-- Header --}}
        <div
            class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-gradient-to-r from-slate-50 to-white flex-shrink-0">
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-calculator text-orange-500"></i>
                    Detail Perhitungan SMART
                </h3>
                <p class="text-xs text-slate-500 mt-1" id="detailNamaPendaftar">-</p>
            </div>
            <button type="button" onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Body - Scrollable --}}
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            {{-- Loading State --}}
            <div id="detailLoading" class="text-center py-12">
                <i class="fas fa-spinner fa-spin text-4xl text-orange-500 mb-4"></i>
                <p class="text-slate-500">Memuat data perhitungan...</p>
            </div>

            {{-- Content Container --}}
            <div id="detailDataContainer" class="hidden space-y-6">
                {{-- Informasi Umum --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        class="bg-gradient-to-br from-orange-50 to-orange-100/50 p-4 rounded-xl border border-orange-200">
                        <p class="text-xs font-bold text-orange-600 uppercase mb-1">Ranking</p>
                        <p class="text-3xl font-black text-orange-700" id="detailRanking">-</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 p-4 rounded-xl border border-blue-200">
                        <p class="text-xs font-bold text-blue-600 uppercase mb-1">Nilai Akhir</p>
                        <p class="text-3xl font-black text-blue-700" id="detailNilaiAkhir">-</p>
                    </div>
                    <div
                        class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 p-4 rounded-xl border border-emerald-200">
                        <p class="text-xs font-bold text-emerald-600 uppercase mb-1">Status</p>
                        <div id="detailStatus" class="text-lg font-bold">-</div>
                    </div>
                </div>

                {{-- INFO BOX PENJELASAN --}}
                <div class="bg-gradient-to-br from-blue-50 to-slate-50 rounded-xl border border-blue-200 p-5">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-lightbulb text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-blue-900 mb-2">Cara Membaca Tabel</h4>
                            <div class="text-xs text-blue-700 space-y-1">
                                <p>• <strong>Nilai Asli:</strong> Nilai mentah sebelum diproses (88.00, Rp 2.000.000,
                                    dll)</p>
                                <p>• <strong>Normalisasi:</strong> Nilai sudah di-scale ke 0-1 (semakin tinggi semakin
                                    baik)</p>
                                <p>• <strong>Nilai Terbobot:</strong> Hasil Normalisasi × Bobot (dalam skala 0-1)</p>
                                <p>• <strong>Total Nilai Akhir:</strong> Jumlah semua Nilai Terbobot (maksimal 1.0000 =
                                    100%)</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Detail Perhitungan --}}
                <div>
                    <h4 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-table text-slate-400"></i>
                        Rincian Perhitungan Per Kriteria
                    </h4>
                    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th class="text-left py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                            Kriteria</th>
                                        <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                            Jenis</th>
                                        <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                            Nilai Asli</th>
                                        <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                            Normalisasi<br><span class="text-[10px] font-normal text-slate-400">(skala
                                                0-1)</span></th>
                                        <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                            Bobot</th>
                                        <th class="text-center py-3 px-4 font-bold text-slate-600 text-xs uppercase">
                                            Nilai Terbobot<br><span
                                                class="text-[10px] font-normal text-slate-400">(Normalisasi ×
                                                Bobot)</span></th>
                                    </tr>
                                </thead>
                                <tbody id="detailTableBody" class="divide-y divide-slate-100">
                                    <!-- Data akan diisi via JavaScript -->
                                </tbody>
                                <tfoot class="bg-gradient-to-r from-slate-50 to-orange-50 border-t-2 border-orange-300">
                                    <tr>
                                        <td colspan="5" class="py-4 px-4 text-right font-bold text-slate-800">
                                            <i class="fas fa-equals mr-2 text-orange-500"></i>
                                            Total Nilai Akhir (Σ Nilai Terbobot):
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <div
                                                class="inline-flex flex-col items-center gap-1 px-4 py-2 bg-white rounded-lg border-2 border-orange-400 shadow-sm">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-star text-orange-500"></i>
                                                    <span class="text-xl font-black text-orange-600"
                                                        id="detailTotalNilai">-</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Penjelasan Metode SMART --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                    <h5 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-slate-400"></i>
                        Penjelasan Metode SMART
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                        <div class="bg-white p-3 rounded-lg border border-slate-200">
                            <p class="font-bold text-blue-700 mb-1">1️⃣ Normalisasi</p>
                            <div class="font-mono text-xs bg-slate-50 p-2 rounded border border-slate-200 mb-2">
                                <div class="text-emerald-600">• Benefit:</div>
                                <div class="ml-2">(nilai - min) / (max - min)</div>
                                <div class="text-rose-600 mt-1">• Cost:</div>
                                <div class="ml-2">(max - nilai) / (max - min)</div>
                            </div>
                            <p class="text-slate-600">Mengubah semua nilai ke skala 0-1</p>
                        </div>

                        <div class="bg-white p-3 rounded-lg border border-slate-200">
                            <p class="font-bold text-orange-700 mb-1">2️⃣ Nilai Terbobot</p>
                            <div class="font-mono text-xs bg-slate-50 p-2 rounded border border-slate-200 mb-2">
                                Terbobot = <br>Normalisasi × Bobot
                            </div>
                            <p class="text-slate-600">Mengalikan normalisasi dengan bobot kriteria</p>
                        </div>

                        <div class="bg-white p-3 rounded-lg border border-slate-200">
                            <p class="font-bold text-slate-700 mb-1">3️⃣ Nilai Akhir</p>
                            <div class="font-mono text-xs bg-slate-50 p-2 rounded border border-slate-200 mb-2">
                                Nilai Akhir = <br>Σ (Semua Terbobot)
                            </div>
                            <p class="text-slate-600">Menjumlahkan semua nilai terbobot</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end flex-shrink-0">
            <button type="button" onclick="closeDetailModal()"
                class="px-6 py-2.5 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-slate-700 transition">
                <i class="fas fa-times mr-2"></i> Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk membuka modal detail perhitungan
    window.openDetailModal = async function(perhitunganId, nama) {
        const modal = document.getElementById('modalDetailPerhitungan');
        const backdrop = document.getElementById('detailBackdrop');
        const content = document.getElementById('detailContent');
        const loading = document.getElementById('detailLoading');
        const dataContainer = document.getElementById('detailDataContainer');

        // Set nama pendaftar
        document.getElementById('detailNamaPendaftar').textContent = nama;

        // Reset state
        loading.classList.remove('hidden');
        dataContainer.classList.add('hidden');

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Fetch data
        try {
            const response = await fetch(`/admin/perhitungan/detail/${perhitunganId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Gagal memuat data');

            const result = await response.json();

            if (result.success) {
                renderDetailData(result.data);
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memuat Data',
                text: error.message,
                confirmButtonColor: '#f97316'
            });
            closeDetailModal();
        }
    }

    // ✅ FUNGSI RENDER DATA - SUDAH DIPERBAIKI
    function renderDetailData(data) {
        const loading = document.getElementById('detailLoading');
        const dataContainer = document.getElementById('detailDataContainer');
        const tableBody = document.getElementById('detailTableBody');

        // Set info umum
        document.getElementById('detailRanking').textContent = data.pendaftaran.perhitungan.ranking;
        document.getElementById('detailNilaiAkhir').textContent = (data.pendaftaran.perhitungan.nilai_akhir * 100)
            .toFixed(2);

        // Set status
        const statusEl = document.getElementById('detailStatus');
        const status = data.pendaftaran.perhitungan.status_kelulusan;
        if (status === 'diterima') {
            statusEl.innerHTML =
                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700"><i class="fas fa-check-circle mr-1"></i> Diterima</span>';
        } else if (status === 'cadangan') {
            statusEl.innerHTML =
                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700"><i class="fas fa-clock mr-1"></i> Cadangan</span>';
        } else if (status === 'tidak_diterima') {
            statusEl.innerHTML =
                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700"><i class="fas fa-times-circle mr-1"></i> Tidak Diterima</span>';
        } else {
            statusEl.innerHTML =
                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600"><i class="fas fa-minus mr-1"></i> Belum Ditentukan</span>';
        }

        // Render table
        tableBody.innerHTML = '';
        let totalTerbobot = 0;

        data.details.forEach((item, index) => {
            // ✅ PERBAIKAN: Parse nilai terbobot sebagai float dengan benar
            const nilaiTerbobot = parseFloat(item.nilai_terbobot);
            const nilaiNormalisasi = parseFloat(item.nilai_normalisasi);
            const bobot = parseFloat(item.bobot);

            totalTerbobot += nilaiTerbobot;

            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50 transition';

            // Format nilai asli (jika kriteria ekonomi, format rupiah)
            let nilaiAsliFormatted = item.nilai_asli;
            if (item.kode === 'C3') {
                nilaiAsliFormatted = 'Rp ' + new Intl.NumberFormat('id-ID').format(item.nilai_asli);
            } else {
                nilaiAsliFormatted = parseFloat(item.nilai_asli).toFixed(2);
            }

            row.innerHTML = `
            <td class="py-3 px-4">
                <div>
                    <p class="font-semibold text-slate-700">${item.kriteria}</p>
                    <p class="text-xs text-slate-400">${item.kode}</p>
                </div>
            </td>
            <td class="py-3 px-4 text-center">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold ${item.jenis === 'benefit' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'}">
                    ${item.jenis === 'benefit' ? '<i class="fas fa-arrow-up mr-1"></i> Benefit' : '<i class="fas fa-arrow-down mr-1"></i> Cost'}
                </span>
            </td>
            <td class="py-3 px-4 text-center font-mono text-slate-600">
                ${nilaiAsliFormatted}
            </td>
            <td class="py-3 px-4 text-center">
                <div class="flex flex-col items-center gap-1">
                    <span class="font-bold text-blue-600">${nilaiNormalisasi.toFixed(4)}</span>
                    <div class="w-24 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-400 to-blue-600" style="width: ${(nilaiNormalisasi * 100).toFixed(1)}%"></div>
                    </div>
                </div>
            </td>
            <td class="py-3 px-4 text-center">
                <span class="font-bold text-orange-600">${(bobot * 100).toFixed(0)}%</span>
            </td>
            <td class="py-3 px-4 text-center">
                <div class="flex flex-col items-center">
                    <span class="text-lg font-bold text-slate-800">${nilaiTerbobot.toFixed(4)}</span>
                    <span class="text-xs text-slate-400">(${(nilaiTerbobot * 100).toFixed(2)}%)</span>
                </div>
            </td>
        `;

            tableBody.appendChild(row);
        });

        // ✅ PERBAIKAN: Set total nilai dengan format yang BENAR dan KONSISTEN
        const nilaiAkhir = data.pendaftaran.perhitungan.nilai_akhir;
        document.getElementById('detailTotalNilai').innerHTML = `
        <span class="block">${parseFloat(nilaiAkhir).toFixed(4)}</span>
        <span class="text-xs text-slate-500 block mt-0.5">(${(nilaiAkhir * 100).toFixed(2)}%)</span>
    `;

        // Show data
        loading.classList.add('hidden');
        dataContainer.classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    window.closeDetailModal = function() {
        const modal = document.getElementById('modalDetailPerhitungan');
        const backdrop = document.getElementById('detailBackdrop');
        const content = document.getElementById('detailContent');

        backdrop.classList.add('opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
</script>
