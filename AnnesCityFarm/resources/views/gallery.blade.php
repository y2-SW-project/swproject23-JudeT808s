@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mb-2">
            @foreach ($animals as $animal)
                @if ($loop->index < 3)
                    <div class="col-4">
                        <a href="{{ route('user.animals.show', ['animal' => $animal->id]) }}">
                            @foreach ($images_by_animal[$animal->id] as $image)
                                @if (Str::startsWith($image->type, 'image/'))
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="" class="img-fluid">
                                @else
                                    <img src="{{ $image->filename }}" alt="{{ $image->filename }}" class="img-fluid">
                                @break
                            @endif
                        @endforeach
                    </a>
                </div>
            @elseif($loop->index < 4)
    </div>
    <div class="row  mb-2">
        <div class="col-8 ">
            <a href="{{ route('user.animals.show', ['animal' => $animal->id]) }}">
                @foreach ($images_by_animal[$animal->id] as $image)
                    @if (Str::startsWith($image->type, 'image/'))
                        <img src="{{ asset('storage/' . $image->path) }}" alt="" class="img-fluid">
                    @else
                        <img src="{{ $image->filename }}" alt="{{ $image->filename }}" class="img-fluid">
                    @break
                @endif
            @endforeach
        </a>
    </div>
    <div class="col-4 mb-3">
        <div class="row ">
            <div class="col-12">
            @elseif($loop->index < 6)
                <a href="{{ route('user.animals.show', ['animal' => $animal->id]) }}">
                    @foreach ($images_by_animal[$animal->id] as $image)
                        @if (Str::startsWith($image->type, 'image/'))
                            <img src="{{ asset('storage/' . $image->path) }}" alt="" class="img-fluid">
                        @else
                            <img src="{{ $image->filename }}" alt="{{ $image->filename }}" class="img-fluid">
                        @break

        </div>
        @endif
    </div>
</div>
@endforeach
</div>
@else
@endif
@endforeach
</div>
</div>
@endsection
