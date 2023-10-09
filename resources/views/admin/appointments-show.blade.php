<table class="table table-bordered">
    <thead>
        <tr>
            <th>Appointment Date and Time</th>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($appointments as $appointment)
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
        </tr>
        @endforeach
    </tbody>
</table>
