<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            html, body { background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;}
            .full-height {height: 100vh;}
            .flex-center {align-items: center;
                display: flex;
                justify-content: center; }
            .position-ref { position: relative;}
            .top-right { position: absolute;
                right: 10px;
                top: 18px;}
            .content { text-align: center;}
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">

                {{--$name GLIELO PASSO COSI' AL COMPONENTE, LE STRINGHE INVECE TRA '' --}}
                <x-alert class="d-flex flex-row" style="color: white" :name="$name" :info="'danger'" :message="'Messaggio nella view'" />

                <x-card>
                    Testo della card che finisce dentro $slot
                </x-card>

{{--
                @component('components.alert')
                    @slot('info' , 'success')
                    @slot('name' , 'Edoardo')
                    @slot('message' , 'Questo è il vecchio modo')
                    --}}
{{--attributes NON PRESO, DOVREI METTERE IL ! NEL TEMPLATE--}}{{--

                    @slot('attributes' , 'style="color: white"')
                    Second component
                @endcomponent
--}}

                <x-alert>
                    @slot('info' , 'info')
                    @slot('name' , 'Testagrossa')
                    @slot('message' , 'Passo SLOT dentro X-ALERT')
                </x-alert>
            </div>
        </div>
    </body>
</html>
