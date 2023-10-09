@extends('layouts.dashboard') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container mt-5">
    <h1>Book an Appointment</h1>
    <form action="{{ route('appointments.make') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="doctor_id">Select a Doctor:</label>
            <select class="form-control" id="doctor_id" name="doctor_id">
                <option value="">Select a doctor</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="appointment_datetime">Choose Date and Time:</label>
            <input type="datetime-local" class="form-control" id="appointment_datetime" name="appointment_datetime">
        </div>
        <button type="submit" class="btn btn-primary">Book Appointment</button>
    </form>
</div>
@endsection