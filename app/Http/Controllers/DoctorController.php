<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\Specialities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    // public function editDoctorForm($id)
    // {
    //     // Retrieve the doctor and return the edit view
    //     $doctor = User::find($id);
    
    //     return view('admin.edit-doctor', ['doctor' => $doctor]);
    // }
    public function editDoctorForm($id)
    {
        // Retrieve the doctor with its associated user and speciality
        $doctor = Doctor::with('user', 'speciality')->find($id);
    
        // Fetch the list of specialities for the dropdown
        $specialities = Speciality::all();
    
        // Ensure the doctor is found
        if (!$doctor) {
            return redirect('/view-doctors')->with('error', 'Doctor not found');
        }
    
        // Pass the doctor and specialities to the view
        return view('admin.edit-doctor', compact('doctor', 'specialities'));
    }


public function addDoctorForm()
{
    // Fetch the list of specialities
    $specialities = Speciality::all();

    // Return the view for adding a doctor with specialities
    return view('admin.add-doctor', ['specialities' => $specialities]);
}

public function addDoctor(Request $request)
{
    // Validate the request
    $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'speciality_id' => 'nullable|exists:specialities,id',
        'phone_number' => 'required|string',
        'fee' => 'required|numeric',
        // Add more validation rules as needed
    ]);

    // Create a new user (assuming Doctor is associated with User)
    $user = new User([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
    ]);

    // Save the user
    $user->save();

    // Create a new doctor and associate it with the user
    $doctor = new Doctor([
        'phone_number' => $request->input('phone_number'),
        'fee' => $request->input('fee'),
        'speciality_id' => $request->input('speciality_id'), // Ensure this is set
        // Add more fields as needed
    ]);

    // Save the doctor
    $user->doctor()->save($doctor);

    // Assign the 'doctor' role to the new user
    $user->assignRole('doctor');

    return redirect('/view-doctors')->with('success', 'Doctor added successfully');
}
    
    
    // public function updateDoctor(Request $request, $id)
    // {
    //     // Validate and update the doctor
    //     $this->validate($request, [
    //         // Add validation rules here
    //     ]);
    
    //     $doctor = User::find($id);
    //     $doctor->update($request->all());
    //     $doctor = Doctor::with('user')->find($id);

    //     if (!$doctor) {
    //         return redirect('/view-doctors')->with('error', 'Doctor not found');
    //     }
    //     return redirect('/view-doctors')->with('success', 'Doctor updated successfully');
    // }
    public function updateDoctor(Request $request, $id)
    {
        // Find the doctor with its associated user
        $doctor = Doctor::with('user')->find($id);
    
        // Ensure the doctor is found
        if (!$doctor) {
            return redirect('/view-doctors')->with('error', 'Doctor not found');
        }
    
        // Validate the request with optional rules
        $this->validate($request, [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $doctor->user->id,
            'password' => 'nullable|min:6',
            'speciality' => 'nullable|exists:specialities,id',
            'fee' => 'nullable|numeric',
            // Add more optional fields as needed
        ]);
    
        // Update the user information if provided
        if ($request->filled('name') || $request->filled('email') || $request->filled('password')) {
            $doctor->user->update([
                'name' => $request->input('name') ?? $doctor->user->name,
                'email' => $request->input('email') ?? $doctor->user->email,
                'password' => $request->filled('password') ? bcrypt($request->input('password')) : $doctor->user->password,
            ]);
        }
    
        // Update the doctor information if provided
        $doctor->update([
            'phone_number' => $request->input('phone_number') ?? $doctor->phone_number,
            'fee' => $request->input('fee') ?? $doctor->fee,
            'speciality_id' => $request->input('speciality_id') ?? $doctor->speciality_id,
            // Add more fields as needed
        ]);
    
        return redirect('/view-doctors')->with('success', 'Doctor updated successfully');
    }
    

    public function deleteDoctor($id)
    {
        // Find the doctor
        $doctor = Doctor::find($id);
    
        if ($doctor) {
            $userId = $doctor->user->id;
    
            // Use a database transaction for atomicity
            DB::transaction(function () use ($doctor, $userId) {
                // Delete the doctor
                $doctor->delete();
    
                // Delete the associated user
                User::find($userId)->delete();
            });
    
            return redirect('/view-doctors')->with('success', 'Doctor deleted successfully');
        } else {
            return redirect('/view-doctors')->with('error', 'Doctor not found or already deleted');
        }
    }

    public function viewDoctors()
    {
        // Fetch all doctors with their associated user and speciality information
        $doctors = Doctor::with('user', 'speciality')->get();

        // You can customize this data as needed for your view
        $data = [
            'doctors' => $doctors,
        ];

        // Return the view with the data
        return view('admin.view-doctors', $data);
    }
    

}
