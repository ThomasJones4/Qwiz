@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                  <div class="flex-center position-ref full-height">
                      <div class="code">
                          <h1 class="text-white">@yield('code')</h1>
                      </div>

                      <div class="message" style="padding: 10px;">
                          <h1 class="text-white">@yield('message')</h1>
                      </div>
                  </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

@endpush
