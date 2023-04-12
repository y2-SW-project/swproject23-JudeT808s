<h1>Animals</h1>
@foreach ($animals as $animal)
    <div class="col">
        <a href="{{ route('show', ['id' => $animal->id]) }}">
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
                <h5 class="card-title">{{ $animal->name }}</h5>
                <p class="card-text">{{ $animal->age }}</p>
            </div>
        </div>
    </a>

</div>
@endforeach
</div>
