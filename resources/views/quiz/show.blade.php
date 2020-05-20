@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $quiz->name }}</h1>
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $quiz->quiz_master->name }}</h1>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center mt--7">
        <div class="row justify-content-center">
          <a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
            <span class="btn-inner--icon"><i class="fa fa-hourglass-start"></i></span>
            <span class="btn-inner--text">Waiting for quiz to start</span>
          </a>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>
    function fetchdata(){
     $.ajax({
      url: '{{ route('quiz_ready', [$quiz]) }}',
      type: 'get',
      success: function(response){
       // Perform operation on the return value
       console.log(response);
      }
     });
    }

    $(document).ready(function(){
     setInterval(fetchdata,2000);
    });
    </script>
@endpush
