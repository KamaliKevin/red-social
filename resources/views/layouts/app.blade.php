<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=Nunito">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Community Links APP') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Search Form -->
                        <form method="get" action="{{ route('community') }}" class="d-flex align-items-center me-2">
                            <div class="input-group">
                                <input class="form-control" type="search"
                                       placeholder="Search for link..." aria-label="Search" name="searchQuery">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>

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
                                    @if(Auth::user()->profile)
                                        <img src="{{ asset(Str::replace("public/", "storage/", Auth::user()->profile->imageUpload)) }}"
                                             class="img-fluid me-2" alt="User Image" style="max-height: 60px;">
                                    @endif
                                    <span>{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @auth
                                        @if(auth()->user()->email_verified_at)
                                            @if(auth()->user()->admin === 1)
                                                <a class="dropdown-item" href="{{ url('/users') }}">
                                                    Dashboard
                                                </a>
                                            @endif
                                        @endif
                                    @endauth
                                    <a class="dropdown-item" href="{{ route('editprofile') }}">
                                        Edit Profile
                                    </a>
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

        <main class="py-4">
            @include('flash-message')
            @yield('content')
        </main>
    </div>
</body>
</html>
