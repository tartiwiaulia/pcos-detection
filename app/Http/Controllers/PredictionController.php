<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
   public function store(Request $request)
{
    $validated = $request->validate([
        'age'                 => 'required|integer',
        'weight'              => 'required|numeric',
        'height'              => 'required|numeric',
        'systolic'            => 'required|numeric',
        'diastolic'           => 'required|numeric',
        'cycle_length'        => 'required|integer',
        'period_duration'     => 'required|integer',
        'cycle_irregularity'  => 'required|boolean',
        'severe_pain'         => 'required|boolean',
        'hirsutism'           => 'required|boolean',
        'weight_gain'         => 'required|boolean',
        'severe_acne'         => 'required|boolean',
        'hair_loss'           => 'required|boolean',
        'dark_skin'           => 'required|boolean',
    ]);

    // Hanya 7 field ini yang dipakai model (sesuai PemeriksaanInput di FastAPI)
    $fastApiPayload = [
        'weight'             => $validated['weight'],
        'height'             => $validated['height'],
        'cycle_irregularity' => $validated['cycle_irregularity'],
        'weight_gain'        => $validated['weight_gain'],
        'hirsutism'          => $validated['hirsutism'],
        'severe_acne'        => $validated['severe_acne'],
        'hair_loss'          => $validated['hair_loss'],
        'dark_skin'          => $validated['dark_skin'],
    ];

    $response = Http::post(env('FASTAPI_URL', 'http://127.0.0.1:8000') . '/predict', $fastApiPayload);

    if ($response->failed()) {
        return response()->json(['error' => 'Gagal terhubung ke server AI.'], 502);
    }

    $result = $response->json();

    $prediction = Prediction::create([
        'user_id'       => Auth::id(),
        'symptoms_data' => $validated, // simpan semua 14 field buat riwayat/detail
        'result_status' => $result['risk_level'],
        'probability'   => $result['risk_score'],
    ]);

    return response()->json([
        'id'         => $prediction->id,
        'risk_score' => $result['risk_score'],
        'risk_level' => $result['risk_level'],
    ]);
}

public function history()
{
    $predictions = Prediction::where('user_id', Auth::id())->latest()->get();
    return view('riwayat', compact('predictions'));
}

}
