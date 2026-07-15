<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    private const SYMPTOM_LABELS = [
        'cycle_irregularity' => 'Siklus haid tidak teratur',
        'weight_gain' => 'Kenaikan berat badan drastis',
        'hirsutism' => 'Pertumbuhan rambut berlebih',
        'severe_acne' => 'Jerawat berlebihan',
        'hair_loss' => 'Rambut rontok berlebihan',
        'dark_skin' => 'Kulit menghitam pada leher/ketiak',
        'fast_food' => 'Sering konsumsi makanan cepat saji',
        'reg_exercise' => 'Rutin berolahraga',
    ];

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array',
            'history.*.role' => 'required_with:history|string|in:user,model',
            'history.*.text' => 'required_with:history|string',
            'prediction_id' => 'nullable|integer',
        ]);

        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model');

        if (! $apiKey) {
            return response()->json(['error' => 'GEMINI_API_KEY belum diatur di .env.'], 500);
        }

        $contextBlock = $this->buildContextBlock($validated['prediction_id'] ?? null);

        $systemPrompt = <<<PROMPT
        Kamu adalah "Asisten PCOS", chatbot edukasi kesehatan di dalam aplikasi deteksi risiko PCOS (Polycystic Ovary Syndrome).

        ATURAN KETAT:
        1. Hanya jawab pertanyaan seputar PCOS dan kesehatan reproduksi wanita (siklus haid, hormon, kesuburan, pola makan/olahraga terkait PCOS, dan gejala terkait).
        2. Jika pengguna bertanya di luar topik tersebut, tolak dengan sopan dan arahkan kembali ke topik PCOS.
        3. Jangan pernah memberikan diagnosis medis pasti. Selalu ingatkan bahwa hasil aplikasi ini hanya estimasi risiko, bukan diagnosis, dan sarankan konsultasi ke dokter Sp.OG untuk kepastian.
        4. Jawab singkat, jelas, suportif, dan gunakan Bahasa Indonesia yang mudah dipahami.
        5. Kamu boleh memakai konteks hasil pemeriksaan pengguna di bawah ini untuk menyesuaikan jawaban.
        {$contextBlock}
        PROMPT;

        $contents = collect($validated['history'] ?? [])
            ->map(fn ($m) => ['role' => $m['role'], 'parts' => [['text' => $m['text']]]])
            ->push(['role' => 'user', 'parts' => [['text' => $validated['message']]]])
            ->values()
            ->all();

        $response = Http::timeout(30)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
            [
                'systemInstruction' => ['parts' => [['text' => $systemPrompt]]],
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => 0.4,
                    'maxOutputTokens' => 800,
                    'thinkingConfig' => ['thinkingBudget' => 0],
                ],
            ]
        );

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal terhubung ke Gemini API.'], 502);
        }

        $reply = data_get($response->json(), 'candidates.0.content.parts.0.text');

        if (! $reply) {
            return response()->json(['error' => 'Gemini tidak memberikan jawaban.'], 502);
        }

        return response()->json(['reply' => trim($reply)]);
    }

    private function buildContextBlock(?int $predictionId): string
    {
        if (! $predictionId) {
            return '';
        }

        $prediction = Prediction::where('user_id', Auth::id())->find($predictionId);

        if (! $prediction) {
            return '';
        }

        $symptoms = collect($prediction->symptoms_data ?? [])
            ->filter(fn ($value, $key) => array_key_exists($key, self::SYMPTOM_LABELS) && $value)
            ->keys()
            ->map(fn ($key) => self::SYMPTOM_LABELS[$key])
            ->implode(', ');

        $lines = [
            "Level risiko PCOS pengguna: {$prediction->result_status}",
            "Skor risiko: {$prediction->probability}%",
            'Gejala & faktor gaya hidup yang terdeteksi: '.($symptoms !== '' ? $symptoms : 'tidak ada gejala spesifik yang terdeteksi'),
        ];

        if (isset($prediction->symptoms_data['age'])) {
            $lines[] = "Usia pengguna: {$prediction->symptoms_data['age']} tahun";
        }

        return "\n\nKonteks hasil pemeriksaan pengguna saat ini:\n- ".implode("\n- ", $lines);
    }
}
