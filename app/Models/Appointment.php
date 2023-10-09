<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\prescription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_datetime',
        'status',
        'canceled_by_doctor',
    ];
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    // public function prescription()
    // {
    //     return $this->hasOne(prescription::class);
    // }
}
