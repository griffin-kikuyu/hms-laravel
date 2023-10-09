@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1>Doctor Information</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Speciality</th>
                <th>Fee</th>
                {{-- Add more columns if needed --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->id }}</td>
                    <td>{{ $doctor->user->name }}</td>
                    <td>{{ $doctor->user->email }}</td>
                    <td>{{ $doctor->phone_number }}</td>
                    <td>{{ $doctor->speciality->name }}</td>
                    <td>{{ $doctor->fee }}</td>
                    <td>
                        <a href="{{ url('/edit-doctor/'.$doctor->id) }}">Edit</a>
                        <a href="{{ route('deleteDoctor', ['id' => $doctor->id]) }}">Delete</a>
                    </td>
                    {{-- Add more columns if needed --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>  
@endsection
