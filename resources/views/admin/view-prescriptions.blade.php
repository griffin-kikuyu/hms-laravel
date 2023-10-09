@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Prescriptions</h1>

    @if($prescriptions->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Disease</th>
                    <th>Medication</th>
                    <th>Dosage</th>
                    <th>Instructions</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription->appointment->doctor->user->name }}</td>
                    <td>{{ $prescription->appointment->patient->user->name }}</td>
                    <td>{{ $prescription->disease }}</td>
                    <td>{{ $prescription->medication }}</td>
                    <td>{{ $prescription->dosage }}</td>
                    <td>{{ $prescription->instructions }}</td>
                    <td>{{ $prescription->created_at }}</td>
                    <td> <!-- Actions column -->
                        <div class="btn-group">
                            @if (Auth::user()->hasRole('admin'))
                                <form method="post" action="{{ route('prescriptions.delete', ['id' => $prescription->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @elseif (Auth::user()->hasRole('patient'))
                                <form method="post" action="{ route('prescriptions.pay-bill', ['id' => $prescription->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Pay Bill</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No prescriptions found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @else
        <p>No prescriptions found.</p>
    @endif
</div>
@endsection
