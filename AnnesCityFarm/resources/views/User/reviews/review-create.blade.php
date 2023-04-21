@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Review</h1>
        <form method="POST" action="{{ route('review.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="stars">stars</label>
                @for ($i = 0; $i < 5; $i++)
                    <input type="radio" name="stars" value={{ $i + 1 }}>
                @endfor

            </div>
            <div class="form-group">
                <label for="body">body</label>
                <input type="text" name="body" id="body" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @endsection
