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

            @forelse ($predictions as $prediction)
                <div class="bg-white border border-gray-100 rounded-2xl p-6 mb-4 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="font-bold text-gray-800">Risiko {{ $prediction->result_status }}</span>
                        <span class="text-sm text-gray-400 block">{{ $prediction->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <span class="font-extrabold text-[#8F55EB]">{{ $prediction->probability }}%</span>
                </div>
            @empty
                <!-- Empty State Card  -->
                <div class="bg-white border border-gray-100 rounded-3xl p-12 text-center shadow-lg shadow-gray-200/50 flex flex-col items-center">
                    ...
                </div>
            @endforelse

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
