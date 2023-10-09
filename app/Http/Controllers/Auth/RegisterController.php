<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'age' => ['required', 'numeric'],
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'phone_number' => ['required', 'string'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $patientRole = Role::where('name', 'patient')->first();
        $user->roles()->attach($patientRole);

        $patient = new Patient([
            'age' => $data['age'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
        ]);

        $user->patient()->save($patient);

        return $user;
    }
}