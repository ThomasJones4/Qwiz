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
                <div class="row">
                  <div class="container">
                    <div class="accordion" id="accordionAnswers">
                            @foreach ($all_questions as $question)
                              @if ($question->title != "%%scores%%")
                                <div class="card">
                                    <div class="card-header" id="heading-{{$question->id}}" data-toggle="collapse" data-target="#collapse-{{$question->id}}" aria-expanded="true" aria-controls="collapse-{{$question->id}}">
                                        <h5 class="mb-0"><i class="fas fa-chevron-down"></i> {{$question->question}}</h5>
                                        @if (null != $question->correct_answer) <h5 class="mb-0">Correct Answer : {{$question->correct_answer}}</h5> @else <h5 class="mb-0"><i>No correct answer set</i></h5> @endif
                                    </div>
                                    <div id="collapse-{{$question->id}}" class="collapse @if ($loop->first) show @endif" aria-labelledby="heading-{{$question->id}}" data-parent="#accordionAnswers">
                                        <div class="card-body">

                                          <div class="table-responsive">
                                              <div>
                                              <table class="table align-items-center">
                                                  <thead class="thead-light">
                                                      <tr>
                                                          <th scope="col" class="sort" data-sort="name">Name</th>
                                                          <th scope="col" class="sort" data-sort="budget">Answers</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody class="list">
                                                    @foreach ($question->quiz->users as $participant)
                                                      <tr>
                                                          <th scope="row">
                                                              <div class="media align-items-center">
                                                                  <div class="media-body">
                                                                      <span class="name mb-0 text-sm">{{$participant->name}}</span>
                                                                  </div>
                                                              </div>
                                                          </th>
                                                          <td>
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
                                                      </tr>
                                                    @endforeach
                                                  </tbody>
                                              </table>
                                          </div>
                                        </div>
                                  </div>
                                </div>
                              </div>
                            @endif
                          @endforeach

                      </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="text-center mt--7">
        <div class="row justify-content-center">
          <a href="{{ route('quiz.finish.marking', $quiz) }}" id="next_question_btn" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
            <span id="next_question_btn_text" class="btn-inner--text">Release Scores</span>
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
