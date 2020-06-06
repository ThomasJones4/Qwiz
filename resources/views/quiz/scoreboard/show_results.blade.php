@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary py-7 py-lg-8">
    <div class="container">
        <div class="header-body text-center mt-7 mb-7">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">Results</h1>
                    <h2 class="text-white">{{$quiz->name}}</h1>
                </div>
            </div>
        </div>
        <div class="card shadow">


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
                <div class="table-responsive">
                    <div>
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">#</th>
                                <th scope="col" class="sort" data-sort="name">Name</th>
                                <th scope="col" class="sort" data-sort="budget">Answers</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                          @foreach ($quiz->ranked_users() as $participant)
                            <tr>
                              <th>
                                @if ($participant->rank == 1)
                                  <i style="font-size: 3em; color: Gold;" class="fas fa-trophy text-center"></i>
                                @elseif ($participant->rank == 2)
                                  <i style="font-size: 2em; color: Silver;" class="fas fa-trophy text-center"></i>
                                @elseif ($participant->rank == 3)
                                  <i style="font-size: 1em; color: #cd7f32;" class="fas fa-trophy text-center"></i>
                                @elseif ($participant->rank == -2)
                                  snd to last
                                @else

                                @endif
                              </th>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{$participant->name}}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                  {{$participant->total}}
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

    </div>
</div>


<div class="header bg-gradient-primary pb-9 pt-1">
    <div class="container">
        <div class="header-body text-center mt-2 mb-3">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">Answers</h1>
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
                                    <h5 class="mb-0"><i class="fas fa-chevron-down"></i> {{html_entity_decode(htmlspecialchars_decode($question->question))}}</h5>
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
                                                              <span id="response-{{$response->id}}" class="text-success">{{$response->answer}}</span>
                                                            @else
                                                              <span id="response-{{$response->id}}" class="text-danger">{{$response->answer}}</span>
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
          <a href="#" id="next_question_btn" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
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
      url: '{{ route('next_question_results', [($question->id)]) }}?api_token={{auth()->user()->api_token}}',
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
        if (data.responseJSON.type == "end_of_quiz") {
          clearInterval(interval);
        }

          $('#next_question_btn').attr('href', data.responseJSON.next);
          $('#next_question_btn_text').text(data.responseJSON.btn_text);
          $('#next_question_btn_icon').removeClass();
       
     }

     });
    }

    $(document).ready(function(){
     fetchdata();
     interval = setInterval(fetchdata,2000);
    });
    </script>
@endpush
