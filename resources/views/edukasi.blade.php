<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
            {{ __('Edukasi PCOS & Kesehatan Reproduksi') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-[calc(100vh-4rem)]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Intro Banner -->
            <div class="bg-gradient-to-r from-[#8F55EB] to-[#7A42D1] text-white p-8 rounded-3xl mb-8 relative overflow-hidden shadow-xl shadow-purple-200/20">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-xl"></div>
                <div class="max-w-2xl relative z-10">
                    <span class="bg-white/15 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3 inline-block">Wawasan Medis</span>
                    <h3 class="text-2xl font-extrabold mb-2">Pahami Tubuhmu, Lindungi Kesehatanmu</h3>
                    <p class="text-white/80 text-sm leading-relaxed font-medium">Temukan artikel informatif, tips nutrisi, dan gaya hidup sehat yang dirancang khusus untuk membantu mengelola gejala PCOS.</p>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Article Card 1 -->
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-md shadow-gray-200/30 hover:scale-[1.01] transition-transform duration-300">
                    <div class="h-48 bg-purple-50 flex items-center justify-center p-6 relative">
                        <!-- Medical Book Illustration / Icon -->
                        <span class="bg-white text-[#8F55EB] rounded-2xl p-4 shadow-md">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-[#8F55EB] uppercase tracking-wider block mb-1">Materi Dasar</span>
                        <h4 class="font-extrabold text-gray-900 text-lg mb-2 hover:text-[#8F55EB] transition-colors cursor-pointer">Apa Itu Polycystic Ovary Syndrome (PCOS)?</h4>
                        <p class="text-sm text-gray-500 font-medium leading-relaxed mb-4">Pahami definisi PCOS, penyebab hormonal, serta kriteria diagnosis klinis yang digunakan oleh dokter spesialis obstetri.</p>
                        <a href="https://www.alodokter.com/pcos" target="_blank" rel="noopener noreferrer" class="text-[#8F55EB] text-xs font-bold hover:underline inline-flex items-center gap-1">
                            Baca Selengkapnya
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Article Card 2 -->
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-md shadow-gray-200/30 hover:scale-[1.01] transition-transform duration-300">
                    <div class="h-48 bg-indigo-50/50 flex items-center justify-center p-6 relative">
                        <!-- Diet Salad Icon -->
                        <span class="bg-white text-[#8F55EB] rounded-2xl p-4 shadow-md">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                            </svg>
                        </span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-indigo-500 uppercase tracking-wider block mb-1">Gaya Hidup</span>
                        <h4 class="font-extrabold text-gray-900 text-lg mb-2 hover:text-[#8F55EB] transition-colors cursor-pointer">Panduan Nutrisi & Diet Sehat PCOS</h4>
                        <p class="text-sm text-gray-500 font-medium leading-relaxed mb-4">Pelajari makanan rendah indeks glikemik, menu anti-inflamasi, dan pentingnya menghindari asupan gula berlebih bagi penderita PCOS.</p>
                        <a href="https://ciputrahospital.com/makanan-untuk-penderita-pcos" target="_blank" rel="noopener noreferrer" class="text-[#8F55EB] text-xs font-bold hover:underline inline-flex items-center gap-1">
                            Baca Selengkapnya
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Article Card 3 -->
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-md shadow-gray-200/30 hover:scale-[1.01] transition-transform duration-300">
                    <div class="h-48 bg-purple-50 flex items-center justify-center p-6 relative">
                        <!-- Hormone / Science Icon -->
                        <span class="bg-white text-[#8F55EB] rounded-2xl p-4 shadow-md">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75 9 12m0 0-.75 2.25M9 12h5.25m0 0 .75-2.25M14.25 12l.75 2.25M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-purple-600 uppercase tracking-wider block mb-1">Kesehatan Medis</span>
                        <h4 class="font-extrabold text-gray-900 text-lg mb-2 hover:text-[#8F55EB] transition-colors cursor-pointer">Resistensi Insulin & Hubungannya dengan PCOS</h4>
                        <p class="text-sm text-gray-500 font-medium leading-relaxed mb-4">Mengapa penderita PCOS rentan mengalami resistensi insulin dan bagaimana olahraga intensitas rendah membantu mengatasinya.</p>
                        <a href="https://mmchospital.co.id/metrohealth/meningkatkan-kebugaran-untuk-cegah-pcos" target="_blank" rel="noopener noreferrer" class="text-[#8F55EB] text-xs font-bold hover:underline inline-flex items-center gap-1">
                            Baca Selengkapnya
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
