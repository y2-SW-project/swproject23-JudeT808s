@extends('layouts.app')
@section('content')
    <div class="container mx-5">
        <div class="row justify-content-center">
            <div>
                <ul>
                    <a href="{{ route('admin.articles.create') }}">Create Article</a>
                    <a href="{{ route('admin.animals.create') }}">Create Animal</a>


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
                            <a href="{{ route('admin.articles.show', ['article' => $article->id]) }}">
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

            <div class="row row-cols-1 row-cols-md-3 g-4 mt-5">

                <h1>Animals</h1>

                @foreach ($animals as $animal)
                    <div class="col">
                        <a href="{{ route('admin.animals.show', ['animal' => $animal->id]) }}">
                            <div class="card">
                                @if (isset($images_by_animal[$animal->id]))
                                    @foreach ($images_by_animal[$animal->id] as $image)
                                        @if (Str::startsWith($image->type, 'image/'))
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="">
                                        @else
                                            <img src="{{ $image->filename }}" alt="{{ $image->filename }}">
                                        @endif
                                    @break
                                @endforeach
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $animal->name }}</h5>
                                <p class="card-text">{{ $animal->age }}</p>
                                <p class="card-text">{{ $animal->species->name }}</p>
                            </div>
                        </div>
                    </a>

                </div>
            @endforeach
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-5">
            <h1>Reviews</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Review">
                Write Review
            </button>
            <div class="modal fade" id="Review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="container">
                            <h1>Create Volunteer</h1>
                            <form method="POST" action="{{ route('review.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="stars">stars</label>
                                    @for ($i = 0; $i < 5; $i++)
                                        <input type="radio" name="stars" value={{ $i + 1 }}>
                                    @endfor

                                </div>
                                <div class="form-group">
                                    <label for="body">body</label>
                                    <input type="text" name="body" id="body" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($reviews as $review)
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">{{ $review->name }}</p>
                        @for ($i = 0; $i < $review->stars; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                <path
                                    d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                            </svg>
                        @endfor
                        <p class="card-text">{{ $review->body }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- Add this code to handle modal functionality -->
<script>
    $(document).ready(function() {
        $('#Review').on('shown.bs.modal', function() {
            // Code to be executed when modal is shown
        });

        $('#Review').on('hidden.bs.modal', function() {
            // Code to be executed when modal is hidden
        });
    });
</script>
@endsection
