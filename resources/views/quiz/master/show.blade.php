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
                                <a href="{{ route('quiz.question.create.score.break', $quiz) }}" class="btn btn-sm btn-primary">{{ __('Add result screen') }}</a>
                                @if ($quiz->questions->where('title', '!=', 'scores')->count() <= 0)
                                  <button type="button" class="btn btn-sm btn-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="Whoops! It looks like you've forgot to add any questions.">
                                     {{__('Start Quiz 🎉')}}
                                  </button>
                                @elseif($quiz->questions->sortBy('order')->last()->title != "scores")
                                  <button type="button" class="btn btn-sm btn-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="Whoops! The last question needs to be a results screen.">
                                     {{__('Start Quiz 🎉')}}
                                  </button>
                                @else
                                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-notification" >{{ __('Start Quiz 🎉') }}</a>
                                @endif
                              </div>
                                <!-- <button type="button" class="btn btn-block btn-warning mb-3" >Notification</button> -->
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
                                          </div>

                                      </div>

                                      <div class="modal-footer">
                                          <a href="{{ route('quiz.start', $quiz) }}" class="btn btn-white" >Yes, everyones here. Let's Go!</a>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quiz->questions->sortBy('order') as $question)
                                    <tr>
                                      <td>{{ $question->order + 1 }}</td>
                                      <td>@if ($question->title == "scores") {{ __('Scores') }} @else {{ $question->title }} @endif</td>
                                      <td>@if ($question->title == "scores") @else {{ $question->question }} @endif</td>

                                      <td>@if ($question->title == "scores")
                                        @elseif ($question->released)
                                        <button type="button" class="btn btn-sm btn-icon-only" data-container="body" data-toggle="popover" data-placement="top" data-content="Whoops! It looks like you've forgot to add any questions.">
                                           <i class="fas fa-edit"></i>
                                        </button>
                                        @else
                                        <a class="btn btn-sm btn-icon-only" href="{{ route('questions.edit', $question) }}" role="button">
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
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

@endpush
