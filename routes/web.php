<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

Route::middleware(['admin'])->group(function () {
    // Add Doctor
    Route::get('/add-doctor', [DoctorController::class, 'addDoctorForm']);
    Route::post('/add-doctor', [DoctorController::class, 'addDoctor'])->name('addDoctor');
    // Edit Doctor Form
    Route::get('/edit-doctor/{id}', [DoctorController::class, 'editDoctorForm'])->name('editDoctorForm');
    // Update Doctor
    Route::put('/update-doctor/{id}', [DoctorController::class, 'updateDoctor'])->name('updateDoctor');
    // Delete Doctor
    Route::get('/delete-doctor/{id}', [DoctorController::class, 'deleteDoctor'])->name('deleteDoctor');
    // View All Doctors
    Route::get('/view-doctors', [DoctorController::class, 'viewDoctors'])->name('viewDoctor');
   // patients 

    // Delete Patient
    Route::delete('/delete-patient/{id}', [PatientController::class, 'deletePatient'])->name('deletePatient');
    // View All Patients
    Route::get('/view-patients', [PatientController::class, 'viewPatients'])->name('viewPatient');
    
});


Route::middleware(['auth'])->group(function () {
    // Show the form to make an appointment
    Route::get('/make-appointment', [AppointmentController::class, 'index']) ->name('appointments');
    Route::post('/appointments/make', [AppointmentController::class, 'makeAppointment'])->name('appointments.make');
    Route::get('/appointments/view', [AppointmentController::class, 'viewAppointments'])->name('appointments.view');
    Route::delete('/delete-appointment/{id}', [AppointmentController::class, 'deleteAppointments'])->name('deleteAppointment');
    Route::post('/appointments/cancel/{id}', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{id}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');

        // Process the form submission to make an appointment
//     Route::post('/make-appointment', [AppointmentController::class, 'makeAppointment'])
//     ->name('store-appointment');

//     Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments');

//    // cancell apointmets
//     Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
//     //approve apointment 
//     Route::post('/appointments/{id}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
//   //delete apointments 
//   Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('deleteAppointment');
//   Route::get('/get-doctors-by-speciality', [AppointmentController::class, 'getDoctorsBySpeciality'])
//     ->name('get-doctors-by-speciality');
//Route::delete('/delete-appointment/{id}', [AppointmentController::class, 'deleteAppointments'])->name('deleteAppointment');
//prescriptions 

// Create prescription
Route::get('/prescribe-form/{id}', [PrescriptionController::class, 'index'])->name('prescribe-form');
Route::post('/prescriptions/store', [PrescriptionController::class, 'store'])->name('prescriptions.store');
Route::get('/prescriptions', [PrescriptionController::class, 'viewPrescriptions'])->name('prescriptions.view');
Route::delete('/prescriptions/delete/{id}', [PrescriptionController::class, 'destroy'])->name('prescriptions.delete');

// Route::post('/prescriptions/create/', [PrescriptionController::class, 'create'])->name('prescription.create');
// Route::get('/prescriptions/edit/{prescription}', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
// Route::put('/prescriptions/update/{prescription}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
// Route::delete('/prescriptions/delete/{prescription}', [PrescriptionController::class, 'delete'])->name('prescriptions.delete');
// Route::get('/prescriptions/{id}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
    // AJAX endpoint to get doctors based on the selected speciality

    Route::post('/get-doctors-for-speciality', [AppointmentController::class, 'getDoctorsForSpeciality'])
        ->name('getDoctorsForSpeciality');

    // AJAX endpoint to get the fee for the selected doctor
    Route::post('/get-doctor-fee', [AppointmentController::class, 'getDoctorFee'])
        ->name('getDoctorFee');

    
});


Route::get('/profile', [ProfileController::class, 'index'])->name('profile');


