<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        return view('admin.doctor-prescribe', compact('appointment'));

    }
    

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'disease' => 'required|string',
            'medication' => 'required|string',
            'dosage' => 'required|string',
            'instructions' => 'required|string',
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        // Create and store the prescription
        prescription::create($validatedData);

        // Redirect or do something else based on success or failure
        // For example, redirect back to the appointments view
        return redirect()->route('prescriptions.view');
    }

    public function viewPrescriptions()
    {
        $user = auth()->user();
        $prescriptions = [];
    
        if ($user->hasRole('admin')) {
            // Admin can see all prescriptions
            $prescriptions = Prescription::with('appointment.doctor.user', 'appointment.patient.user')->get();
        } elseif ($user->hasRole('patient')) {
            // Patient can see prescriptions made for them
            $prescriptions = Prescription::whereHas('appointment', function ($query) use ($user) {
                $query->where('patient_id', $user->patient->id);
            })->with('appointment.doctor.user', 'appointment.patient.user')->get();
        } elseif ($user->hasRole('doctor')) {
            // Doctor can see prescriptions they have made
            $prescriptions = Prescription::whereHas('appointment', function ($query) use ($user) {
                $query->where('doctor_id', $user->doctor->id);
            })->with('appointment.doctor.user', 'appointment.patient.user')->get();
        }
    
        return view('admin.view-prescriptions', compact('prescriptions'));
    }

       public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);

        // Check if the prescription can be deleted (e.g., business logic validation)

        // Delete the prescription
        $prescription->delete();

        // Redirect back to the prescriptions view with a success message
        return redirect()->route('prescriptions.view')->with('success', 'Prescription deleted successfully.');
    }
    // public function create($id)
    // {
    //     $appointment = Appointment::find($id);
    //     $appointment = Appointment::findOrFail($appointmentId);

    // // Fetch the doctor's name, patient's name, and appointment time
    // $doctorName = $appointment->doctor->user->name;
    // $patientName = $appointment->patient->user->name;
    // $appointmentTime = $appointment->appointment_datetime;

    // return view('prescriptions.create', compact('appointment', 'doctorName', 'patientName', 'appointmentTime'));
    // }

    // public function createPrescription($appointmentId)
    // {
    //     // Retrieve the appointment details, including doctor and patient information
    //     $appointment = Appointment::findOrFail($appointmentId);

    //     // Pass the appointment data to the prescription form view
    //     return view('prescription.create', ['appointment' => $appointment]);
    // }
    // public function store(Request $request)
    // {
    //     // Validate the incoming prescription data
    //     $validatedData = $request->validate([
    //         'disease' => 'required|string',
    //         'medication' => 'required|string',
    //         'dosage' => 'required|string',
    //         'instructions' => 'required|string',
    //     ]);
    
    //     // Retrieve the appointment associated with this prescription
    //     $appointment = Appointment::findOrFail($request->input('appointment_id'));
    
    //     // Create a new prescription record
    //     $prescription = new Prescription([
    //         'disease' => $validatedData['disease'],
    //         'medication' => $validatedData['medication'],
    //         'dosage' => $validatedData['dosage'],
    //         'instructions' => $validatedData['instructions'],
    //         'doctor_id' => $appointment->doctor_id, // Automatically set the doctor_id
    //         'patient_id' => $appointment->patient_id, // Automatically set the patient_id
    //         'appointment_id' => $request->input('appointment_id'),
    //     ]);
    
    //     // Save the prescription record
    //     $prescription->save();
    
    //     // Redirect to a success page or perform other actions as needed
    //     return redirect()->route('prescriptions.index')->with('success', 'Prescription created successfully');
    // }
}
