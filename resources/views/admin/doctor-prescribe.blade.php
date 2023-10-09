@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Create Prescription</h2>
    <form method="post" action="{{ route('prescriptions.store') }}">
        @csrf

        <!-- Hidden field to store the appointment ID -->
        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

        <!-- Display the doctor and patient names -->
        <div class="form-group">
            <label for="doctor">Doctor</label>
            <input type="text" class="form-control" id="doctor" value="{{ $appointment->doctor->user->name }}" disabled>
        </div>
        <div class="form-group">
            <label for="patient">Patient</label>
            <input type="text" class="form-control" id="patient" value="{{ $appointment->patient->user->name }}" disabled>
        </div>

        <!-- Prescription fields -->
        <div class="form-group">
            <label for="disease">Disease</label>
            <input type="text" class="form-control" id="disease" name="disease" required>
        </div>
        <div class="form-group">
            <label for="medication">Medication</label>
            <input type="text" class="form-control" id="medication" name="medication" required>
        </div>
        <div class="form-group">
            <label for="dosage">Dosage</label>
            <input type="text" class="form-control" id="dosage" name="dosage" required>
        </div>
        <div class="form-group">
            <label for="instructions">Instructions</label>
            <textarea class="form-control" id="instructions" name="instructions" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Prescribe Medication</button>
    </form>
</div>
@endsection
