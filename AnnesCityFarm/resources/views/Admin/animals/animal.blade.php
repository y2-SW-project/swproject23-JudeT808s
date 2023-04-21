@extends('layouts.app')
@section('content')
    <div class="container-lg px-5">
        <div class="row shadow-5">
            <a href="{{ route('admin.animals.edit', ['animal' => $animal->id]) }}" class="btn-link ml-auto">Edit
                animal</a>
            <form action="{{ route('admin.animals.destroy', $animal->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

            <div class="col-4">
                @if (isset($images_by_animal[$animal->id]))
                    @foreach ($images_by_animal[$animal->id] as $index => $image)
                        @if ($loop->first)
                            @if (Str::startsWith($image->type, 'image/'))
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}"
                                    class="ecommerce-gallery-main-img active w-100" style="max-width:300px">
                            @else
                                <img src="{{ $image->filename }}" alt="{{ $image->filename }}"
                                    class="ecommerce-gallery-main-img active w-100" style="max-width:300px">
                            @endif
                            <h5>{{ $animal->name }}</h5>
                            <p>{{ $animal->age }}</p>
                            <p>{{ $animal->description }}</p>
                            <p>{{ $animal->species->name }}</p>
            </div>
            <div class="col-8">
                <div class="row">
                @else
                    <div class="col-6 shadow-1-strong rounded mb-4">
                        @if (Str::startsWith($image->type, 'image/'))
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->filename }}"
                                class="w-100 ecommerce-gallery-thumbnail" style="max-width:300px"
                                data-src="{{ asset('storage/' . $image->path) }}">
                        @else
                            <img src="{{ $image->filename }}" alt="{{ $image->filename }}"
                                class="w-100 ecommerce-gallery-thumbnail" style="max-width:300px"
                                data-src="{{ $image->filename }}">
                        @endif
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>

        </div>
        <div class="container">
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

    </div>


    <script>
        $('.ecommerce-gallery-thumbnail').on('click', function() {
            var src = $(this).data('src');
            $('.ecommerce-gallery-main-img').attr('src', src);
        });
    </script>

@endsection
