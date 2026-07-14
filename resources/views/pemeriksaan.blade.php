<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-[calc(100vh-4rem)]" x-data="{
        step: 1,
        submitting: false,
        
        // Step 1 variables
        age: 24,
        weight: 58,
        height: 158,
        systolic: 120,
        diastolic: 80,
        
        // Step 2 variables
        cycle_length: 28,
        period_duration: 5,
        cycle_irregularity: false,
        severe_pain: false,
        
        // Step 3 variables
        hirsutism: false,
        weight_gain: false,
        severe_acne: false,
        hair_loss: false,
        dark_skin: false,
        
        // Calculated result variables
        risk_score: 0,
        risk_level: '', // 'Rendah', 'Sedang', 'Tinggi'
        risk_color: '',
        error_message: '',

        // Alamat API model AI (FastAPI). Sesuaikan kalau di-deploy ke domain lain.
        aiApiUrl: 'http://127.0.0.1:8000/predict',

        // Methods
        validateStep1() {
            return this.systolic > 0 && this.diastolic > 0;
        },
        validateStep2() {
            return this.cycle_length > 0 && this.period_duration > 0;
        },

        nextStep() {
            if (this.step === 1 && !this.validateStep1()) {
                alert('Silakan isi tekanan darah sistolik dan diastolik Anda terlebih dahulu.');
                return;
            }
            if (this.step === 2 && !this.validateStep2()) {
                alert('Silakan isi panjang siklus dan durasi haid terlebih dahulu.');
                return;
            }
            this.step++;
        },
        prevStep() {
            if (this.step > 1) this.step--;
        },
        applyRiskColor() {
            if (this.risk_score < 35) {
                this.risk_color = 'text-green-600 bg-green-50 border-green-200';
            } else if (this.risk_score < 70) {
                this.risk_color = 'text-amber-600 bg-amber-50 border-amber-200';
            } else {
                this.risk_color = 'text-red-600 bg-red-50 border-red-200';
            }
        },
        async submitAnalysis() {
            this.submitting = true;
            this.error_message = '';

            try {
                const response = await fetch(this.aiApiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        weight: this.weight,
                        height: this.height,
                        cycle_irregularity: this.cycle_irregularity,
                        weight_gain: this.weight_gain,
                        hirsutism: this.hirsutism,
                        severe_acne: this.severe_acne,
                        hair_loss: this.hair_loss,
                        dark_skin: this.dark_skin,
                    }),
                });

                if (!response.ok) {
                    throw new Error('Respons API tidak valid (' + response.status + ')');
                }

                const result = await response.json();
                this.risk_score = result.risk_score;
                this.risk_level = result.risk_level;
                this.applyRiskColor();
                this.step = 4;
            } catch (err) {
                this.error_message = 'Gagal terhubung ke server AI. Pastikan API model sedang berjalan di ' + this.aiApiUrl + '.';
            } finally {
                this.submitting = false;
            }
        }
    }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Powered by JST Pill Badge & Headers -->
            <div class="mb-8 text-center" x-show="step < 4 && !submitting">
                <div class="flex justify-center mb-2.5">
                    <span class="inline-flex items-center gap-1.5 bg-purple-50 text-[#8F55EB] text-[10px] font-bold px-3 py-1 rounded-full border border-purple-100 shadow-sm">
                        <!-- Neural Net SVG Icon -->
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <circle cx="6" cy="12" r="2.5" fill="currentColor" />
                            <circle cx="18" cy="6" r="2.5" fill="currentColor" />
                            <circle cx="18" cy="18" r="2.5" fill="currentColor" />
                            <line x1="8.5" y1="11" x2="15.5" y2="7" stroke="currentColor" />
                            <line x1="8.5" y1="13" x2="15.5" y2="17" stroke="currentColor" />
                        </svg>
                        Powered by JST
                    </span>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">Pemeriksaan Risiko PCOS</h1>
                <p class="text-gray-500 text-sm font-medium">Jawab pertanyaan dengan jujur untuk hasil yang akurat.</p>
            </div>

            <!-- API Error Banner -->
            <div class="max-w-3xl mx-auto mb-6 p-4 rounded-2xl border border-red-200 bg-red-50 text-red-700 text-sm font-semibold"
                 x-show="error_message && !submitting" x-cloak x-text="error_message">
            </div>

            <!-- Steps Tabs Navigation Layout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4 max-w-3xl mx-auto mb-8" x-show="step < 4 && !submitting">
                <!-- Step 1 Tab -->
                <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl border text-sm font-bold transition-all duration-200"
                     :class="step === 1 ? 'border-[#8F55EB] bg-purple-50/20 text-gray-900 shadow-sm' : (step > 1 ? 'border-emerald-100 bg-emerald-50/40 text-emerald-800' : 'border-gray-100 bg-white text-gray-400')">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black transition-all duration-200"
                         :class="step > 1 ? 'bg-emerald-600 text-white' : (step === 1 ? 'bg-[#8F55EB] text-white' : 'bg-gray-100 text-gray-400')">
                        <template x-if="step > 1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </template>
                        <template x-if="step === 1">
                            <span>1</span>
                        </template>
                    </div>
                    <div>
                        <span class="block text-sm leading-none mb-1">Data Diri</span>
                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block leading-none">Informasi dasar</span>
                    </div>
                </div>

                <!-- Step 2 Tab -->
                <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl border text-sm font-bold transition-all duration-200"
                     :class="step === 2 ? 'border-[#8F55EB] bg-purple-50/20 text-gray-900 shadow-sm' : (step > 2 ? 'border-emerald-100 bg-emerald-50/40 text-emerald-800' : 'border-gray-100 bg-white text-gray-400')">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black transition-all duration-200"
                         :class="step > 2 ? 'bg-emerald-600 text-white' : (step === 2 ? 'bg-[#8F55EB] text-white' : 'bg-gray-100 text-gray-400')">
                        <template x-if="step > 2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </template>
                        <template x-if="step <= 2">
                            <span>2</span>
                        </template>
                    </div>
                    <div>
                        <span class="block text-sm leading-none mb-1">Siklus Haid</span>
                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block leading-none">Pola menstruasi</span>
                    </div>
                </div>

                <!-- Step 3 Tab -->
                <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl border text-sm font-bold transition-all duration-200"
                     :class="step === 3 ? 'border-[#8F55EB] bg-purple-50/20 text-gray-900 shadow-sm' : 'border-gray-100 bg-white text-gray-400'">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-black transition-all duration-200"
                         :class="step === 3 ? 'bg-[#8F55EB] text-white' : 'bg-gray-100 text-gray-400'">
                        <span>3</span>
                    </div>
                    <div>
                        <span class="block text-sm leading-none mb-1">Gejala Fisik</span>
                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block leading-none">Indikasi gejala</span>
                    </div>
                </div>
            </div>

            <!-- STEP 1: DATA DIRI -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 shadow-xl shadow-gray-200/35 max-w-3xl mx-auto" 
                 x-show="step === 1 && !submitting" x-cloak>
                <div class="mb-8">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-1">Data Diri</h2>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed">Isi informasi dasar tentang dirimu.</p>
                </div>

                <div class="space-y-6">
                    <!-- Age Slider -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="age" class="text-xs font-bold text-gray-400 uppercase tracking-wide">Umur</label>
                            <span class="text-base font-extrabold text-[#8F55EB] bg-purple-50 px-3 py-1 rounded-xl" x-text="age + ' Tahun'"></span>
                        </div>
                        <input id="age" type="range" min="15" max="50" x-model="age" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#8F55EB]" />
                    </div>

                    <!-- Weight Slider -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="weight" class="text-xs font-bold text-gray-400 uppercase tracking-wide">Berat Badan</label>
                            <span class="text-base font-extrabold text-[#8F55EB] bg-purple-50 px-3 py-1 rounded-xl" x-text="weight + ' kg'"></span>
                        </div>
                        <input id="weight" type="range" min="30" max="150" x-model="weight" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#8F55EB]" />
                    </div>

                    <!-- Height Slider -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="height" class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tinggi Badan</label>
                            <span class="text-base font-extrabold text-[#8F55EB] bg-purple-50 px-3 py-1 rounded-xl" x-text="height + ' cm'"></span>
                        </div>
                        <input id="height" type="range" min="100" max="200" x-model="height" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#8F55EB]" />
                    </div>

                    <!-- Blood Pressure Inputs -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Tekanan Darah</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="systolic" class="block text-xs font-bold text-gray-400 mb-1.5 uppercase">Sistole (mmHg)</label>
                                <input id="systolic" type="number" x-model.number="systolic" required
                                       class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8F55EB]/20 focus:border-[#8F55EB] font-bold text-gray-800 text-sm" />
                            </div>
                            <div>
                                <label for="diastolic" class="block text-xs font-bold text-gray-400 mb-1.5 uppercase">Diastole (mmHg)</label>
                                <input id="diastolic" type="number" x-model.number="diastolic" required
                                       class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8F55EB]/20 focus:border-[#8F55EB] font-bold text-gray-800 text-sm" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Navigation -->
                <div class="mt-8 flex justify-end">
                    <button @click="nextStep()" 
                            class="bg-[#8F55EB] hover:bg-[#7c44db] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-purple-200/50 hover:shadow-xl transition-all duration-150 flex items-center gap-2 text-sm">
                        Selanjutnya
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- STEP 2: SIKLUS HAID -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 shadow-xl shadow-gray-200/35 max-w-3xl mx-auto" 
                 x-show="step === 2 && !submitting" x-cloak>
                <div class="mb-8">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-1">Siklus Haid</h2>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed">Informasi tentang pola menstruasimu.</p>
                </div>

                <!-- Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Panjang Siklus -->
                    <div>
                        <div class="flex items-center gap-1.5 mb-2">
                            <span class="text-[10px] font-extrabold text-gray-500 uppercase tracking-wide">Panjang Siklus (Hari)</span>
                            <svg class="w-3.5 h-3.5 text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <input type="number" x-model.number="cycle_length" 
                               class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8F55EB]/20 focus:border-[#8F55EB] font-bold text-gray-800 text-sm" />
                    </div>
                    <!-- Durasi Haid -->
                    <div>
                        <div class="flex items-center gap-1.5 mb-2">
                            <span class="text-[10px] font-extrabold text-gray-500 uppercase tracking-wide">Durasi Haid (Hari)</span>
                            <svg class="w-3.5 h-3.5 text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <input type="number" x-model.number="period_duration" 
                               class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#8F55EB]/20 focus:border-[#8F55EB] font-bold text-gray-800 text-sm" />
                    </div>
                </div>

                <!-- Toggles -->
                <div class="space-y-4 mb-8">
                    <!-- Siklus saya tidak teratur -->
                    <label class="flex items-center justify-between p-4 bg-white border border-gray-150 rounded-2xl cursor-pointer select-none transition-colors hover:bg-gray-50">
                        <div>
                            <span class="block text-sm font-bold text-gray-800 leading-tight">Siklus saya tidak teratur</span>
                            <span class="text-xs text-gray-400 font-medium">Berubah-ubah setiap bulan</span>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="cycle_irregularity" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-[#8F55EB]/20 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#8F55EB]"></div>
                        </div>
                    </label>

                    <!-- Nyeri haid berlebihan -->
                    <label class="flex items-center justify-between p-4 bg-white border border-gray-150 rounded-2xl cursor-pointer select-none transition-colors hover:bg-gray-50">
                        <div>
                            <span class="block text-sm font-bold text-gray-800 leading-tight">Nyeri haid berlebihan</span>
                            <span class="text-xs text-gray-400 font-medium">Mengganggu aktivitas harian</span>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="severe_pain" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-[#8F55EB]/20 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#8F55EB]"></div>
                        </div>
                    </label>
                </div>

                <!-- Footer Navigation -->
                <div class="mt-8 flex justify-between items-center border-t border-gray-100 pt-6">
                    <button @click="prevStep()" 
                            class="bg-white border border-gray-200 hover:border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl transition duration-150 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Kembali
                    </button>
                    <button @click="nextStep()" 
                            class="bg-[#8F55EB] hover:bg-[#7c44db] text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-purple-200/50 hover:shadow-xl transition duration-150 flex items-center gap-2 text-sm">
                        Selanjutnya
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- STEP 3: GEJALA FISIK -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 shadow-xl shadow-gray-200/35 max-w-3xl mx-auto" 
                 x-show="step === 3 && !submitting" x-cloak>
                <div class="mb-8">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-1">Gejala Fisik</h2>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed">Pilih gejala yang kamu alami.</p>
                </div>

                <!-- Toggles Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <!-- Pertumbuhan rambut berlebih -->
                    <label class="flex items-center justify-between p-4 bg-white border border-gray-150 rounded-2xl cursor-pointer select-none transition-colors hover:bg-gray-50">
                        <div>
                            <span class="block text-sm font-bold text-gray-800 leading-tight">Pertumbuhan rambut berlebih</span>
                            <span class="text-xs text-gray-400 font-medium">Wajah, dada, perut</span>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="hirsutism" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-[#8F55EB]/20 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#8F55EB]"></div>
                        </div>
                    </label>

                    <!-- Kenaikan berat badan drastis -->
                    <label class="flex items-center justify-between p-4 bg-white border border-gray-150 rounded-2xl cursor-pointer select-none transition-colors hover:bg-gray-50">
                        <div>
                            <span class="block text-sm font-bold text-gray-800 leading-tight">Kenaikan berat badan drastis</span>
                            <span class="text-xs text-gray-400 font-medium">Tanpa perubahan pola makan</span>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="weight_gain" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-[#8F55EB]/20 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#8F55EB]"></div>
                        </div>
                    </label>

                    <!-- Jerawat berlebihan -->
                    <label class="flex items-center justify-between p-4 bg-white border border-gray-150 rounded-2xl cursor-pointer select-none transition-colors hover:bg-gray-50">
                        <div>
                            <span class="block text-sm font-bold text-gray-800 leading-tight">Jerawat berlebihan</span>
                            <span class="text-xs text-gray-400 font-medium">Sulit dikontrol</span>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="severe_acne" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-[#8F55EB]/20 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#8F55EB]"></div>
                        </div>
                    </label>

                    <!-- Rambut rontok berlebihan -->
                    <label class="flex items-center justify-between p-4 bg-white border border-gray-150 rounded-2xl cursor-pointer select-none transition-colors hover:bg-gray-50">
                        <div>
                            <span class="block text-sm font-bold text-gray-800 leading-tight">Rambut rontok berlebihan</span>
                            <span class="text-xs text-gray-400 font-medium">Penipisan rambut</span>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="hair_loss" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-[#8F55EB]/20 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#8F55EB]"></div>
                        </div>
                    </label>

                    <!-- Kulit menghitam pada leher/ketiak -->
                    <label class="flex items-center justify-between p-4 bg-white border border-gray-150 rounded-2xl cursor-pointer select-none transition-colors hover:bg-gray-50 md:col-span-1">
                        <div>
                            <span class="block text-sm font-bold text-gray-800 leading-tight">Kulit menghitam pada leher/ketiak</span>
                            <span class="text-xs text-gray-400 font-medium">Acanthosis nigricans</span>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="dark_skin" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-[#8F55EB]/20 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#8F55EB]"></div>
                        </div>
                    </label>
                </div>

                <!-- Footer Navigation -->
                <div class="mt-8 flex justify-between items-center border-t border-gray-100 pt-6">
                    <button @click="prevStep()" 
                            class="bg-white border border-gray-200 hover:border-gray-300 text-gray-700 font-bold py-3.5 px-6 rounded-xl transition duration-150 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Kembali
                    </button>
                    <button @click="submitAnalysis()" 
                            class="bg-[#8F55EB] hover:bg-[#7c44db] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-purple-200/50 hover:shadow-xl transition duration-150 flex items-center gap-2 text-sm">
                        Lihat Hasil
                        <!-- Sparkles/Stars Icon -->
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 21l-.813-5.096L3 15l5.096-.813L9 9l.813 5.096L15 15l-5.187.904ZM18 7.5 16.5 12 15 7.5 10.5 6 15 4.5 16.5 0 18 4.5 22.5 6 18 7.5Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- SIMULATED ANALYSIS / LOADING SCREEN -->
            <div class="bg-white border border-gray-100 rounded-3xl p-12 text-center shadow-xl shadow-gray-200/40 flex flex-col items-center justify-center min-h-[350px] max-w-3xl mx-auto" 
                 x-show="submitting" x-cloak>
                <div class="relative flex items-center justify-center w-24 h-24 mb-8">
                    <!-- Spinning Outer Ring -->
                    <div class="absolute inset-0 rounded-full border-4 border-purple-100 border-t-[#8F55EB] animate-spin"></div>
                    <!-- Neural Icon Core -->
                    <span class="text-[#8F55EB] relative animate-pulse">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <circle cx="6" cy="12" r="2" fill="currentColor" />
                            <circle cx="18" cy="6" r="2" fill="currentColor" />
                            <circle cx="18" cy="18" r="2" fill="currentColor" />
                            <line x1="8" y1="11" x2="16" y2="7" stroke="currentColor" />
                            <line x1="8" y1="13" x2="16" y2="17" stroke="currentColor" />
                        </svg>
                    </span>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Mengevaluasi Gejala Anda...</h3>
                <p class="text-sm font-semibold text-gray-400 max-w-sm leading-relaxed">Jaringan Saraf Tiruan sedang menghitung estimasi bobot probabilitas risiko sindrom ovarium polikistik.</p>
            </div>

            <!-- STEP 4: DIAGNOSTIC RESULTS REPORT -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 shadow-xl shadow-gray-200/40 max-w-3xl mx-auto" 
                 x-show="step === 4 && !submitting" x-cloak>
                
                <!-- Report Header Badge -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-gray-100 pb-6 mb-6">
                    <div class="flex items-center gap-3">
                        <span class="bg-purple-50 text-[#8F55EB] p-2.5 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-900 leading-tight">Laporan Risiko PCOS</h2>
                            <p class="text-xs text-gray-400 font-semibold">Dihasilkan oleh kecerdasan buatan pada {{ date('d F Y') }}</p>
                        </div>
                    </div>
                    <!-- Risk Level indicator badge -->
                    <div class="px-4 py-2 rounded-2xl border font-extrabold text-sm text-center tracking-wide" :class="risk_color">
                        Risiko <span x-text="risk_level"></span> (<span x-text="risk_score + '%'"></span>)
                    </div>
                </div>

                <!-- Main Analysis Contents -->
                <div class="space-y-6">
                    
                    <!-- Progress Bar score gauge -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5 px-0.5 text-xs font-bold text-gray-400 uppercase tracking-wide">
                            <span>Bobot Risiko Terhitung</span>
                            <span class="text-gray-800" x-text="risk_score + '%'"></span>
                        </div>
                        <div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-700"
                                 :class="risk_score < 35 ? 'bg-green-500' : (risk_score < 70 ? 'bg-amber-500' : 'bg-red-500')"
                                 :style="'width: ' + risk_score + '%'"></div>
                        </div>
                    </div>

                    <!-- Clinical Warnings / Alert Banner -->
                    <div class="p-5 rounded-2xl border flex items-start gap-3.5"
                         :class="risk_score < 35 ? 'bg-green-50/30 border-green-100/70 text-green-800' : (risk_score < 70 ? 'bg-amber-50/30 border-amber-100/70 text-amber-800' : 'bg-red-50/30 border-red-100/70 text-red-800')">
                        <span class="mt-0.5">
                            <!-- Shield Alert/Check Icon -->
                            <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>
                        </span>
                        <div class="text-sm">
                            <h4 class="font-extrabold mb-1">Catatan Sistem</h4>
                            <p class="font-medium opacity-90 leading-relaxed" x-show="risk_score < 35">
                                Gejala yang Anda alami tergolong rendah. Tetap jaga pola hidup sehat dengan berolahraga teratur dan konsumsi makanan bernutrisi seimbang.
                            </p>
                            <p class="font-medium opacity-90 leading-relaxed" x-show="risk_score >= 35 && risk_score < 70">
                                Anda memiliki indikasi risiko PCOS tingkat sedang. Sangat disarankan untuk memantau siklus menstruasi secara konsisten dan membatasi konsumsi makanan berkarbohidrat tinggi.
                            </p>
                            <p class="font-medium opacity-90 leading-relaxed" x-show="risk_score >= 70">
                                Ditemukan kecocokan tinggi antara gejala Anda dengan karakteristik klinis penderita PCOS. Kami merekomendasikan Anda untuk berkonsultasi dengan Dokter Spesialis Kebidanan dan Kandungan (Sp.OG) untuk melakukan pemeriksaan USG panggul.
                            </p>
                        </div>
                    </div>

                    <!-- Medical Advice Suggestions Box -->
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">
                        <h4 class="text-sm font-bold text-gray-800 mb-3.5 uppercase tracking-wide">Rekomendasi Tindak Lanjut</h4>
                        <ul class="space-y-3 text-sm text-gray-600 font-semibold">
                            <li class="flex gap-2.5">
                                <span class="text-[#8F55EB] mt-0.5">•</span>
                                <span class="leading-relaxed">Lakukan olahraga kardio intensitas sedang (misal jalan cepat) selama 150 menit per minggu.</span>
                            </li>
                            <li class="flex gap-2.5">
                                <span class="text-[#8F55EB] mt-0.5">•</span>
                                <span class="leading-relaxed">Kurangi konsumsi gula pasir, tepung-tepungan, dan beralihlah ke karbohidrat kompleks (beras merah/gandum).</span>
                            </li>
                            <li class="flex gap-2.5">
                                <span class="text-[#8F55EB] mt-0.5">•</span>
                                <span class="leading-relaxed">Lakukan konsultasi medis jika siklus haid tidak terjadi selama lebih dari 3 bulan berturut-turut.</span>
                            </li>
                        </ul>
                    </div>

                </div>

                <!-- Back to dashboard Actions -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:justify-between items-center gap-3">
                    <button @click="step = 1; cycle_length = 28; period_duration = 5; cycle_irregularity = false; severe_pain = false; hirsutism = false; weight_gain = false; severe_acne = false; hair_loss = false; dark_skin = false;"
                            class="w-full sm:w-auto bg-gray-150 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-6 rounded-xl transition duration-150 text-sm text-center">
                        Ulangi Pemeriksaan
                    </button>
                    <a href="{{ route('dashboard') }}" 
                       class="w-full sm:w-auto bg-[#8F55EB] hover:bg-[#7c44db] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-purple-200/50 hover:shadow-xl transition duration-150 text-sm text-center">
                        Kembali ke Dashboard
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
