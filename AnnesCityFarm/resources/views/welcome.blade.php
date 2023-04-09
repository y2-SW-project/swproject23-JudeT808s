@extends('layouts.app')
@section('content')
    <div class="container mx-5">
        <div class="row justify-content-center">
            <div>
                <ul>
                    <a href="{{ route('article-create') }}">Create Article</a>


                    {{-- {{ $articles_by_filename[1] }} --}}


                </ul>


                {{-- @foreach ($images->articles as $article)
                    {
                    {{ dd($article) }}
                    }
                @endforeach --}}

                <h1>Hello World</h1>
                <h3>This is a laravel-bootstrap template</h3>
                <div class="mt-5">
                    <button type="button" class="btn btn-primary">Primary</button>
                    <button type="button" class="btn btn-secondary">Secondary</button>
                    <button type="button" class="btn btn-success">Success</button>
                    <button type="button" class="btn btn-danger">Danger</button>
                    <button type="button" class="btn btn-warning">Warning</button>
                    <button type="button" class="btn btn-info">Info</button>
                    <button type="button" class="btn btn-light">Light</button>
                    <button type="button" class="btn btn-dark">Dark</button>
                    <button type="button" class="btn btn-link">Link</button>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4 mt-5">

                    @foreach ($articles as $article)
                        <div class="col">
                            <a href="{{ route('show', ['id' => $article->id]) }}">
                                <div class="card">
                                    @foreach ($images_by_article[$article->id] as $image)
                                        {{-- <img src="{{ $image->filename }}"class="card-img-top"> --}}
                                        @if (Str::startsWith($image->type, 'image/'))
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="">


                                            {{-- <img src="{{ asset($image->path) }}" alt="{{ $image->filename }}"> --}}
                                        @else
                                            <img src="{{ $image->filename }}" alt="{{ $image->filename }}">
                                        @endif
                                    @break
                                @endforeach


                                <div class="card-body">
                                    <h5 class="card-title">{{ $article->title }}</h5>
                                    <p class="card-text">{{ $article->subtitle }}</p>
                                </div>
                            </div>
                        </a>

                    </div>
                @endforeach
            </div>


            {{-- @foreach ($articles as $article)
                    @foreach ($article->images as $image)
                        <div class="col">
                            <div class="card">

                                <img src="{{ $image->filename }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a longer card with supporting text below as a natural
                                        lead-in
                                        to additional content. This content is a little bit longer.</p>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endforeach
                <div class="col">
                    <div class="card">
                        <img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-social.png" class="card-img-top"
                            alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural
                                lead-in
                                to additional content.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-social.png" class="card-img-top"
                            alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural
                                lead-dsdsdsin
                                to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div> --}}
        </div>
    </div>
</div>
</div>
@endsection
