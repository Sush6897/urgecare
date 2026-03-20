<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $fillable = [
        'sid',
        'from',
        'to',
        'patient_name',
        'hospital_id',
        'status',
    ];

    public function hospital(){
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }
}
