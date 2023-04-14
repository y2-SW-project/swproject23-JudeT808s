@extends('layouts.app')
'name' => 'required',
'stars' => 'required',
'body' => 'required',
@section('content')
    <div class="container">
        <h1>Create Volunteer</h1>
        <form method="POST" action="{{ route('volunteer.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="stars">stars</label>
                <input type="text" name="stars" id="stars" class="form-control">
            </div>
            <div class="form-group">
                <label for="body">body</label>
                <input type="text" name="body" id="body" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
