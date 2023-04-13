<form method="POST" action="{{ route('animal-update', $animal) }}" enctype="multipart/form-data" method="post">
    @method('PUT')
    @csrf
    <label for="title">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ $animal->name }} " required>
    <div class="form-group">
    </div>

    <div class="form-group">
        <label for="age">Age</label>
        <input type="text" name="age" id="age" class="form-control" value="{{ $animal->age }} " required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description"field="description" value="{{ $animal->description }}" />
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
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="image">Image</label>
                @foreach ($animal->images as $image)
                    @if (Str::startsWith($image->type, 'image/'))
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}">
                        <button class="btn btn-danger delete-image-btn" data-animal="{{ $article->id }}"
                            data-image="{{ $image->id }}">Delete</button>
                    @else
                        <img src="{{ $image->filename }}" alt="{{ $image->filename }}">
                    @endif
                @endforeach
            </div>

            <input type="file" class="form-control-file" id="image" name="image">
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.delete-image-btn')) {
                var animalId = event.target.getAttribute('data-article');
                var imageId = event.target.getAttribute('data-image');
                var csrfToken = document.querySelector('input[name="_token"]').value;

                // Use fetch API for AJAX request
                fetch('/animals/' + animalId + '/images/' + imageId, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': csrfToken
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            console.log(response.statusText);
                        }
                    })
                    .catch(error => console.log(error));
            }
        });
    </script>

    <button type="submit" class="btn btn-primary">Update Article</button>

</form>
