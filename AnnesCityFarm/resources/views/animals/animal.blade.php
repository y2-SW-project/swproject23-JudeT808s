@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <a href="{{ route('animal-edit', ['animal' => $animal->id]) }}" class="btn-link ml-auto">Edit
                    animal</a>
                <form action="{{ route('animal-delete', $animal->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @if (isset($images_by_animal[$animal->id]))
                            @foreach ($images_by_animal[$animal->id] as $index => $image)
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
                    <h5 class="card-title">{{ $animal->name }}</h5>
                    <p class="card-text">{{ $animal->age }}</p>
                    <p class="card-text">{{ $animal->description }}</p>
                    <p class="card-text">{{ $animal->species->name }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
