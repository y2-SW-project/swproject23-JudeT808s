@extends('layouts.app')
@section('content')
    <div class="row">

        @foreach ($images_by_article[$article->id] as $image)
            <div class="col">
                <div class="card">
                    <img src="{{ $image->filename }}"class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text">{{ $article->subtitle }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
