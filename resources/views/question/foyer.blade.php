@extends('layouts.live_quiz', ['all_questions' => $all_questions, 'question' => $question, 'master' => true])

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
                        <h1 class="text-white">{{ html_entity_decode(htmlspecialchars_decode($question->question)) }}</h1>
                    </div>
                </div>
            </div>
              <div class="text-center mt-7 mb-7">
                  <div class="row justify-content-center">
                      <div class="col-lg-5 col-md-6">
                          <p class="text-white" dusk="your-answer">
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
            <span id="next_question_btn_text" class="btn-inner--text">Loading</span>
            <span class="btn-inner--icon"><i id="next_question_btn_icon" class=""></i></span>
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
      url: '{{ route('next_question', [$question]) }}?api_token={{auth()->user()->api_token}}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
       clearInterval(interval);

       $('#next_question_btn').attr('href', data.next);
       $('#next_question_btn').attr('dusk', data.type);
       $('#next_question_btn_text').text(data.btn_text);
       $('#next_question_btn_icon').removeClass().addClass('fa fa-play');
       $('#next_question_btn').removeClass('disabled').addClass('active');
     },
      error: function(data){
      // quiz ready, update page
       $('#next_question_btn_text').text(data.responseJSON.btn_text);
       $('#next_question_btn_icon').removeClass();
       $('#next_question_btn').addClass('disabled');
     }
     });
    }

    function fetchdata_res(){
     $.ajax({
      url: '{{ route('response.count', [$question]) }}?api_token={{auth()->user()->api_token}}',
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
