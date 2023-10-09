<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Speciality;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    //return view make appointments
    public function index()
    {
        // Fetch the list of available doctors and pass it to the view
        $doctors = Doctor::all();

        return view('admin.appointments-make', compact('doctors'));
    }
   // creating appointments
   public function makeAppointment(Request $request)
   {
       // Validate the form data
       $validator = Validator::make($request->all(), [
           'doctor_id' => 'required|exists:doctors,id',
           'appointment_datetime' => 'required|date_format:Y-m-d\TH:i',
       ]);
   
       if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput();
       }
   
       // Create the appointment
       $appointment = new Appointment();
       $appointment->doctor_id = $request->input('doctor_id');
       $appointment->patient_id = auth()->user()->patient->id;
       $appointment->appointment_datetime = $request->input('appointment_datetime');
       $appointment->status = 'scheduled';
       $appointment->canceled_by_doctor = false;
   
       // Save the appointment to the database
       $appointment->save();
   
       // Pass an empty array of appointments to the view
       $appointments = [];
   
       // Redirect to the view appointments page
       return redirect()->route('appointments.view');   }

      
        public function viewAppointments()
        {
            $user = auth()->user();
            $appointments = [];
        
            if ($user->hasRole('admin')) {
                // Admin can see all appointments
                $appointments = Appointment::all();
            } elseif ($user->hasRole('doctor')) {
                // Doctor can see appointments assigned to them
                $appointments = $user->doctor->appointments;
            } elseif ($user->hasRole('patient') && $user->patient) {
                // Patient can see their own appointments if they have a patient record
                $appointments = $user->patient->appointments;
            }
        
            return view('admin.appointments-view', compact('appointments'));
        }
      
        
        
        
        
        
        
        
        
        
       

//     public function showMakeAppointmentForm()
// {
//     $specialities = Speciality::all();
//     $doctors = []; // Initialize doctors as an empty array

//     return view('admin.appointments-make', ['specialities' => $specialities, 'doctors' => $doctors]);
// }

// public function getDoctors(Request $request)
// {
//     $specialityId = $request->input('speciality_id');

//     // Query doctors based on the selected speciality
//     $doctors = Doctor::where('speciality_id', $specialityId)->get();

//     // Return the list of doctors as HTML options
//     $options = view('partials', ['doctors' => $doctors])->render();

//     return response()->json(['options' => $options]);
// }
//     public function getDoctorsBySpeciality(Request $request)
// {
//     $specialityId = $request->input('speciality_id');

//     // Query doctors based on the selected speciality
//     $doctors = Doctor::where('speciality_id', $specialityId)->get();

//     // Return doctors as JSON response
//     return response()->json($doctors);
// }
//     // public function showMakeAppointmentForm()
//     // {
//     //     $specialities = Speciality::all(); 
//     //     $doctors = Doctor::all();
//     //     return view('admin.appointments-make', ['specialities' => $specialities, 'doctors' => $doctors,]);
//     // }
    
//     // public function getDoctors($specialityId)
//     // {
//     //     $doctors = Doctor::where('speciality_id', $specialityId)->get();
//     //     return response()->json($doctors);
//     // }

//     //     public function getConsultationFee($doctorId)
//     //     {
//     //         $doctor = Doctor::findOrFail($doctorId);
//     //         return response()->json(['fee' => $doctor->fee]);
//     //     }

//     public function makeAppointment(Request $request)
//     {
//         // Validate the form data
//         $validatedData = $request->validate([
//             'speciality_id' => 'required|exists:specialities,id',
//             'doctor_id' => 'required|exists:doctors,id',
//             'appointment_datetime' => 'required|date_format:Y-m-d\TH:i', // Updated validation rule
//             // Add more validation rules as needed
//         ]);
        
//         // Create the appointment
//         $appointment = Appointment::create([
//             'doctor_id' => $validatedData['doctor_id'],
//             'patient_id' => auth()->user()->patient->id, // Assuming the user is a patient
//             'appointment_datetime' => $validatedData['appointment_datetime'], // Updated field name
//             'status' => 'scheduled',
//             // Add more fields as needed
//         ]);
    
//         // Redirect or do something else based on success or failure
//         return redirect()->route('makeappointment')->with('success', 'Appointment created successfully!');
//     }
//     public function index()
//     {
//         $appointments = Appointment::with(['doctor.user', 'patient.user'])->get();

//         return view('admin.appointments-show', ['appointments' => $appointments]);
//     }
    
// //     public function cancel($id)
// // {
// //     $appointment = Appointment::findOrFail($id);

// //     // Check if the appointment can be canceled (e.g., within a certain time frame)
// //     // Update the appointment as canceled by the doctor
// //     $appointment->update([
// //         'canceled_by_doctor' => true,
// //     ]);
// //     // Redirect back to the appointments page with a success message
// //     return redirect()->route('appointments')->with('success', 'Appointment canceled by the doctor.');
// // }
// public function cancel($id)
// {
//     $appointment = Appointment::findOrFail($id);

//     // Check if the appointment can be canceled (e.g., within a certain time frame)

//     // Update the appointment as canceled by the doctor
//     $appointment->update([
//         'canceled_by_doctor' => true,
//         'status' => 'canceled', // Update the status to 'canceled'
//     ]);

//     // Redirect back to the appointments page with a success message
//     return redirect()->route('appointments')->with('success', 'Appointment canceled by the doctor.');
// }
public function approve($id)
{
    $appointment = Appointment::findOrFail($id);

    // Check if the appointment can be approved (e.g., within a certain time frame)

    // Update the appointment as approved by the doctor and mark it as 'completed'
    $appointment->update([
        'status' => 'completed',
    ]);

    // Redirect back to the appointments page with a success message
    return redirect()->route('appointments.view')->with('success', 'Appointment approved and marked as completed.');
}
public function cancel($id)
{
    $appointment = Appointment::findOrFail($id);

    // Check if the appointment can be approved (e.g., within a certain time frame)

    // Update the appointment as approved by the doctor and mark it as 'completed'
    $appointment->update([
        'status' => 'canceled',
    ]);

    // Redirect back to the appointments page with a success message
    return redirect()->route('appointments.view')->with('success', 'Appointment canceled successfully.');
}
// public function cancel($id)
// {
//     $appointment = Appointment::findOrFail($id);

//     // Check if the user is authorized to cancel the appointment (only doctors can cancel)
//     if (Auth::user()->hasRole(['doctor']) && $appointment->status == 'scheduled' && !$appointment->canceled_by_doctor) {
//         $appointment->update(['status' => 'canceled', 'canceled_by_doctor' => true]);

//         return redirect()->route('appointments.view')->with('success', 'Appointment canceled successfully.');
//     }

//     return redirect()->route('appointments.view')->with('error', 'Unable to cancel appointment.');
// }
public function deleteAppointments($id)
{
    $appointment = Appointment::findOrFail($id);

    // Check if the appointment can be deleted (e.g., within a certain time frame)

    // Delete the appointment
    $appointment->delete();

    // Redirect back to the appointments page with a success message
    return redirect()->route('appointments.view')->with('success', 'Appointment deleted successfully.');
}
}