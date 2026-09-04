<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientLocationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'latitude',
        'longitude',
        'speed',
        'movement_status',
        'accuracy',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'accuracy' => 'float',
    ];

    public function session()
    {
        return $this->belongsTo(PatientLocationSession::class, 'session_id');
    }
}
