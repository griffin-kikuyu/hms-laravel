<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PatientController extends Controller
{
    public function deletePatient($id)
    {
        $patient = User::find($id);
    
        if ($patient) {
            if ($patient->hasRole('patient')) {
                DB::transaction(function () use ($patient) {
                    // Delete associated patient details
                    $patient->patient()->delete();
    
                    // Detach roles and delete the user
                    $patient->roles()->detach();
                    $patient->delete();
                });
    
                return redirect('/view-patients')->with('success', 'Patient deleted successfully');
            } else {
                return redirect('/view-patients')->with('error', 'Invalid user role');
            }
        } else {
            return redirect('/view-patients')->with('error', 'Patient not found or already deleted');
        }
    }


    public function viewPatients()
{
    // Retrieve all patients with their associated user details
    $patients = Patient::with('user')->get();

    return view('admin.view-patients', ['patients' => $patients]);
}
}
