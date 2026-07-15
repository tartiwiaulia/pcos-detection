{{--
    Widget chatbot AI (Gemini) khusus seputar PCOS & kesehatan reproduksi wanita.

    Dua mode:
    - <x-pcos-chatbot />                 -> tombol melayang pojok kanan-bawah (toggle buka/tutup)
    - <x-pcos-chatbot mode="inline" />    -> panel nempel langsung di tempatnya (mis. di dalam card hasil), selalu terbuka

    Aktif setelah menerima event window "prediction-ready" berisi { id } dari hasil
    pemeriksaan (dipicu di pemeriksaan.blade.php: this.$dispatch('prediction-ready', ...)).
    Konteks (level risiko, skor, gejala) diambil ulang dari server berdasarkan id itu,
    bukan dikirim dari klien, supaya tidak bisa dimanipulasi lewat DevTools.
--}}
@props(['mode' => 'floating'])

<div
    x-data="{
        open: {{ $mode === 'inline' ? 'true' : 'false' }},
        loading: false,
        predictionId: null,
        input: '',
        error: '',
        messages: [],

        init() {
            window.addEventListener('prediction-ready', (event) => {
                this.predictionId = event.detail.id;
                this.messages = [];
                this.error = '';
            });
        },

        async send() {
            const text = this.input.trim();
            if (!text || this.loading) return;

            this.messages.push({ role: 'user', text });
            this.input = '';
            this.loading = true;
            this.error = '';

            try {
                const response = await fetch('{{ route('chatbot.ask') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        message: text,
                        prediction_id: this.predictionId,
                        history: this.messages.slice(0, -1).map(m => ({ role: m.role, text: m.text })),
                    }),
                });

                if (!response.ok) throw new Error('Respons tidak valid');

                const result = await response.json();
                this.messages.push({ role: 'model', text: result.reply });
            } catch (err) {
                this.error = 'Asisten sedang tidak bisa dihubungi. Coba lagi sebentar lagi.';
            } finally {
                this.loading = false;
                $nextTick(() => {
                    if ($refs.scroll) $refs.scroll.scrollTop = $refs.scroll.scrollHeight;
                });
            }
        },
    }"
    x-show="predictionId"
    x-cloak
    @class([
        'fixed bottom-5 right-5 z-50' => $mode === 'floating',
        'relative w-full' => $mode === 'inline',
    ])
>
    @if ($mode === 'floating')
        <!-- Toggle Button -->
        <button
            @click="open = !open"
            type="button"
            aria-label="Buka asisten PCOS"
            class="w-14 h-14 rounded-full bg-gradient-to-br from-[#8F55EB] to-[#B45CDE] text-white shadow-xl shadow-purple-300/50 flex items-center justify-center hover:scale-105 active:scale-95 transition-transform duration-200"
        >
            <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
            </svg>
            <svg x-show="open" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    @endif

    <!-- Chat Panel -->
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        @class([
            'absolute bottom-[4.5rem] right-0 w-[92vw] max-w-sm sm:w-96 h-[28rem] max-h-[75vh]' => $mode === 'floating',
            'w-full h-[26rem]' => $mode === 'inline',
            'bg-white rounded-3xl shadow-2xl shadow-purple-200/50 border border-purple-100 flex flex-col overflow-hidden' => true,
        ])
    >
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#8F55EB] to-[#B45CDE] text-white px-5 py-4 flex items-center gap-3 shrink-0">
            <span class="bg-white/15 rounded-xl p-2 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 21l-.813-5.096L3 15l5.096-.813L9 9l.813 5.096L15 15l-5.187.904ZM18 7.5 16.5 12 15 7.5 10.5 6 15 4.5 16.5 0 18 4.5 22.5 6 18 7.5Z" />
                </svg>
            </span>
            <div class="min-w-0">
                <p class="font-extrabold text-sm leading-tight">Asisten PCOS</p>
                <p class="text-[11px] text-white/80 font-medium truncate">Tanya seputar hasil & gejala PCOS-mu</p>
            </div>
        </div>

        <!-- Messages -->
        <div x-ref="scroll" class="flex-1 min-h-0 overflow-y-auto px-4 py-4 space-y-3 bg-gray-50/50">
            <div class="bg-purple-50 text-gray-700 text-xs font-medium rounded-2xl rounded-tl-sm px-4 py-2.5 max-w-[85%]">
                Halo! Saya Asisten PCOS 🌸 Kamu bisa tanya soal hasil pemeriksaanmu, gejala, atau kesehatan reproduksi wanita di sini.
            </div>

            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                    <div
                        class="text-xs font-medium px-4 py-2.5 max-w-[85%] whitespace-pre-line leading-relaxed break-words"
                        :class="msg.role === 'user'
                            ? 'bg-[#8F55EB] text-white rounded-2xl rounded-tr-sm'
                            : 'bg-white border border-gray-100 text-gray-700 rounded-2xl rounded-tl-sm shadow-sm'"
                        x-text="msg.text"
                    ></div>
                </div>
            </template>

            <!-- Loading indicator -->
            <div x-show="loading" x-cloak class="flex justify-start">
                <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#8F55EB] animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#8F55EB] animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#8F55EB] animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>

            <p x-show="error" x-cloak class="text-[11px] font-semibold text-red-500 px-1" x-text="error"></p>
        </div>

        <!-- Input -->
        <form @submit.prevent="send()" class="border-t border-gray-100 p-3 flex items-center gap-2 bg-white shrink-0">
            <input
                type="text"
                x-model="input"
                placeholder="Tulis pertanyaan..."
                :disabled="loading"
                class="flex-1 text-sm px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#8F55EB]/20 focus:border-[#8F55EB] disabled:opacity-50"
            />
            <button
                type="submit"
                :disabled="loading || !input.trim()"
                class="w-10 h-10 shrink-0 rounded-xl bg-gradient-to-br from-[#8F55EB] to-[#B45CDE] text-white flex items-center justify-center disabled:opacity-40 disabled:cursor-not-allowed hover:brightness-105 transition"
                aria-label="Kirim pesan"
            >
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.126A59.768 59.768 0 0 1 21.485 12 59.77 59.77 0 0 1 3.27 20.876L5.999 12Zm0 0h7.5" />
                </svg>
            </button>
        </form>
    </div>
</div>
