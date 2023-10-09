@extends('layouts.dashboard')
@section('content')
<form action="{{ route('addDoctor') }}" method="post">
    @csrf

    <div class="form-group">
        <label for="name">Doctor Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="speciality_id">Speciality:</label>
        <select class="form-control" id="speciality_id" name="speciality_id">
            <!-- Populate options dynamically from the database -->
            @foreach($specialities as $speciality)
                <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="phone_number">Phone Number:</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
    </div>

    <div class="form-group">
        <label for="fee">Fee:</label>
        <input type="text" class="form-control" id="fee" name="fee" required>
    </div>

    <!-- Add more fields as needed -->

    <button type="submit" class="btn btn-primary">Add Doctor</button>
</form>

@endsection