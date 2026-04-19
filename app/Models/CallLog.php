<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallLog extends Model
{
    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_EXHAUSTED = 'exhausted';

    protected $fillable = [
        'from_number',
        'numbers',
        'current_index',
        'call_sid',
        'status',
        'last_exotel_status',
        'attempts',
        'hospital_id',
        'patient_name',
    ];

    protected $casts = [
        'numbers' => 'array',
        'attempts' => 'array',
        'current_index' => 'integer',
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }
}
