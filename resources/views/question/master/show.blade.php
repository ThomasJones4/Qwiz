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
                        <h1 class="text-white">{{ $question->question }}</h1>
                        @if (null != $question->possible_answers)<h2 class="text-white"><i>Possible Answers: {{ $question->possible_answers }}</i></h2>  @endif
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                      <div class="container">
                        <div class="row">

                      @php $count = 0 @endphp
                      @foreach($question->media as $media)
                      @php $count++ @endphp
                            <div class="col-sm">
                              <h3 class="text-white">{{$count}})</h3>
                                  @if ($media->type == 'image')
                                    <img max-width="20%" height="auto" src="{{ asset('quiz-media') . '/' .$media->url}}">
                                  @elseif ($media->type == 'video')
                                    <video width="400" controls>
                                      <source src="{{ asset('quiz-media') . '/' .$media->url}}" type="video/{{$media->extension}}">
                                      Your browser does not support HTML video.
                                    </video>
                                  @elseif ($media->type == 'audio')
                                  <audio controls>
                                    <source src="{{ asset('quiz-media') . '/' .$media->url}}" type="audio/mp3">
                                    Your browser does not support the audio element.
                                  </audio>
                                  @endif
                                </div>
                            @endforeach
                          </div>
                        </div>
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
          <a href="#" id="next_question_btn" class="btn btn-primary btn-lg" role="button" aria-pressed="true">
            <span id="next_question_btn_text" class="btn-inner--text">Loading ...</span>
            <span class="btn-inner--icon"><i id="next_question_btn_icon" class="fa fa-hourglass-start"></i></span>
          </a>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>


    function fetchdata_res(){
     $.ajax({
      url: '{{ route('response.count', [$question]) }}?api_token={{auth()->user()->api_token}}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
      if (data['count'] != -1) {
         $('#response_count').text(data['count'] + '/' + data['total'] + ' responded');

         if (data['total'] > 0 && data['count'] == data['total']) {
           clearInterval(interval_res);
         }
      } else {
        $('#response_count').text('Not Released');
      }

     }
     });
    }

    function fetchdata_next(){
     $.ajax({
      url: '{{ route('master_next', [$question]) }}?api_token={{auth()->user()->api_token}}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
       clearInterval(interval_next);

       $('#next_question_btn').attr('href', data.next);
       $('#next_question_btn_text').text(data.btn_text);
       $('#next_question_btn_icon').removeClass().addClass('fa fa-play');
       $('#next_question_btn').removeClass('disabled').addClass('active');
     }
     });
    }

    $(document).ready(function(){
     fetchdata_res();
     interval_res = setInterval(fetchdata_res,2000);
     fetchdata_next();
     interval_next = setInterval(fetchdata_next,2000);
    });
    </script>
@endpush
