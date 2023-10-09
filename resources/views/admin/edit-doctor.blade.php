@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h2>Edit Doctor</h2>

    <form method="post" action="{{ route('updateDoctor', ['id' => $doctor->id]) }}">
        @csrf
        @method('put')

        <!-- Doctor Information -->
        <label for="name">Doctor Name:</label>
        <input type="text" name="name" value="{{ old('name', $doctor->user->name) }}" placeholder="Enter name">

        <label for="email">Doctor Email:</label>
        <input type="email" name="email" value="{{ old('email', $doctor->user->email) }}" placeholder="Enter email">

        <!-- Additional Doctor Information -->
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="{{ old('phone_number', $doctor->phone_number) }}" placeholder="Enter phone number">

        <label for="fee">Doctor Fee:</label>
        <input type="number" name="fee" value="{{ old('fee', $doctor->fee) }}" placeholder="Enter fee">

        <!-- Speciality Dropdown -->
        <label for="speciality_id">Speciality:</label>
        <select name="speciality_id">
            <option value="" selected>Select Speciality</option>
            @foreach($speciality as $speciality)
                <option value="{{ $speciality->id }}" {{ old('speciality_id', $doctor->speciality_id) == $speciality->id ? 'selected' : '' }}>
                    {{ $speciality->name }}
                </option>
            @endforeach
        </select>

        <!-- Password Field (optional) -->
        <label for="password">New Password:</label>
        <input type="password" name="password" placeholder="Enter new password">

        <!-- Add more fields as needed -->

        <button type="submit">Update Doctor</button>
    </form>
</div>
</div>
@endsection