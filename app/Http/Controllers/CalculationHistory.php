<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'calculation_type',
        'input_data',
        'result_data',
    ];

    protected $casts = [
        'input_data' => 'array',
        'result_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
