@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Prescription</h1>
    <p><strong>Appointment Details:</strong></p>
    <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
    <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
    <p><strong>Appointment Time:</strong> {{ $appointment->appointment_datetime }}</p>

    <form action="{{ route('prescriptions.store') }}" method="POST">
        @csrf
        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

        <div class="form-group">
            <label for="disease">Disease:</label>
            <input type="text" class="form-control" id="disease" name="disease" required>
        </div>

        <div class="form-group">
            <label for="medication">Medication:</label>
            <input type="text" class="form-control" id="medication" name="medication" required>
        </div>

        <div class="form-group">
            <label for="dosage">Dosage:</label>
            <input type="text" class="form-control" id="dosage" name="dosage" required>
        </div>

        <div class="form-group">
            <label for="instructions">Instructions:</label>
            <textarea class="form-control" id="instructions" name="instructions" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Prescription</button>
    </form>
</div>
@endsection
