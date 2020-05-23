@extends('layouts.live_quiz', ['all_questions' => $all_questions, 'question' => $question])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $question->title }}</h1>
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $question->content }}</h1>
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <p class="text-white">
                          Your Answer : {{ $answers->last()->answer }}
                          @if ($answers->count() > 1)
                          <br>
                          Other Answers:
                            @foreach ($answers as $answer )
                            <br>
                              {{$answer->answer}}
                            @endforeach
                          @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt--7">
          <div class="row justify-content-center">
              <p class="text-white" id="response_count">loading responded stats</p>
          </div>
        </div>
    </div>

    <div class="text-center mt--7">
        <div class="row justify-content-center">
          <a href="#" id="next_question_btn" class="btn btn-primary btn-lg disabled" role="button" aria-pressed="true">
            <span id="next_question_btn_text" class="btn-inner--text">Waiting for Quiz Master</span>
            <span class="btn-inner--icon"><i id="next_question_btn_icon" class="fa fa-hourglass-start"></i></span>
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
      url: '{{ route('next_question', [$question]) }}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
       clearInterval(interval);

       $('#next_question_btn').attr('href', data.next);
       $('#next_question_btn_text').text(data.btn_text);
       $('#next_question_btn_icon').removeClass().addClass('fa fa-play');
       $('#next_question_btn').removeClass('disabled').addClass('active');
     }
     });
    }

    function fetchdata_res(){
     $.ajax({
      url: '{{ route('response.count', [$question]) }}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
       $('#response_count').text(data['count'] + '/' + data['total'] + ' responded');

       if (data['count'] == data['total']) {
         clearInterval(interval_res);
       }
     }
     });
    }

    $(document).ready(function(){
     fetchdata();
     fetchdata_res();
     interval_res = setInterval(fetchdata_res,2000);
     interval = setInterval(fetchdata,2000);
    });
    </script>
@endpush
