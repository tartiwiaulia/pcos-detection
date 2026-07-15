<x-guest-layout>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 bg-white antialiased">
        
        <!-- Left Column: Branding / Info (Hidden on mobile) -->
        <div class="hidden lg:flex lg:col-span-5 flex-col justify-between p-12 lg:p-16 bg-[#8F55EB] text-white relative overflow-hidden">
            <!-- Decorative Background Glows -->
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            
            <!-- Top Badge -->
            <div class="z-10">
                <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/10 shadow-sm text-xs font-medium text-white/95 tracking-wide">
                    <!-- Neural Net SVG Icon -->
                    <svg class="w-3.5 h-3.5 text-purple-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <circle cx="6" cy="12" r="2.5" fill="currentColor" />
                        <circle cx="18" cy="6" r="2.5" fill="currentColor" />
                        <circle cx="18" cy="18" r="2.5" fill="currentColor" />
                        <line x1="8.5" y1="11" x2="15.5" y2="7" stroke="currentColor" />
                        <line x1="8.5" y1="13" x2="15.5" y2="17" stroke="currentColor" />
                    </svg>
                    Powered by Jaringan Saraf Tiruan
                </span>
            </div>

            <!-- Center Visual Panel -->
            <div class="my-auto py-8 z-10 flex flex-col items-center relative">
                <!-- Large Heart Glassmorphic Card -->
                <div class="relative bg-white/10 border border-white/15 rounded-[32px] w-64 h-64 flex items-center justify-center shadow-2xl backdrop-blur-md group hover:scale-[1.02] transition-transform duration-300">
                    <!-- Glowing Outline Heart SVG -->
                    <svg class="w-36 h-36 text-white/90 drop-shadow-[0_0_12px_rgba(255,255,255,0.35)]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    
                    <!-- Pulse Circle Badge (Top-Right overlay of the heart outline) -->
                    <div class="absolute top-[56px] right-[56px] bg-white text-[#8F55EB] rounded-full p-1.5 shadow-lg flex items-center justify-center w-9 h-9 border border-purple-100/50">
                        <!-- ECG Pulse Wave -->
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h3l3-7 4 14 3-10 2 3h3" />
                        </svg>
                    </div>
                </div>

                <!-- Floating Model Accuracy Badge -->
                <div class="absolute top-1/2 -right-8 transform -translate-y-1/2 bg-white text-gray-800 p-3 px-4 rounded-2xl shadow-xl flex items-center gap-3 border border-purple-50/50 z-20 hover:translate-x-1 transition-transform duration-300">
                    <span class="text-[#8F55EB] bg-purple-50 p-2 rounded-xl flex items-center justify-center shadow-sm">
                        <!-- Shield Check Icon -->
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                    </span>
                    <div class="flex flex-col text-left">
                        <span class="text-[10px] font-bold text-gray-400 tracking-wide uppercase">Akurasi Model</span>
                        <span class="text-base font-extrabold text-gray-900 leading-tight">86%</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Content (Headers & Statistics) -->
            <div class="z-10 text-left mt-auto">
                <h1 class="text-3.5xl font-extrabold leading-tight text-white mb-4 tracking-tight">
                    Kenali Risiko PCOS Lebih Awal dengan Bantuan AI
                </h1>
                <p class="text-white/80 text-sm leading-relaxed max-w-md mb-10 font-medium">
                    Deteksi dini gejala Polycystic Ovary Syndrome menggunakan pendekatan Jaringan Saraf Tiruan yang cepat, akurat, dan privat.
                </p>

                <!-- Statistics Widgets Grid -->
                @php
                    $formatStat = fn ($n) => $n >= 1000 ? round($n / 1000, 1) . 'k+' : (string) $n;
                @endphp
                <div class="grid grid-cols-3 gap-3 w-full">
                    <div class="bg-white/10 border border-white/5 rounded-2xl px-5 py-4 backdrop-blur-md hover:bg-white/15 transition-colors duration-250">
                        <span class="text-xl font-extrabold text-white block mb-0.5">{{ $formatStat($userCount) }}</span>
                        <span class="text-white/70 text-xs font-semibold">Pengguna</span>
                    </div>
                    <div class="bg-white/10 border border-white/5 rounded-2xl px-5 py-4 backdrop-blur-md hover:bg-white/15 transition-colors duration-250">
                        <span class="text-xl font-extrabold text-white block mb-0.5">{{ $formatStat($predictionCount) }}</span>
                        <span class="text-white/70 text-xs font-semibold">Pemeriksaan</span>
                    </div>
                    <div class="bg-white/10 border border-white/5 rounded-2xl px-5 py-4 backdrop-blur-md hover:bg-white/15 transition-colors duration-250">
                        <span class="text-xl font-extrabold text-white block mb-0.5">86%</span>
                        <span class="text-white/70 text-xs font-semibold">Akurasi</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Login Form -->
        <div class="lg:col-span-7 flex flex-col justify-center px-6 sm:px-16 lg:px-24 xl:px-32 py-16 bg-white min-h-screen w-full">
            <div class="max-w-md w-full mx-auto">
                
                <!-- Logo Brand -->
                <div class="flex items-center gap-3 mb-10">
                    <div class="bg-[#8F55EB] text-white rounded-2xl p-2 flex items-center justify-center w-11 h-11 shadow-md shadow-purple-200/50">
                        <!-- ECG Wave Logo Icon -->
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h3l3-7 4 14 3-10 2 3h3" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-gray-900">PCOS <span class="text-[#8F55EB] font-semibold">Check</span></span>
                </div>

                <!-- Titles -->
                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">Selamat datang kembali</h2>
                    <p class="text-gray-500 text-sm font-medium">Masuk untuk melanjutkan pemeriksaan kesehatan Anda.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-5" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-2">EMAIL</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <!-- Envelope SVG Icon -->
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required 
                                   autofocus 
                                   autocomplete="username" 
                                   class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-[#8F55EB]/20 focus:border-[#8F55EB] transition-colors placeholder:text-gray-400 text-sm"
                                   placeholder="demo@pcoscheck.app" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-2">KATA SANDI</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <!-- Lock SVG Icon -->
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-3 1.5h15a2.25 2.25 0 0 1 2.25 2.25v6.75a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V14.25a2.25 2.25 0 0 1 2.25-2.25Z" />
                                </svg>
                            </div>
                            <input id="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   name="password"
                                   required
                                   autocomplete="current-password" 
                                   class="block w-full pl-11 pr-11 py-3.5 border border-gray-200 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-[#8F55EB]/20 focus:border-[#8F55EB] transition-colors placeholder:text-gray-400 text-sm"
                                   placeholder="••••••••" />
                            
                            <!-- Toggle Password Visibility Button -->
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                <!-- Eye SVG Icon (when password is hidden) -->
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <!-- Eye Slash SVG Icon (when password is shown) -->
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.815 7.815 3 3m-3-3a9.963 9.963 0 0 1-5.714 1.785a9.969 9.969 0 0 1-3.16-.513M12 7.5a4.5 4.5 0 0 1 4.5 4.5m-4.5-4.5A4.5 4.5 0 0 0 7.5 12m0 0a4.5 4.5 0 0 0 4.5 4.5M12 7.5v9" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember" 
                                   class="rounded border-gray-300 text-[#8F55EB] focus:ring-[#8F55EB]/30 h-4.5 w-4.5 transition-colors cursor-pointer" />
                            <span class="ms-2.5 text-sm text-gray-600 font-semibold">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-sm font-semibold text-[#8F55EB] hover:text-[#7A42D1] transition-colors">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-[#8F55EB] hover:bg-[#7c44db] text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-purple-200/50 hover:shadow-xl hover:shadow-purple-200/60 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#8F55EB] transition duration-150 ease-in-out text-center cursor-pointer text-sm">
                            Masuk
                        </button>
                    </div>
                </form>

                <!-- Footer Register Link -->
                <div class="mt-8 text-center text-sm text-gray-500 font-medium">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" 
                       class="font-semibold text-[#8F55EB] hover:text-[#7A42D1] transition-colors ml-1">
                        Daftar sekarang
                    </a>
                </div>

            </div>
        </div>

    </div>
</x-guest-layout>
