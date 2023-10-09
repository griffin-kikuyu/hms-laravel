<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class prescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'disease', 
        'medication', 
        'dosage', 
        'instructions', 
        'appointment_id',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    
}
