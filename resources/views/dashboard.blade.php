<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-[calc(100vh-4rem)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Purple Welcome Banner -->
            <div class="bg-gradient-to-r from-[#8F55EB] to-[#7A42D1] text-white rounded-3xl p-8 mb-8 relative overflow-hidden shadow-xl shadow-purple-200/20">
                <!-- Background Decorative Glows -->
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-purple-400/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 max-w-3xl">
                    <h1 class="text-3xl font-extrabold mb-3 tracking-tight">
                        Halo, {{ Auth::user()->name }} 👋
                    </h1>
                    <p class="text-white/80 text-base font-medium mb-8 leading-relaxed max-w-xl">
                        Setiap pemeriksaan adalah langkah kecil yang besar untuk kesehatanmu. Jaga konsistensi dan dengarkan tubuhmu hari ini.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('pemeriksaan') }}" class="inline-flex items-center gap-2 bg-white text-[#8F55EB] hover:bg-purple-50 font-bold px-6 py-3.5 rounded-xl shadow-lg transition-transform duration-200 hover:scale-[1.02] text-sm">
                            <!-- Plus SVG Icon -->
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Mulai Pemeriksaan Baru
                        </a>
                        <a href="{{ route('edukasi') }}" class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/20 border border-white/10 font-bold px-6 py-3.5 rounded-xl transition duration-150 text-sm">
                            Pelajari PCOS
                        </a>
                    </div>
                </div>
            </div>

            <!-- Two-Column Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Section: Chart and History List (Col-span 2) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- 1. Risk Trend Chart Card -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 shadow-md shadow-gray-200/35">
                        <div class="mb-5">
                            <h3 class="text-lg font-extrabold text-gray-900 mb-1">Perkembangan Hasil Pemeriksaan</h3>
                            <p class="text-xs font-semibold text-gray-400">Grafik skor risiko dari pemeriksaan sebelumnya</p>
                        </div>

                        <!-- SVG Premium Mock Chart -->
                        <div class="relative w-full h-56 bg-gray-50/50 border border-gray-100 rounded-2xl p-4 flex items-center justify-center overflow-hidden">
                            <svg class="w-full h-full" viewBox="0 0 500 180" preserveAspectRatio="none">
                                <defs>
                                    <!-- Area Gradient -->
                                    <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#8F55EB" stop-opacity="0.22" />
                                        <stop offset="100%" stop-color="#8F55EB" stop-opacity="0" />
                                    </linearGradient>
                                    <!-- Line Stroke Glow -->
                                    <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                                        <feGaussianBlur stdDeviation="3" result="blur" />
                                        <feComposite in="SourceGraphic" in2="blur" operator="over" />
                                    </filter>
                                </defs>

                                <!-- Grid Lines -->
                                <line x1="0" y1="30" x2="500" y2="30" stroke="#f1f5f9" stroke-width="1.5" />
                                <line x1="0" y1="80" x2="500" y2="80" stroke="#f1f5f9" stroke-width="1.5" />
                                <line x1="0" y1="130" x2="500" y2="130" stroke="#f1f5f9" stroke-width="1.5" />

                                <!-- Area Path -->
                                <path d="M 50 140 Q 150 110, 250 70 T 450 100 L 450 160 L 50 160 Z" fill="url(#chartGradient)" />

                                <!-- Line Path -->
                                <path d="M 50 140 Q 150 110, 250 70 T 450 100" fill="none" stroke="#8F55EB" stroke-width="3" stroke-linecap="round" filter="url(#glow)" />

                                <!-- Interactive Dots -->
                                <circle cx="50" cy="140" r="5" fill="#ffffff" stroke="#8F55EB" stroke-width="2.5" class="hover:scale-125 transition-transform duration-200 cursor-pointer" />
                                <circle cx="210" cy="90" r="5" fill="#ffffff" stroke="#8F55EB" stroke-width="2.5" class="hover:scale-125 transition-transform duration-200 cursor-pointer" />
                                <circle cx="340" cy="80" r="5" fill="#ffffff" stroke="#8F55EB" stroke-width="2.5" class="hover:scale-125 transition-transform duration-200 cursor-pointer" />
                                <circle cx="450" cy="100" r="5" fill="#ffffff" stroke="#8F55EB" stroke-width="2.5" class="hover:scale-125 transition-transform duration-200 cursor-pointer" />

                                <!-- Tooltip Value text labels (simulated) -->
                                <text x="50" y="125" font-family="Figtree, sans-serif" font-size="9" font-weight="bold" fill="#8F55EB" text-anchor="middle">12%</text>
                                <text x="210" y="75" font-family="Figtree, sans-serif" font-size="9" font-weight="bold" fill="#8F55EB" text-anchor="middle">45%</text>
                                <text x="340" y="65" font-family="Figtree, sans-serif" font-size="9" font-weight="bold" fill="#8F55EB" text-anchor="middle">60%</text>
                                <text x="450" y="85" font-family="Figtree, sans-serif" font-size="9" font-weight="bold" fill="#8F55EB" text-anchor="middle">38%</text>
                            </svg>

                            <!-- Custom Chart X-Axis Labels -->
                            <div class="absolute bottom-2 left-0 right-0 px-10 flex justify-between text-[10px] font-bold text-gray-400 tracking-wider">
                                <span>Maret</span>
                                <span>Mei</span>
                                <span>Juni</span>
                                <span>Juli</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Recent Checks History Card -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 shadow-md shadow-gray-200/35">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-extrabold text-gray-900 mb-1">Riwayat Terbaru</h3>
                                <p class="text-xs font-semibold text-gray-400">{{ $predictions->count() }} pemeriksaan terakhir</p>
                            </div>
                            <a href="{{ route('riwayat') }}" class="text-sm font-bold text-[#8F55EB] hover:text-[#7A42D1] transition-colors">
                                Lihat semua
                            </a>
                        </div>
                        @forelse ($predictions as $prediction)
                            <div class="flex items-center justify-between p-4 mb-3 border border-gray-100 rounded-2xl">
                                <div>
                                    <span class="font-bold text-gray-800 text-sm">Risiko {{ $prediction->result_status }}</span>
                                    <span class="text-xs text-gray-400 block">{{ $prediction->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <span class="font-extrabold text-[#8F55EB] text-sm">{{ $prediction->probability }}%</span>
                            </div>
                        @empty

                        <!-- Empty State Checklist Box -->
                        <div class="border border-dashed border-gray-200 rounded-2xl p-8 text-center flex flex-col items-center">
                            <span class="bg-purple-50 text-[#8F55EB] rounded-2xl p-4 mb-4 flex items-center justify-center w-14 h-14 shadow-inner">
                                <!-- Clipboard Checklist Icon -->
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                                </svg>
                            </span>
                            <h4 class="text-base font-bold text-gray-800 mb-1">Belum ada riwayat</h4>
                            <p class="text-gray-400 font-medium text-xs max-w-sm mb-6 leading-relaxed">
                                Mulai pemeriksaan pertamamu untuk melihat hasil dan rekomendasi dari sistem.
                            </p>
                            <a href="{{ route('pemeriksaan') }}" class="bg-[#8F55EB] hover:bg-[#7c44db] text-white font-bold py-2.5 px-6 rounded-xl shadow-md shadow-purple-200/50 hover:shadow-lg transition duration-150 text-xs">
                                Mulai Sekarang
                            </a>
                        </div>
                        @endforelse
                    </div>

                </div>

                <!-- Right Section: Tips and Habit Trackers (Col-span 1) -->
                <div>
                    <!-- Tips Checklist Card -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 shadow-md shadow-gray-200/35">
                        <div class="mb-6">
                            <h3 class="text-lg font-extrabold text-gray-900 mb-1">Tips Hari Ini</h3>
                            <p class="text-xs font-semibold text-gray-400">Saran kecil, dampak besar</p>
                        </div>

                        <!-- Habit Checklist using Alpine.js to allow users to toggle tasks interactive -->
                        <div x-data="{
                            items: [
                                { id: 1, text: 'Minum air minimal 2 liter hari ini', checked: false },
                                { id: 2, text: 'Jalan kaki 20 menit setelah makan siang', checked: false },
                                { id: 3, text: 'Tidur sebelum jam 23.00', checked: false },
                                { id: 4, text: 'Konsumsi sayur hijau di salah satu makan', checked: false }
                            ]
                        }" class="space-y-3.5">

                            <template x-for="item in items" :key="item.id">
                                <label class="flex items-start gap-3.5 p-3.5 rounded-2xl border border-gray-100 cursor-pointer select-none transition-all duration-200"
                                       :class="item.checked ? 'bg-purple-50/20 border-[#8F55EB]/10' : 'bg-gray-50/50 hover:bg-gray-50 hover:border-gray-200'">

                                    <!-- Custom Animated Checkbox -->
                                    <div class="relative flex items-center justify-center mt-0.5">
                                        <input type="checkbox"
                                               x-model="item.checked"
                                               class="sr-only" />
                                        <div class="w-5 h-5 rounded-md border-2 transition-all duration-200 flex items-center justify-center"
                                             :class="item.checked ? 'bg-[#8F55EB] border-[#8F55EB]' : 'border-gray-300 bg-white'">
                                            <!-- Check Mark SVG -->
                                            <svg x-show="item.checked" class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Text Content -->
                                    <span class="text-sm transition-all duration-250"
                                          :class="item.checked ? 'line-through text-gray-400 font-medium' : 'text-gray-700 font-semibold'">
                                        <span x-text="item.text"></span>
                                    </span>

                                </label>
                            </template>

                        </div>

                        <!-- Progress Bar bottom banner -->
                        <div x-data class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-gray-400 uppercase tracking-wide">
                            <span>Saran Kesehatan</span>
                            <span class="text-[#8F55EB] bg-purple-50 px-2.5 py-0.5 rounded-full">Updated Daily</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
