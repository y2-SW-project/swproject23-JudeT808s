@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" method="post">
        @method('PUT')
        @csrf
        <div class="container-lg">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ $article->title }}" required>
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" name="subtitle" id="subtitle" class="form-control"
                            value="{{ $article->subtitle }}" required>
                    </div>

                    <div class="form-group">
                        <label for="publish_date">Publish Date</label>
                        <input type="date" name="publish_date" field="publish_date" value="{{ $article->publish_date }}"
                            class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="container">
                        <h5>Images:</h5>
                        <div class="row">
                            @foreach ($article->images as $image)
                                <div class="col-6">
                                    @if (Str::startsWith($image->type, 'image/'))
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}"
                                            class="img-fluid">
                                        <button class="btn btn-danger delete-image-btn" data-article="{{ $article->id }}"
                                            data-image="{{ $image->id }}">Delete</button>
                                    @else
                                        <img src="{{ $image->filename }}" alt="{{ $image->filename }}" class="img-fluid">
                                        <button class="btn btn-danger delete-image-btn" data-article="{{ $article->id }}"
                                            data-image="{{ $image->id }}">Delete</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="image">New Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Update Article</button>
        </div>
    </form>
@endsection
