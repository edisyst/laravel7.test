<!doctype html>
<html lang="en">

<head>
    <script>
        //IN OGNI PARTE DEL MIO TEMPLATE POSSO ACCEDERE ALL'OGGETTO Laravel CON LE VAR CHE GLI INIETTO
        window.Laravel = {!!  json_encode([
            'csrfToken' => csrf_token(),
        ])  !!};
    </script>


    <title>@yield('title' , 'Home')</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/bootstrap.css" >

    <link rel="stylesheet" href="/css/all.css" />
    <link rel="stylesheet" href="/css/fontawesome.css" />
    <link rel="stylesheet" href="/css/lightbox.css" />

    <style>
        body{ background-color: #bbb;}
    </style>

</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">IMG Gallery</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('albums')}}">Albums</a>
            </li>
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{route('album.create')}}">New Album</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('photos.create')}}">New Image</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('categories.index')}}">Categories</a>
                </li>
            @endauth
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>


        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>

    </div>
</nav>


<main role="main" class="container">
    {{--EREDITA IL content DA staffb.blade.php--}}
    @yield('content')
</main><!-- /.container -->


@section('footer')
    <!-- Bootstrap core JavaScript
    ================================================== -->
    {{--L'ORIGINALE ERA https://code.jquery.com/jquery-3.4.1.SLIM.min.js MA NON HA AJAX--}}
    {{--<script src="/public/js/jquery-3.4.1.js"></script>--}}

    <script src="https://code.jquery.com/jquery-3.4.1.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.js" ></script>
    <script src="/js/lightbox.js"></script>
@show  {{--CON QUESTO COMANDO IO MOSTRO IL CONTENUTO DELLA @section--}}

</body>
</html>
