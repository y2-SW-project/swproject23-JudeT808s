@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mb-2">
            @foreach ($animals as $animal)
                @if ($loop->index < 3)
                    <div class="col-4">
                        <a href="{{ route('user.animals.show', ['animal' => $animal->id]) }}">
                            @if (isset($images_by_animal[$animal->id]))
                                @foreach ($images_by_animal[$animal->id] as $image)
                                    @if (Str::startsWith($image->type, 'image/'))
                                        <img src="{{ asset('storage/' . $image->path) }}" alt=""
                                            class="shadow-1-strong rounded mb-4  img-fluid gall ">
                                    @else
                                        <img src="{{ $image->filename }}" alt="{{ $image->filename }}"
                                            class="shadow-1-strong rounded mb-4  img-fluid gall " style="img-responsive">
                                    @endif
                                @break
                            @endforeach
                        @endif
                    </a>
                </div>
            @elseif($loop->index < 4)
    </div>
    <div class="row  mb-2">
        <div class="col-8 ">
            <a href="{{ route('user.animals.show', ['animal' => $animal->id]) }}">
                @if (isset($images_by_animal[$animal->id]))
                    @foreach ($images_by_animal[$animal->id] as $image)
                        @if (Str::startsWith($image->type, 'image/'))
                            <img src="{{ asset('storage/' . $image->path) }}" alt=""
                                class="shadow-1-strong rounded mb-4  img-fluid gall ">
                        @else
                            <img src="{{ $image->filename }}" alt="{{ $image->filename }}"
                                class="shadow-1-strong rounded mb-4  img-fluid gall >
@endif
@break
@endforeach
            @endif
        </a>
    </div>
    <div class="col-4
                                mb-3">
                        @elseif($loop->index < 6)
                            <div class="col-12 mt-2">

                                <a href="{{ route('user.animals.show', ['animal' => $animal->id]) }}">
                                    @if (isset($images_by_animal[$animal->id]))
                                        @foreach ($images_by_animal[$animal->id] as $image)
                                            @if (Str::startsWith($image->type, 'image/'))
                                                <img src="{{ asset('storage/' . $image->path) }}" alt=""
                                                    class="shadow-1-strong rounded mb-4  img-fluid gall ">
                                            @else
                                                <img src="{{ $image->filename }}" alt="{{ $image->filename }}"
                                                    class="shadow-1-strong rounded mb-4  img-fluid gall ">
                                            @endif
                                        @break
                                    @endforeach
                                @endif
                            @break

                    </div>
                @endif
</div>
@endforeach
</div>

</div>
</div>
@endsection
