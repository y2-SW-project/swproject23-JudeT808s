@extends('layouts.app')
@section('content')
    <div class="container-lg mx-2">
        <div class="row shadow-5">
            <div class="col-3 d-flex">
                <a class="btn btn-primary" href="{{ route('admin.articles.edit', ['article' => $article->id]) }}"
                    class="btn-link ml-auto">Edit
                    article</a>
                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
            </div>
        </div>
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @if (isset($images_by_article[$article->id]))
                    @foreach ($images_by_article[$article->id] as $index => $image)
                        <div class="carousel-item{{ $index == 0 ? ' active' : '' }}">
                            @if (Str::startsWith($image->type, 'image/'))
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}">
                            @else
                                <img src="{{ $image->filename }}" alt="{{ $image->filename }}">
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $article->title }}</h5>
            <p class="card-text">{{ $article->subtitle }}</p>
        </div>
    </div>
    </div>
@endsection
