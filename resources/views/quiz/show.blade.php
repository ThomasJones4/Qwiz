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
          <a href="#" id="quiz_start_btn" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
            <span id="quiz_start_btn_text" class="btn-inner--text">Waiting for quiz to start</span>
            <span class="btn-inner--icon"><i id="quiz_start_btn_icon" class="fa fa-hourglass-start"></i></span>
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
      success: function(data){
      // quiz ready, update page
       clearInterval(interval);
       $('#quiz_start_btn').attr('href', data.next);
       $('#quiz_start_btn_text').text('Start Quiz');
       $('#quiz_start_btn_icon').removeClass().addClass('fa fa-play');
     }
     });
    }

    $(document).ready(function(){
     fetchdata();
     interval = setInterval(fetchdata,2000);
    });
    </script>
@endpush
