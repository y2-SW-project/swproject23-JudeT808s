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
                @if (isset($images_by_article[$article->id]))
                    @foreach ($images_by_article[$article->id] as $index => $image)
                        @if (Str::startsWith($image->type, 'image/'))
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}">
                        @else
                            <img src="{{ $image->filename }}" alt="{{ $image->filename }}">
                        @endif
            </div>
            @endforeach
            @endif
            {{-- @if ($image)
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Current Image" style="max-width: 100%">
                @endif --}}
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
    </div>
    </div>


    <button type="submit" class="btn btn-primary">Create Article</button>
</form>
//
