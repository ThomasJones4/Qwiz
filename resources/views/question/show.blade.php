@extends('layouts.live_quiz', ['all_questions' => $all_questions, 'question' => $question, 'master' => false])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">@if ($question->title != "%%scores%%") {{ $question->title }} @else Scores @endif</h1>
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                      @if ($question->title != "%%scores%%")
                        <h1 class="text-white">{{ $question->question }}</h1>
                        @if (null != $question->possible_answers)<h2 class="text-white"><i>Possible Answers: {{ $question->possible_answers }}</i></h2>  @endif
                      @endif
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
              <div class="text-center mt--7">
                <div class="row justify-content-center">
                    <p class="text-white" id="response_count"></p>
                </div>
              </div>
                <div class="row justify-content-center">
                  <form action="{{ route('store.response', [$question]) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <input class="form-control form-control-lg" type="text" placeholder="answer" id="answer" name="answer" >
                    </div>
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

                    @error('answer')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if ($question->have_i_answered())
                    <button class="btn btn-primary" type="submit">Submit Again</button>
                    <h2 class="text-white"> or </h2>
                    <a href="{{ route('question.lobby', $question)}}" class="btn btn-primary" role="button">Go to next question</a>
                    @else
                    <button class="btn btn-primary" type="submit">Submit</button>

                    @endif
                  </form>

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
     interval = setInterval(fetchdata,1000);
    });
    </script>
@endpush
