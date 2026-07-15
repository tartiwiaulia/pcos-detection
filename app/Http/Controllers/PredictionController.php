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
        'cycle_irregularity'  => 'required|boolean',
        'hirsutism'           => 'required|boolean',
        'weight_gain'         => 'required|boolean',
        'severe_acne'         => 'required|boolean',
        'hair_loss'           => 'required|boolean',
        'dark_skin'           => 'required|boolean',
        'fast_food'           => 'required|boolean',
        'reg_exercise'        => 'required|boolean',
    ]);

    $response = Http::post(env('FASTAPI_URL', 'http://127.0.0.1:8000') . '/predict', $validated);

    if ($response->failed()) {
        return response()->json(['error' => 'Gagal terhubung ke server AI.'], 502);
    }

    $result = $response->json();

    $prediction = Prediction::create([
        'user_id'       => Auth::id(),
        'symptoms_data' => $validated,
        'result_status' => $result['risk_level'],
        'probability'   => $result['risk_score'],
    ]);

    return response()->json([
        'id'         => $prediction->id,
        'risk_score' => $result['risk_score'],
        'risk_level' => $result['risk_level'],
    ]);
}

public function dashboard()
{
    $predictions = Prediction::where('user_id', Auth::id())
        ->latest()
        ->take(5)
        ->get();

    $chartData = $predictions->sortBy('created_at')->values()->map(fn ($prediction) => [
        'label' => $prediction->created_at->format('d M'),
        'score' => (float) $prediction->probability,
    ]);

    return view('dashboard', compact('predictions', 'chartData'));
}

public function history()
{
    $predictions = Prediction::where('user_id', Auth::id())->latest()->get();
    return view('riwayat', compact('predictions'));
}

}
