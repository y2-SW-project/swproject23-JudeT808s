@extends('layouts.app')
@section('content')
    <div class="container-fluid mx-5">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <!-- Background image start-->
                    <div class="d-flex justify-content-center align-items-center bg-image"
                        style="
            background-image: url('https://lh3.googleusercontent.com/p/AF1QipPTBAgz919AqamtfaJW_1b_tIhlZaPvUq7r4eqC=w1080-h608-p-no-v0');
            height: 30vh;
        ">
                        <div class="mask mask-custom">
                            <h1 class="text-light fw-bold d-flex justify-content-center mb-5 mt-5 display-emphasis">
                                St. Anne's City Farm and Ecology Centre
                            </h1>
                            <div class="next-line d-flex align-items-center justify-content-center">
                                <a class="btn btn-secondary text-light d-flex align-items-center justify-content-center"
                                    style="max-width: 200px" href="">Visit our shop!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background image end -->
        <div class="container-lg">
            <div class="row justify-content-center">
                <h3 class="fw-bold">About us</h3>
                <div class="col-6 d-flex align-items-center display-secondary">
                    <ul>
                        <li>
                            You found us! Welcome to St. Anne's City Farm's Website.
                        </li>
                        <li>
                            Our public opening hours vary from season to season.
                        </li>
                        <li>
                            Please check our social media for daily updates.
                            Our farm is FREE to visit.You do not need to book a ticket.
                        </li>
                        <li>
                            If you would like to volunteer with us or donate please, Email us at dublincityfarm@gmail.com
                            for
                            more info.
                        </li>
                    </ul>
                    {{-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim quam fugiat doloremque! Accusamus
                        harum,
                        dolore quia, in molestiae architecto vero aspernatur magni, neque dolorum libero culpa illum unde
                        voluptate facere.</p> --}}
                </div>
                <div class="col-6">
                    <img src="https://i.ytimg.com/vi/-298mHkA7lQ/maxresdefault.jpg" alt="" srcset=""
                        style="width: 700px">
                </div>
            </div>
        </div>
        <h3 class="text-center mt-3 fw-bold">Updates</h3>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-1">
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
                            <p class="card-text">{{ date('d/m/Y', strtotime($article->created_at)) }}</p>

                        </div>
                    </div>
                </a>

            </div>
        @endforeach
    </div>
    <!-- Gallery -->
    <div class="container-lg ">
        <div class="row ">
            @foreach ($animals as $key => $animal)
                @if ($loop->odd)
                    <div class="col-lg-4 col-md-12 mb-4 mb-lg-5 mt-5">
                        {{-- <div class="img-responsive h-50 w-100"> --}}
                        <a href="{{ route('admin.animals.show', ['animal' => $animal->id]) }}">
                            @if (isset($images_by_animal[$animal->id]))
                                @foreach ($images_by_animal[$animal->id] as $image)
                                    @if (Str::startsWith($image->type, 'image/'))
                                        <img src="{{ asset('storage/' . $image->path) }}" alt=""
                                            class="shadow-1-strong rounded mb-4 img-responsive odd-image ">
                                    @else
                                        <img src="{{ $image->filename }}" alt="{{ $image->filename }}"
                                            class="shadow-1-strong rounded mb-4 img-responsive odd-image ">
                                    @endif
                                @break
                            @endforeach
                        @endif
                    </a>
                    {{-- </div> --}}
            @endif
            @if ($loop->even)
                <a href="{{ route('admin.animals.show', ['animal' => $animal->id]) }}">
                    <div class="img-responsive h-50 w-100">
                        @if (isset($images_by_animal[$animal->id]))
                            @foreach ($images_by_animal[$animal->id] as $image)
                                @if (Str::startsWith($image->type, 'image/'))
                                    <img src="{{ asset('storage/' . $image->path) }}" alt=""
                                        class="shadow-1-strong rounded mb-4 img-responsive even-image">
                                @else
                                    <img src="{{ $image->filename }}" alt="{{ $image->filename }}"
                                        class="shadow-1-strong rounded mb-4 img-responsive even-image ">
                                @endif
                            @break
                        @endforeach
                    @endif
            </a>
</div>
</div>
@endif
@endforeach
</div>
</div>
<div class="container-lg mt-5">
<div class="row">
<div class="d-flex justify-content-between">
    <h1>Reviews</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Review">
        Write Review
    </button>
</div>
</div>
<div class="row mt-2  justify-content-center">
<div class="modal fade" id="Review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="container mb-3">
                <h1>Create Volunteer</h1>
                <form method="POST" action="{{ route('review.store') }}" enctype="multipart/form-data">
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
</div>
</div>

<div class="row justify-content-center">
@foreach ($reviews as $review)
<div class="card col-3 mx-1 mt-1    ">
    <div class="card-body">
        <p class="card-text">{{ $review->name }}</p>
        @for ($i = 0; $i < $review->stars; $i++)
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-star" viewBox="0 0 16 16">
                <path
                    d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
            </svg>
        @endfor
        <p class="card-text">{{ $review->body }}</p>
    </div>
</div>
@endforeach

</div>
<div class="container-lg bg-image">
<h2>Like what you see?</h2>
<div class="mask mask-custom">
<img src="https://assets.farmsanctuary.org/content/uploads/2020/05/27054129/2010_07-31_FSNY_Hoe_Down_Guest_with_Pig_3668_CREDIT_Jo-Anne_McArthur-1-1600x1065.jpg"
    alt="" class="img-fluid">
<div class="text-container">
    <h1>Like what you see?</h1>
    <a href="{{ route('user.volunteers.create') }}">
        <h1 class="btn btn-dark">Why not volunteer today?</h1>
    </a>
    <a href="{{ route('donate') }}">
        <h1 class="btn btn-dark">Donate</h1>
    </a>
</div>
</div>
</div>
<div class="container-lg">
<div class="row mx-5 mt-3">
<div class="col-6">
    <h3>Find us</h3>
</div>
<div class="col-6">
    <h3 class="text-center">Address</h3>
</div>
<div class="col-6 ">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d353.8323628000281!2d-6.175997650232924!3d53.373843952314395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48670f37483aadd5%3A0x4549ea2f058de263!2sSt.%20Anne&#39;s%20City%20Farm%20and%20Ecology%20Centre!5e0!3m2!1sen!2sie!4v1681648475905!5m2!1sen!2sie"
        allowfullscreen="" loading="lazy" width="100%" height="100%"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    <p class="text-center">
        Mon: Closed<br>
        Tue: Closed<br>
        Wed: Closed<br>
        Thu: Closed<br>
        Fri: Closed<br>
        Sat: 10:00 AM to 2:00 PM<br>
        Sun: 10:00 AM to 2:00 PM<br>
</div>
<div class="col-6  d-flex align-items-center justify-content-center ">
    <h5>All Saints Rd Clontarf East<br> Dublin 5<br> D05 R8P7
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
