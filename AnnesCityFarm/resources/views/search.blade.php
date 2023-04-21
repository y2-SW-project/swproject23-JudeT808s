@extends('layouts.app')
@section('content')

    <h1>Search Results</h1>

    @if ($results->count() > 0)
        <ul>

            @foreach ($results as $result)
                <a href="{{ route('user.animals.show', ['animal' => $result->id]) }}">
                    <li>{{ $result->name }}</li>
                    <li>{{ $result->age }}</li>
                    <li>{{ $result->description }}</li>
                </a>
            @endforeach
        </ul>
    @else
        <p>No results found.</p>
    @endif

@endsection
