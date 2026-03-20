<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'business_name',
        'contact',
        'email',
        'address',
        'status'
    ];
}
