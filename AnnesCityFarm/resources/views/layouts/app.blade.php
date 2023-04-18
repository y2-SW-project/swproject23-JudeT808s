<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- jQuery library -->


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,400;0,500;0,800;1,400&family=PT+Serif:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- MDB CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/d9537ccec9.js" crossorigin="anonymous"></script>



    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @php $user = Auth::user() @endphp
                    @if (empty($user))
                    @elseif ($user->check('admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.articles.create') }}">Create Article</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.animals.create') }}">Create Animal</a>
                        </li>
                    @else
                        <!-- Link for regular users -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.volunteers.create') }}">Volunteer</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('gallery') }}">Gallery</a>
                        </li>
                    @endif
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <body>


        <main class="py-4">
            @yield('content')
        </main>
        <footer class="py-3 bg-gradient bg-primary sticky-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h5 class="text-light">Contact us</h5>
                        <li class="nav-item text-light">
                            All Saints Rd Clontarf East
                            Dublin 5
                            D05 R8P7
                        </li>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-light">Links</h5>
                        <li class="nav-item text-light">
                            <a class="nav-link" href="{{ route('info') }}">About us</a>
                        </li>
                        <li class="nav-item text-light">
                            <a class="nav-link" href="{{ route('info') }}">Calendar</a>
                        </li>
                        <li class="nav-item text-light">
                            <a class="nav-link" href="{{ route('info') }}">Donate</a>
                        </li>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-light">Follow us on</h5>
                        <ul class="d-flex">
                            <li class="nav-item text-light">
                                <i class="fa-brands fa-instagram"></i>
                            </li>
                            <li class="nav-item text-light">
                                <i class="fa-brands fa-twitter"></i>
                            </li>
                            <li class="nav-item text-light">
                                <i class="fa-brands fa-facebook"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 d-flex align-items-flex-end">
                        <p class="text-white">&copy; 2023 Jude McCrea. All rights reserved.</p>
                    </div>
                </div>

            </div>
        </footer>
</div>

</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

</html>
