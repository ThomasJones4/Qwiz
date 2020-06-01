@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pb-6 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">{{ __('Your Quizzes') }}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('quizzes.create') }}" class="btn btn-sm btn-primary">{{ __('Create New Quiz') }}</a>
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
                                <th scope="col">{{ __('Title') }}</th>
                                <th scope="col">{{ __('Scheduled Start') }}</th>
                                <th scope="col">{{ __('Invite code') }}</th>
                                <th scope="col">{{ __('Participants') }}</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Start Quiz</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if ($owned_quizzes->count() > 0)
                            @foreach ($owned_quizzes as $quiz)
                                <tr>
                                  <td>{{ $quiz->name }}</td>
                                  <td>{{ $quiz->scheduled_start }}</td>
                                  <td>
                                    @if($quiz->is_finish())
                                      {{ __('This Quiz has finished') }}
                                    @elseif ($quiz->is_live())
                                    {{ __('This Quiz has started') }}
                                    @else
                                      <a href="{{ route('show.join.quiz', $quiz) }}">{{ $quiz->invite_code }}</a>
                                    @endif
                                  </td>
                                  <td>{{ $quiz->users->count() }}</td>
                                  <td>
                                    <a class="btn btn-sm btn-icon-only " href="{{ route('quiz.master.show', $quiz) }}" role="button">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                @if($quiz->is_finish())
                                  <td>
                                    <a class="btn btn-sm " href="{{ route('quiz.overview', $quiz) }}" role="button">
                                      <i class="fas fa-play-circle"></i> See Quiz Overview
                                    </a>
                                  </td>
                                @elseif ($quiz->is_live())
                                <td>
                                  <a class="btn btn-sm " href="{{ route('question.master', $quiz->latest_unreleased()) }}" role="button">
                                    <i class="fas fa-play-circle"></i> Contunue With Live Quiz
                                  </a>
                                </td>
                                @else
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
                              <td>
                                <a class="btn btn-sm " href="#" data-toggle="modal" data-target="#modal-notification" role="button">
                                  <i class="fas fa-play-circle"></i> {{ __('Start Quiz 🎉') }}
                                </a>
                              </td>
                                @endif
                                </tr>
                                @endforeach
                              @else
                              <tr>

                                  <td>
                                <p>You haven't made any quizzes yet {{__('😢')}}</p>
                              </td>
                              </tr>
                              @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="my-4" />
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">{{ __('Quizzes Your Part Of') }}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <span>{{ __('Click someones link to join their quiz') }}</span>
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
                                <th scope="col">{{ __('Title') }}</th>
                                <th scope="col">{{ __('Scheduled Start') }}</th>
                                <th scope="col">{{ __('Participants') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                          @if ($participant_quizzes->count() > 0)
                            @foreach ($participant_quizzes as $quiz)
                                <tr>
                                  <td>{{ $quiz->name }}</td>
                                  <td>{{ $quiz->scheduled_start }}</td>
                                  <td>{{ __('x') }}</td>
                                  <td>
                                  @if ($quiz->is_live())
                                    <a class="btn btn-sm btn-icon-only" href="{{ route('quiz.show' , $quiz)}}" role="button">
                                      <i class="fas fa-play"></i>
                                    </a>
                                    @else
                                    <a class="btn btn-sm btn-icon-only " href="{{ route('quiz.overview' , $quiz)}}" role="button">
                                      <i class="fas fa-play"></i> See Quiz Overview
                                    </a>
                                  @endif
                                </td>
                                </tr>
                                @endforeach

                              @else
                              <tr>
                                <td>
                                  <p>You haven't joined any quizzes yet {{__('😢')}}</p>
                                </td>
                              </tr>
                              @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
 <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
 <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
