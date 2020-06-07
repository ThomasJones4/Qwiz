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
                        <h1 class="text-white">By {{ $quiz->quiz_master->name }}</h1>
                    </div>
                </div>
            </div>



    <div class="text-center mt--7 pt-8">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-6">

            <button class="btn btn-primary btn-sm justify-content-center" id="goFS">Go fullscreen ✨</button>

          </div>
        </div>
      </div>

    <div class="text-center mt--7">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-6">

    <a href="#" id="quiz_start_btn" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
      <span id="quiz_start_btn_text" class="btn-inner--text">Waiting for quiz master</span>
      <span class="btn-inner--icon"><i id="quiz_start_btn_icon" class="fa fa-hourglass-start"></i></span>
    </a>

          </div>
        </div>
      </div>

</div>

  </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>
    function fetchdata(){
     $.ajax({
      url: '{{ route('quiz_ready', [$quiz]) }}?api_token={{auth()->user()->api_token}}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
       clearInterval(interval);
       $('#quiz_start_btn').attr('href', data.next);
       $('#quiz_start_btn').attr('dusk', 'start_quiz');
       $('#quiz_start_btn_text').text('Start Quiz');
       $('#quiz_start_btn_icon').removeClass().addClass('fa fa-play');
     }
     });
    }

    $(document).ready(function(){
     fetchdata();
     interval = setInterval(fetchdata,2000);
    });



  var goFS = document.getElementById("goFS");
  goFS.addEventListener("click", function() {
      document.body.requestFullscreen();
  }, false);

    </script>
@endpush
