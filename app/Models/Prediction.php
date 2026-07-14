<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $fillable = [
        'user_id',
        'symptoms_data',
        'result_status',
        'probability',
    ];

    protected $casts = [
        'symptoms_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
