<form method="POST" action="{{ route('animal.store') }}" enctype="multipart/form-data">
    @csrf


    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="age">Age</label>
        <input type="text" name="age" id="age" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" id="description" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="species">Species</label>
        <select name="species_id">
            @foreach ($species as $data)
                <option value="{{ $data->id }}" {{ old('species_id') == $data->id ? 'selected' : '' }}>
                    {{ $data->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Create Animal</button>
</form>
