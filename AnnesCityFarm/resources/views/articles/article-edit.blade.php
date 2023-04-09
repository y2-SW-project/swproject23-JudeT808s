<form method="POST" action="{{ route('article-update', $article) }}" enctype="multipart/form-data" method="post">
    {{-- {{ $article }} --}}
    {{-- {{ dd($article) }} --}}
    @method('PUT')
    @csrf
    <label for="title">Title</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ $article->title }} " required>
    <div class="form-group">
    </div>

    <div class="form-group">
        <label for="subtitle">Subtitle</label>
        <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ $article->subtitle }} "
            required>
    </div>

    <div class="form-group">
        <label for="publish_date">Publish Date</label>
        <input type="date" name="publish_date"field="publish_date" value="{{ $article->publish_date }}" />
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="image">Image</label>
                @foreach ($article->images as $image)
                    @if (Str::startsWith($image->type, 'image/'))
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}">
                        <button class="btn btn-danger delete-image-btn" data-article="{{ $article->id }}"
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
                var articleId = event.target.getAttribute('data-article');
                var imageId = event.target.getAttribute('data-image');
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var xhr = new XMLHttpRequest();
                xhr.open('DELETE', '/articles/' + articleId + '/images/' + imageId);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send();
            }
        });
    </script>

    <button type="submit" class="btn btn-primary">Update Article</button>

</form>
