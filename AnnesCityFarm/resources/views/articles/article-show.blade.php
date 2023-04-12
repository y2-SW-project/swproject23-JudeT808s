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
