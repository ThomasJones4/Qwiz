@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">Quiz Marking</h1>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            </div>
                    </div>
                </div>

                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Question') }}</th>
                                @foreach ($quiz->users as $participant)
                                <th scope="col">{{ $participant->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_questions as $question)
                            @if ($question->title != "mid-scores")
                                <tr>
                                  <td>{{ $question->question }}</td>

                                  @foreach ($question->quiz->users as $participant)

                                    @if ($question->have_i_answered($question))
                                    <td scope="col">
                                      @foreach ($participant->question_responses($question)->sortByDesc('id') as $response)
                                      @if ($participant->question_responses($question)->sortByDesc('id')->first() == $response)Latest: @endif
                                        @if ($response->correct == "1")
                                          {{$response->answer}} <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-times"></i>
                                          </a>
                                        @else
                                        <strike>{{$response->answer}}<strike> <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fas fa-check"></i>
                                        </a>
                                        @endif
                                      </br>
                                      @endforeach
                                    </td>
                                    @else
                                      <td scope="col">Left Blank</td>
                                    @endif
                                  @endforeach
                                </tr>
                                @endif
                            @endforeach

                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
  </br>

    <div class="text-center mt--7">
        <div class="row justify-content-center">
          <a href="{{ route('quiz.finish.marking', $quiz) }}" id="next_question_btn" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
            <span id="next_question_btn_text" class="btn-inner--text">Release Scores and next question</span>
            <span class="btn-inner--icon"><i id="next_question_btn_icon" class="fa fa-hourglass-start"></i></span>
          </a>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <!-- <script>
    function fetchdata(){
     $.ajax({
      url: '{{ route('next_question_results', [($question->id + 1)]) }}?api_token={{auth()->user()->api_token}}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
       clearInterval(interval);

       $('#next_question_btn').attr('href', data.next);
       $('#next_question_btn_text').text(data.btn_text);
       $('#next_question_btn_icon').removeClass().addClass('fa fa-play');
     },

      error: function(data){
      // quiz ready, update page
       clearInterval(interval);

       $('#next_question_btn').attr('href', '#');
       $('#next_question_btn_text').text('End of quiz');
       $('#next_question_btn_icon').removeClass();
     }

     });
    }

    $(document).ready(function(){
     fetchdata();
     interval = setInterval(fetchdata,2000);
    });
    </script> -->
@endpush
