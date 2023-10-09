@extends('layouts.dashboard')
@section('content')

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date and Time</th>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->appointment_datetime }}</td>
                <td>{{ $appointment->doctor->user->name }}</td>
                <td>{{ $appointment->patient->user->name }}</td>
                <td>
                    @if ($appointment->status == 'scheduled')
                        <span class="text-warning"><i class="fas fa-clock"></i> Scheduled</span>
                    @elseif ($appointment->status == 'completed')
                        <span class="text-success"><i class="fas fa-check"></i> Completed</span>
                    @elseif ($appointment->status == 'canceled')
                        <span class="text-danger"><i class="fas fa-times"></i> Canceled</span>
                    @elseif ($appointment->status == 'approved')
                        <span class="text-success"><i class="fas fa-check"></i> Approved</span>
                    @endif
                </td>
                <td class="btn-group">
                    <!-- Buttons based on user role -->
                    @if (Auth::user()->hasRole(['admin']))
                        <!-- Admin buttons -->
                        <form method="post" action="{{ route('deleteAppointment', ['id' => $appointment->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</button>
                        </form>
                    @elseif (Auth::user()->hasRole(['doctor']))
                        <!-- Doctor buttons -->
                            <form method="post" action="{{ route('appointments.cancel', ['id' => $appointment->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cancel</button>
                            </form>
                            <form method="post" action="{{ route('appointments.approve', ['id' => $appointment->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                        <a href="{{ route('prescribe-form', ['id' => $appointment->id]) }}" class="btn btn-primary">Prescribe</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No appointments found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script>
    // Add JavaScript to toggle button visibility
    document.querySelectorAll('[id^="cancelBtn"]').forEach(cancelBtn => {
        const appointmentId = cancelBtn.id.replace('cancelBtn', '');
        const approveBtn = document.getElementById(`approveBtn${appointmentId}`);

        cancelBtn.addEventListener('click', () => {
            cancelBtn.style.display = 'none';
            if (approveBtn) {
                approveBtn.style.display = 'none';
            }
        });

        if (approveBtn) {
            approveBtn.addEventListener('click', () => {
                approveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            });
        }
    });
</script>
@endsection
