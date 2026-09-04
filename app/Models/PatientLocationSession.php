<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PatientLocationSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_token',
        'ip_address',
        'user_agent',
        'start_latitude',
        'start_longitude',
        'current_latitude',
        'current_longitude',
        'movement_status',
        'current_speed',
        'total_distance_meters',
        'started_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'current_speed' => 'float',
        'total_distance_meters' => 'float',
    ];

    public function logs()
    {
        return $this->hasMany(PatientLocationLog::class, 'session_id')->orderBy('recorded_at', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('expires_at', '>', Carbon::now());
    }

    public function getRemainingSecondsAttribute()
    {
        if (!$this->expires_at) return 0;
        $diff = Carbon::now()->diffInSeconds($this->expires_at, false);
        return max(0, $diff);
    }
}
