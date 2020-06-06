@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">Quiz Overview</h1>
                        <h2 class="text-white">{{$quiz->name}}</h1>
                        <h2 class="text-white">{{$quiz->scheduled_start}}</h1>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                          <h1 class="text-primary">Leaderboard</h1>
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

    <div class="text-center mt--7">
        <div class="row justify-content-center">
          <a href="{{ route('quizzes.create') }}" id="next_question_btn" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
            <span id="next_question_btn_text" class="btn-inner--text">Make your own quiz</span>
          </a>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

@endpush
