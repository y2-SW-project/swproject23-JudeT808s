@extends('layouts.app')
@section('content')
    <div class="container-lg my-3">
        <div class="row shadow">
            <div class="col-12 col-md-9">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner mt-3">
                        @if (isset($images_by_article[$article->id]))
                            @foreach ($images_by_article[$article->id] as $index => $image)
                                <div class="carousel-item{{ $index == 0 ? ' active' : '' }}">
                                    @if (Str::startsWith($image->type, 'image/'))
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}"
                                            class="img-fluid">
                                    @else
                                        <img src="{{ $image->filename }}" alt="{{ $image->filename }}" class="img-fluid">
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
    </div>
@endsection
