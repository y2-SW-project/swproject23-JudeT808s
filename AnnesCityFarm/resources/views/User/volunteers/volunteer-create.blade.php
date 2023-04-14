@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Volunteer</h1>
        <form method="POST" action="{{ route('user.volunteers.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control">
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" id="age" class="form-control">
            </div>
            <div class="form-group">
                <label for="phoneNo">Phone Number</label>
                <input type="text" name="phoneNo" id="phoneNo" class="form-control">
            </div>
            <div class="form-group">
                <label for="days">Availability</label>
                @foreach ($days as $day)
                    <input type="checkbox" value="{{ $day->id }}" name="days[]">
                    {{ $day->name }}
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
