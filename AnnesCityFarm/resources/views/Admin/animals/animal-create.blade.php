@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="POST" action="{{ route('admin.animals.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" name="age" id="age" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="species">Species</label>
                <select name="species_id" id="species" class="form-control">
                    @foreach ($species as $data)
                        <option value="{{ $data->id }}" {{ old('species_id') == $data->id ? 'selected' : '' }}>
                            {{ $data->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control-file" required>

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create Animal</button>
            </div>
        </form>
    </div>
@endsection
