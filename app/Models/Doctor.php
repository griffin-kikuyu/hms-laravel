<?php

namespace App\Models;

use App\Models\User;
use App\Models\Speciality;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = ['phone_number', 'fee', 'speciality_id' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
