@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
          <div class="row">

              <div class="col">
                  <div class="card shadow">
                      <div class="card-header border-0">
                          <div class="row align-items-center">
                              <div class="col-3">
                                  <h3 class="mb-0">{{ $quiz->name }} Questions <a href="{{ route('show.join.quiz', $quiz) }}">{{ $quiz->invite_code }}</h3>
                                  <input type="hidden" dusk="invite_code" value="{{ $quiz->invite_code }}">
                                  <input type="hidden" dusk="quiz_id" value="{{ $quiz->id }}">
                              </div>
                              <div class="col-9 text-right">
                                <a href="{{ route('quiz.question.create', $quiz) }}" class="btn btn-sm btn-primary">{{ __('Add new Question') }}</a>
                                <a href="#" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#modal-random">{{ __('Add new Random Question') }}</a>
                                <a href="{{ route('quiz.question.create.score.break', $quiz) }}" class="btn btn-sm btn-primary">{{ __('Add result screen') }}</a>
                                @if ($quiz->questions->where('title', '!=', '%%scores%%')->count() <= 0)
                                  <button type="button" class="btn btn-sm btn-primary" dusk="start-button" data-container="body" data-toggle="popover" data-placement="top" data-content="Whoops! It looks like you've forgot to add any questions.">
                                     {{__('Start Quiz 🎉')}}
                                  </button>
                                @elseif($quiz->questions->sortBy('order')->last()->title != "%%scores%%")
                                  <button type="button" class="btn btn-sm btn-primary" dusk="start-button" data-container="body" data-toggle="popover" data-placement="top" data-content="Whoops! The last question needs to be a results screen.">
                                     {{__('Start Quiz 🎉')}}
                                  </button>
                                @elseif(!$quiz->conforms_to_scores_screen_rules())
                                  <button type="button" class="btn btn-sm btn-primary" dusk="start-button" data-container="body" data-toggle="popover" data-placement="top" data-content="Whoops! You can't have consecutive results screens">
                                     {{__('Start Quiz 🎉')}}
                                  </button>
                                @elseif ($quiz->is_live())
                                  <a href="{{ route('question.master', $quiz->questions()->get()->where('released')->sortBy('order')->last()->id) }}" class="btn btn-sm btn-primary" dusk="start-button" data-toggle="modal" data-target="#modal-notification" >{{ __('Resume') }}</a>
                                @else
                                  <a href="#" class="btn btn-sm btn-primary" dusk="start-button" data-toggle="modal" data-target="#modal-notification" >{{ __('Start Quiz 🎉') }}</a>
                                @endif
                              </div>
                                <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                              <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                  <div class="modal-content bg-gradient-danger">

                                      <div class="modal-header">
                                          <h6 class="modal-title" id="modal-title-notification">Your about to start the quiz</h6>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">×</span>
                                          </button>
                                      </div>

                                      <div class="modal-body">

                                          <div class="py-3 text-center">
                                              <i class="fa fa-users fa-3x"></i>
                                              <h4 class="heading mt-4">Is everybody ready?</h4>
                                              <p>Ensure everyone has joined the quiz before starting</p>
                                              <h2 class="text-white" id="joined_players">Waiting for players</h2>
                                          </div>

                                      </div>

                                      <div class="modal-footer">
                                          <a href="{{ route('quiz.start', $quiz) }}" dusk="modal-start-button" class="btn btn-white" >Yes, everyones here. Let's Go!</a>
                                          <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Wait</button>
                                      </div>

                                  </div>
                              </div>

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
                                    <th scope="col">{{ __('#') }}</th>
                                    <th scope="col">{{ __('Category') }}</th>
                                    <th scope="col">{{ __('Question') }}</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quiz->questions->sortBy('order') as $question)
                                    <tr>
                                      <td>{{ $question->order + 1 }}</td>
                                      <td>@if ($question->title == "%%scores%%") {{ __('Scores') }} @else {{ $question->title }} @endif</td>
                                      <td>
                                        @if ($question->title != "%%scores%%") {{ html_entity_decode(htmlspecialchars_decode($question->question)) }} @endif
                                        @if (null != $question->possible_answers) <br> <i>Possible Answers: {{ str_replace($question->correct_answer, "(".$question->correct_answer. " ✔️)",$question->possible_answers) }} </i> @endif
                                      </td>

                                      <td>@if ($question->title == "%%scores%%")
                                        @elseif ($question->released)
                                        <button type="button" class="btn btn-sm btn-icon-only text-light" dusk="disabled-edit" data-container="body" data-toggle="popover" data-placement="top" data-content="Whoops! This question has already been released">
                                           <i class="fas fa-edit"></i>
                                        </button>
                                        @else
                                        <a class="btn btn-sm btn-icon-only" dusk="question-edit" href="{{ route('questions.edit', $question) }}" role="button">
                                          <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                      <div class="dropdown">
                                          <div class="container">
                                            <div class="row">
                                          <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-sort"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                          @can('move_up', $question)
                                            <div class="col-6">
                                            <a class="btn btn-sm btn-icon-only" href="{{ route('question.move.up', $question) }}" role="button">
                                              <i class="fas fa-sort-up"></i>
                                            </a>
                                          </div>
                                          @endcan
                                          @can('move_down', $question)
                                          <div class="col-6">
                                            <a class="btn btn-sm btn-icon-only" href="{{ route('question.move.down', $question) }}" role="button">
                                              <i class="fas fa-sort-down"></i>
                                            </a>
                                          </div>
                                          @endcan
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                    </td>
                                    <td class="text-right">
                                      @can('delete', $question)
                                      <div class="dropdown">
                                          <div class="container">
                                            <div class="row">
                                          <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-trash"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class=" text-danger" href="{{ route('question.destroy', $question) }}" role="button">
                                              Delete Question
                                            </a>
                                        </div>
                                      </div>
                                      </div>
                                      </div>
                                      @endcan
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

    <div class="text-center mt--7">

    </div>

    <div class="modal fade" id="modal-random" tabindex="-1" role="dialog" aria-labelledby="modal-random" aria-hidden="true">
  <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-body p-0">
            <div class="card bg-secondary border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <small>Add a randomly genarated question</small>
                    </div>
                    <form action="{{ route('quiz.question.store.random', $quiz) }}" method="POST">
                      @csrf
                      <div class="form-group mb-3">
                          <div class="form-group">
                            <label for="amount">Number of Questions</label>
                            <input class="form-control" type="number" value="1" id="amount" name="amount">
                          </div>
                      </div>
                        <div class="form-group">
                              <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" class="form-control">
                                     <option value="any">Any Category</option>
                                        <option value="9">General Knowledge</option>
                                        <option value="10">Entertainment: Books</option>
                                        <option value="11">Entertainment: Film</option>
                                        <option value="12">Entertainment: Music</option>
                                        <option value="13">Entertainment: Musicals &amp; Theatres</option>
                                        <option value="14">Entertainment: Television</option>
                                        <option value="15">Entertainment: Video Games</option>
                                        <option value="16">Entertainment: Board Games</option>
                                        <option value="17">Science &amp; Nature</option>
                                        <option value="18">Science: Computers</option>
                                        <option value="19">Science: Mathematics</option>
                                        <option value="20">Mythology</option>
                                        <option value="21">Sports</option>
                                        <option value="22">Geography</option>
                                        <option value="23">History</option>
                                        <option value="24">Politics</option>
                                        <option value="25">Art</option>
                                        <option value="26">Celebrities</option>
                                        <option value="27">Animals</option>
                                        <option value="28">Vehicles</option>
                                        <option value="29">Entertainment: Comics</option>
                                        <option value="30">Science: Gadgets</option>
                                        <option value="31">Entertainment: Japanese Anime &amp; Manga</option>
                                        <option value="32">Entertainment: Cartoon &amp; Animations</option>
                                  </select>
                              </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                              <label for="difficulty">Difficulty</label>
                                <select name="difficulty" class="form-control">
                                   <option value="any">Any Difficulty</option>
                                   <option value="easy">Easy</option>
                                   <option value="medium">Medium</option>
                                   <option value="hard">Hard</option>
                                 </select>
                          </div>
                        </div>
                        @if($errors->any())
                          @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                          @endforeach
                        @endif
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4">Add to Quiz</button>
                        </div>
                    </form>
                </div>
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
    function fetchdata_users(){
     $.ajax({
      url: '{{ route('quiz.player.get', [$quiz]) }}?api_token={{auth()->user()->api_token}}',
      type: 'get',
      success: function(data){
      // quiz ready, update page
      var players = "Currently joined: "
        $.each(data.players, function(key, value) {
          players = players + value + ", "
        })
        $('#joined_players').text(players + "...");
      }
     });
    }

    $(document).ready(function(){
     fetchdata_users();
     interval = setInterval(fetchdata_users,2000);
    });


    </script>

@endpush
