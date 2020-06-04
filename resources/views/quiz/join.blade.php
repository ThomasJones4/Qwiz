<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">

        <!-- Primary Meta Tags -->
        <title>Qwiz - Make your own quiz and play with friends</title>
        <meta name="title" content="Qwiz - Make your own quiz and play with friends">
        <meta name="description" content="">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://qwiz.co.uk/">
        <meta property="og:title" content="Qwiz - Make your own quiz and play with friends">
        <meta property="og:description" content="">
        <meta property="og:image" content="{{ route('social.quiz.header', $quiz)}}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="http://qwiz.co.uk/">
        <meta property="twitter:title" content="Qwiz - Make your own quiz and play with friends">
        <meta property="twitter:description" content="">
        <meta property="twitter:image" content="{{ route('social.quiz.header', $quiz)}}">

    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        @endauth

        <div class="main-content">
            @include('layouts.navbars.navbar')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $quiz->name }}</h1>
                        <h3 class="text-white">Quiz Master: {{ $quiz->quiz_master->name }}</h3>
                        @can('view', $quiz)
                          <h3 class="text-white"><a class="text-white" href="{!! route('show.join.quiz.emoji', $quiz) !!}" >{!! urldecode(route('show.join.quiz.emoji', $quiz)) !!}</a></h3>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                  <form action="{{ route('join.quiz', [$quiz]) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-control-label text-white" for="invite_code">Invite Code</label>
                        @can('view', $quiz)
                          <input class="form-control form-control-lg" type="text" style="text-align:center;" value="{{ $quiz->invite_code }}" id="invite_code" name="invite_code">
                        @else
                          <input class="form-control form-control-lg" type="text" placeholder="00000000" id="invite_code" name="invite_code">
                        @endcan
                    </div>

                    @error('invite_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror


                    @cannot('view_master', $quiz)
                      <button class="btn btn-primary" type="submit">Join</button>
                    @endcan
                  </form>
                </div>
            </div>
        </div>
    </div>

  </div>

  @guest()
      @include('layouts.footers.guest')
  @endguest

  <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
  <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  @stack('js')

  <!-- Argon JS -->
  <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
  <script src="{{ asset('argon') }}/js/sweetalert2.min.js"></script>

  </body>
  </html>

    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
