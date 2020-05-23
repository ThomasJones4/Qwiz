@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">scoreboard</h1>
                        <h1 class="text-white">results</h1>
                        <h1 class="text-white">{{ $question->content }}</h1>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">@if ($question->title == 'end-scores') End Scores @else Mid Scores @endif</h3>
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
                                @foreach ($question->quiz->users as $participant)
                                <th scope="col">{{ $participant->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_questions as $question)
                                <tr>
                                  <td>{{ $question->content }}</td>

                                  @foreach ($question->quiz->users as $participant)

                                    @if ($question->have_i_answered($question))
                                    <td scope="col">
                                      @foreach ($participant->question_responses($question) as $response)
                                        @if ($response->correct == "1")
                                          <b>{{$response->answer}}</b>
                                        @else
                                          <strike>{{$response->answer}}</strike>
                                        @endif
                                      </br>
                                      @endforeach
                                    </td>
                                    @else
                                      <td scope="col">Left Blank</td>
                                    @endif
                                  @endforeach
                                </tr>
                            @endforeach

                                  <td><b>{{ __('Total') }}</b></td>
                                  @foreach ($question->quiz->users as $participant)
                                  <th scope="col">{{ $participant->correct_so_far($quiz) }}</th>
                                  @endforeach
                                </tr>
                        </tbody>
                    </table>
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
      url: '{{ route('next_question_results', [($question->id + 1)]) }}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
       clearInterval(interval);

       $('#next_question_btn').attr('href', data.next);
       $('#next_question_btn_text').text(data.btn_text);
       $('#next_question_btn_icon').removeClass().addClass('fa fa-play');
     }
     });
    }

    $(document).ready(function(){
     fetchdata();
     interval = setInterval(fetchdata,2000);
    });
    </script>
@endpush
