@extends('layouts.app')
@section('content')
    <div class="container-lg px-5">
        <div class="row">
            @foreach ($related as $animal)
                <div class="col-3">
                    @foreach ($animal->images as $image)
                        <img class="img-fluid"src=" {{ $image->filename }}">
                    @endforeach
                    <h5>{{ $animal->name }}</h5>
                    <p>{{ $animal->age }}</p>
                    <p>{{ $animal->description }}</p>
                    <p>{{ $animal->species->name }}</p>
                    <p>{{ $animal->species->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
