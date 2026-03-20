<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hospital extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $fillable = [
        'hospital_name',
        'email',
        'password',
        'address',
        'country',
        'state',
        'city',
        'pincode',
        'features1',
        'features2',
        'features3',
        'features4',
        'gmap',
        'area',
        'longitude',
        'latitude',
        'status',
        'emergency',
        'nonemergency'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function enquiry(){
        return $this->hasMany(Enquiry::class, 'hospital_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany(HospitalContact::class, 'hospital_id', 'id');
    }
}
