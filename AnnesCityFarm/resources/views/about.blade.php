@extends('layouts.app')
@section('content')
    <div class="container-fluid py-5">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h3 class="fw-bold mb-4">About us</h3>
                    <ul class="list-unstyled">
                        <li>You found us! Welcome to St. Anne's City Farm's Website.</li>
                        <li>Our public opening hours vary from season to season.</li>
                        <li>Please check our social media for daily updates. Our farm is FREE to visit. You do not need to
                            book a ticket.</li>
                        <li>If you would like to volunteer with us or donate please, email us at dublincityfarm@gmail.com
                            for more info.</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="https://i.ytimg.com/vi/-298mHkA7lQ/maxresdefault.jpg" alt="" class="w-100">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="bg-image"
                style="background-image: url('https://lh3.googleusercontent.com/p/AF1QipPTBAgz919AqamtfaJW_1b_tIhlZaPvUq7r4eqC=w1080-h608-p-no-v0'); height: 30vh;">
                <div class="mask mask-custom d-flex align-items-center justify-content-center flex-column text-center">
                    <h1 class="text-light fw-bold mb-4 display-emphasis">
                        Like what you see? Why not volunteer?
                    </h1>
                    <a class="btn btn-secondary text-light mb-5" href="#">Volunteer</a>
                </div>
            </div>
        </div>
    </div>
@endsection
