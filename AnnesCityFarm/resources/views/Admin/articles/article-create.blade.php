@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" name="subtitle" id="subtitle" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="publish_date">Publish Date</label>
            <input type="date" name="publish_date" id="publish_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <div class="custom-file">
                <input type="file" name="image" id="image" class="custom-file-input" required>
                <label class="custom-file-label" for="image"></label>
            </div>Choose
        </div>
        <button type="submit" class="btn btn-primary">Create Article</button>
    </form>
@endsection
