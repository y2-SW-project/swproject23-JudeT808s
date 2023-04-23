@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('admin.animals.update', $animal) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $animal->name }}" required>
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="text" name="age" id="age" class="form-control" value="{{ $animal->age }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $animal->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="species">Species</label>
            <select name="species_id" id="species" class="form-control">
                @foreach ($species as $data)
                    <option value="{{ $data->id }}"
                        {{ old('species_id', $animal->species_id) == $data->id ? 'selected' : '' }}>
                        {{ $data->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <div class="row">
                @foreach ($animal->images as $image)
                    <div class="col-6 mb-2">
                        @if (Str::startsWith($image->type, 'image/'))
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}"
                                class="img-thumbnail">
                            <button class="btn btn-danger btn-sm delete-image-btn" data-animal="{{ $animal->id }}"
                                data-image="{{ $image->id }}">Delete</button>
                        @else
                            <img src="{{ $image->filename }}" alt="{{ $image->filename }}" class="img-thumbnail">
                        @endif
                    </div>
                @endforeach
            </div>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Update Animal</button>

    </form>
@endsection
