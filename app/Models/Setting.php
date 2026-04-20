<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'contact_number',
        'emergency_number',
        'non_emergency_number',
        'is_emergency_link',
        'is_call_icon',
        'is_whatsapp_icon',
        'whatsapp_number',
        'secondary_call_number'
    ];
}
