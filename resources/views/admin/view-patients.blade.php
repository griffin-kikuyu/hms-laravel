@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h2>View Patients</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Phone Number</th>
                {{-- Add more columns if needed --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->user->id }}</td>
                    <td>{{ $patient->user->name }}</td>
                    <td>{{ $patient->user->email }}</td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->phone_number }}</td>
                    <td>
                        <form action="{{ route('deletePatient', ['id' => $patient->user->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                    {{-- Add more columns if needed --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>  
@endsection
