<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Doctor;
//use Spatie\Permission\Traits\HasRoles;
use App\Models\Patient;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return $this->roles->pluck('name')->intersect($roles)->count() > 0;
        }
    
        return $this->roles->pluck('name')->contains($roles);
    }

    /**
     * Assign the default role of "patient" to the user.
     */
    public function assignDefaultRole()
    {
        $patientRole = Role::where('name', 'patient')->first();

        if ($patientRole) {
            $this->roles()->attach($patientRole);
        }
    }
    public function assignRole($role)
    {
        $role = Role::where('name', $role)->first();

        if ($role) {
            $this->roles()->syncWithoutDetaching([$role->id]);
        }
    }

    /**
     * Define the relationship with roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'user_id');
    }
}
