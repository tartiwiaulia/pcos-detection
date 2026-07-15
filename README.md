# PCOS Check — Deteksi Risiko PCOS Berbasis AI

Aplikasi web untuk membantu skrining dini risiko **PCOS (Polycystic Ovary Syndrome)** menggunakan model Jaringan Saraf Tiruan (JST/MLP), dilengkapi asisten chatbot AI (Gemini) untuk edukasi kesehatan reproduksi wanita.

> ⚠️ **Disclaimer**: Hasil aplikasi ini adalah estimasi risiko berdasarkan model machine learning (akurasi ±86%), **bukan diagnosis medis**. Selalu konsultasikan ke dokter Spesialis Kebidanan dan Kandungan (Sp.OG) untuk kepastian diagnosis.

📄 Untuk latar belakang masalah, rumusan masalah, tujuan, diagram arsitektur, alur pengguna, dan ERD, lihat **[docs/SYSTEM_OVERVIEW.md](docs/SYSTEM_OVERVIEW.md)**.

## Arsitektur

Aplikasi ini terdiri dari **dua layanan terpisah** yang berjalan bersamaan:

```
Browser → Laravel (PHP, port 8000) → FastAPI (Python, port 8001) → Model ML (.pkl)
                ↓
         MySQL (data user & riwayat pemeriksaan)
                ↓
         Gemini API (chatbot edukasi PCOS)
```

- **Laravel 13** — autentikasi, form pemeriksaan, dashboard, riwayat, dan proxy aman ke FastAPI (API key & alamat FastAPI tidak pernah terekspos ke browser).
- **FastAPI (Python)** — hanya bertugas memuat model `.pkl` dan menjalankan prediksi lewat endpoint `/predict`.
- **Alpine.js + Tailwind CSS** — interaktivitas form multi-step dan widget chatbot, tanpa build framework JS berat.
- **Gemini API** — chatbot "Asisten PCOS" yang dibatasi hanya menjawab topik PCOS & kesehatan reproduksi wanita, dengan konteks hasil pemeriksaan user diambil aman dari server (bukan dari input klien).

## Tentang Model AI

- **Algoritma**: `MLPClassifier` (scikit-learn) — Jaringan Saraf Tiruan dengan arsitektur `(128, 64, 32)`.
- **Dataset**: 541 data klinis (`PCOS_data_without_infertility.xlsx`).
- **10 fitur** yang dipakai (semua bisa dijawab user tanpa tes lab):

  | Fitur | Sumber di form |
  |---|---|
  | BMI | dihitung dari berat & tinggi badan |
  | Usia | slider umur |
  | Siklus haid tidak teratur | toggle |
  | Kenaikan berat badan drastis | toggle |
  | Pertumbuhan rambut berlebih | toggle |
  | Jerawat berlebihan | toggle |
  | Rambut rontok berlebihan | toggle |
  | Kulit menghitam (leher/ketiak) | toggle |
  | Sering makan cepat saji | toggle |
  | Rutin berolahraga | toggle |

- **Penanganan data tidak seimbang**: SMOTE (oversampling) diterapkan hanya ke data training, bukan data test.
- **Tuning**: `GridSearchCV` untuk mencari kombinasi hyperparameter terbaik.
- **Akurasi**: **86.24%** pada data uji yang belum pernah dilihat model (held-out test set, 20% dari total data).
- Notebook training lengkap: [`pcos_model_training.ipynb`](pcos_model_training.ipynb) (Google Colab).

Setiap kali model dilatih ulang, pastikan urutan & jumlah fitur di `ai/app.py` (`PemeriksaanInput` dan `features = np.array([[...]])`) tetap sinkron dengan `scaler.feature_names_in_` dari notebook.

## Prasyarat

- PHP ^8.3 + Composer
- Node.js + npm
- Python 3.13 + pip
- MySQL (atau server lain yang didukung Laravel)

## Instalasi

```bash
# 1. Install dependency PHP & JS
composer install
npm install

# 2. Copy environment file lalu isi konfigurasinya
cp .env.example .env
php artisan key:generate
```

Isi `.env` (lihat [Konfigurasi](#konfigurasi-env) di bawah), lalu:

```bash
# 3. Buat database & jalankan migrasi
php artisan migrate

# 4. Setup environment Python untuk FastAPI
cd ai
python -m venv venv
venv\Scripts\pip install -r requirements.txt   # Windows
# source venv/bin/activate && pip install -r requirements.txt   # macOS/Linux
cd ..
```

## Konfigurasi `.env`

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pcos_detection
DB_USERNAME=root
DB_PASSWORD=

# Alamat FastAPI (port beda dari php artisan serve supaya tidak bentrok)
FASTAPI_URL=http://127.0.0.1:8001

# Gemini API untuk chatbot — lihat cara dapatnya di bawah
GEMINI_API_KEY=
GEMINI_MODEL=gemini-flash-latest
```

### Cara mendapatkan Gemini API key (gratis)

1. Buka https://aistudio.google.com/apikey
2. Login dengan akun Google, klik **Create API key**
3. Pilih project **"Default Gemini Project"** (tidak perlu bikin project baru)
4. Copy key yang muncul, tempel ke `GEMINI_API_KEY` di `.env`

## Menjalankan aplikasi

Semua servis (Laravel, queue listener, Vite, dan FastAPI) bisa dijalankan sekaligus dengan satu perintah:

```bash
composer run dev
```

Ini akan menyalakan:
| Servis | Port | Keterangan |
|---|---|---|
| Laravel | 8000 | `php artisan serve` |
| Vite | 5173 | hot-reload CSS/JS |
| FastAPI | 8001 | model AI prediksi |
| Queue listener | — | `php artisan queue:listen` |

Lalu buka **http://127.0.0.1:8000**.

### Menjalankan manual (tanpa `composer run dev`)

```bash
php artisan serve
npm run dev
cd ai && venv\Scripts\uvicorn.exe app:app --host 127.0.0.1 --port 8001   # Windows
# cd ai && venv/bin/uvicorn app:app --host 127.0.0.1 --port 8001         # macOS/Linux
```

## Catatan khusus Windows

- **`php artisan pail` tidak didukung di Windows** (butuh ekstensi `pcntl` yang cuma ada di Unix) — sudah dikeluarkan dari script `composer run dev`. Untuk melihat log, buka `storage/logs/laravel.log` langsung.
- **Sertifikat SSL PHP** — kalau `Http::post()` ke API eksternal (Gemini, dll) gagal dengan error `cURL error 60: SSL certificate ... unable to get local issuer certificate`, PHP di Windows butuh CA bundle manual:
  1. Download https://curl.se/ca/cacert.pem
  2. Di `php.ini`, set:
     ```ini
     curl.cainfo = "C:\path\ke\cacert.pem"
     openssl.cafile = "C:\path\ke\cacert.pem"
     ```
- **Path executable venv** harus pakai backslash (`ai\venv\Scripts\uvicorn.exe`), bukan forward-slash, kalau dijalankan lewat `cmd.exe`/`concurrently`.

## Struktur proyek (ringkas)

```
ai/                         Layanan FastAPI (prediksi model AI)
  app.py                    Endpoint /predict dan /health
  pcos_model.pkl            Model MLPClassifier terlatih
  pcos_scaler.pkl           StandardScaler yang dipakai saat training
  requirements.txt

app/Http/Controllers/
  PredictionController.php  Proxy form pemeriksaan → FastAPI, simpan hasil
  ChatbotController.php     Proxy chat → Gemini API (dengan konteks hasil user)

resources/views/
  pemeriksaan.blade.php     Form pemeriksaan multi-step + hasil + chatbot
  dashboard.blade.php       Grafik tren risiko & riwayat terbaru
  riwayat.blade.php         Semua riwayat pemeriksaan
  components/pcos-chatbot.blade.php   Widget chatbot (mode floating & inline)

pcos_model_training.ipynb   Notebook training model (Google Colab)
```

## Fitur utama

- Autentikasi (register, login, logout) — Laravel Breeze
- Form pemeriksaan multi-step dengan prediksi risiko real-time dari model AI
- Dashboard dengan grafik tren risiko dari riwayat pemeriksaan asli
- Riwayat pemeriksaan lengkap
- Asisten chatbot AI (Gemini) yang memahami konteks hasil pemeriksaan user, dibatasi hanya topik PCOS & kesehatan reproduksi
- Halaman edukasi PCOS
