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
                            @if ($question->title != "scores")
                                <tr>
                                  <td>{{ $question->question }}</td>

                                  @foreach ($question->quiz->users as $participant)

                                    @if ($question->have_i_answered($question))
                                    <td scope="col">
                                      @foreach ($participant->question_responses($question)->sortByDesc('id') as $response)
                                      @if ($participant->question_responses($question)->sortByDesc('id')->first() == $response)Latest:
                                        @if ($response->correct == "1")
                                          <span id="response-{{$response->id}}" class="text-success">{{$response->answer}}</span> <a class="btn btn-sm btn-icon-only text-light response-toggle" id="{{$response->id}}" role="button" >
                                            <i id="response-toggle-{{$response->id}}" class="fas fa-times"></i>
                                          </a>
                                        @else
                                        <span id="response-{{$response->id}}" class="text-danger">{{$response->answer}}</span> <a class="btn btn-sm btn-icon-only text-light response-toggle" id="{{$response->id}}" role="button">
                                          <i  id="response-toggle-{{$response->id}}" class="fas fa-check"></i>
                                        </a>
                                        @endif
                                      @else
                                        <strike>{{$response->answer}}<strike>
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
    <script>
      $('.response-toggle').click(function(){

          var response_id = $(this).attr('id');

          $.ajax({
           url: '../../api/responses/'+response_id+'/toggle?api_token={{auth()->user()->api_token}}',
           type: 'get',
           success: function(data){
           // quiz ready, update page
            if ($('#response-toggle-'+response_id).hasClass('fa-times')) {
              $('#response-toggle-'+response_id).removeClass('fa-times').addClass('fa-check');
              $('#response-'+response_id).removeClass('text-success').addClass('text-danger');
            } else {
              $('#response-toggle-'+response_id).removeClass('fa-check').addClass('fa-times');
              $('#response-'+response_id).removeClass('text-danger').addClass('text-success');
            }

          }
          });
      });
    </script>
@endpush
