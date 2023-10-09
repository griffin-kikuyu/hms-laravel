<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'role_id'];

    public function assignDefaultRole()
    {
        $patientRole = Role::where('name', 'patient')->first();

        if ($patientRole) {
            $this->roles()->attach($patientRole);
        }
    }
}
