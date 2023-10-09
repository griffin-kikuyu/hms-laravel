@extends('admin.dashboard')
@section('content')
<div class="container">
    <h2>Appointments</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->doctor->user->name }}</td>
                    <td>{{ $appointment->patient->user->name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->appointment_time }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>{{ $appointment->notes ?? 'N/A' }}</td>
                    <td>
                        <!-- Add buttons or links for actions (e.g., cancel, reschedule) -->
                        <a href="{{ route('cancelAppointment', ['id' => $appointment->id]) }}">Cancel</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection