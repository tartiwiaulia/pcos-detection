<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
            {{ __('Riwayat Pemeriksaan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-[calc(100vh-4rem)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filter Bar -->
            <div class="flex items-center justify-between mb-6 bg-white border border-gray-100 p-4 rounded-2xl shadow-sm">
                <span class="text-sm font-bold text-gray-500">Menampilkan 0 hasil pemeriksaan</span>
                <button class="text-[#8F55EB] text-xs font-bold hover:underline">Urutkan terbaru</button>
            </div>

            <!-- Empty State Card -->
            <div class="bg-white border border-gray-100 rounded-3xl p-12 text-center shadow-lg shadow-gray-200/50 flex flex-col items-center">
                <div class="bg-purple-50 text-[#8F55EB] rounded-full p-6 mb-6 flex items-center justify-center w-20 h-20 shadow-inner">
                    <!-- Shield Alert / History icon -->
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Belum Ada Riwayat Pemeriksaan</h3>
                <p class="text-gray-500 font-medium text-sm max-w-md mb-8 leading-relaxed">
                    Sistem belum menemukan data pemeriksaan kesehatan Anda. Silakan mulai pemeriksaan pertama Anda untuk melihat perkembangan hasil risiko PCOS dan rekomendasi medis dari AI.
                </p>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('pemeriksaan') }}" class="bg-[#8F55EB] hover:bg-[#7c44db] text-white font-semibold py-3.5 px-6 rounded-xl shadow-md shadow-purple-200/50 hover:shadow-lg transition duration-150 text-sm">
                        Mulai Pemeriksaan Sekarang
                    </a>
                    <a href="{{ route('edukasi') }}" class="bg-white border border-gray-200 hover:border-gray-300 text-gray-700 font-semibold py-3.5 px-6 rounded-xl transition duration-150 text-sm">
                        Pelajari PCOS
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
