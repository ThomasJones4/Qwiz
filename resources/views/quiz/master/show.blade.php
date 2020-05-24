@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
          <div class="row">

              <div class="col">
                  <div class="card shadow">
                      <div class="card-header border-0">
                          <div class="row align-items-center">
                              <div class="col-6">
                                  <h3 class="mb-0">{{ $quiz->name }} Questions <a href="{{ route('show.join.quiz', $quiz) }}">{{ $quiz->invite_code }}</h3>
                              </div>
                              <div class="col-6 text-right">
                                <a href="{{ route('quiz.question.create', $quiz) }}" class="btn btn-sm btn-primary">{{ __('Add new Question') }}</a>
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
                                      <td>{{ $question->title }}</td>
                                      <td>{{ $question->question }}</td>

                                      <td>
                                        <a class="btn btn-sm btn-icon-only text-light" href="{{ route('questions.edit', $question) }}" role="button">
                                          <i class="fas fa-edit"></i>
                                        </a>
                                    </td>

                                    <td class="text-right">
                                      <div class="dropdown">
                                          <div class="container">
                                            <div class="row">
                                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-sort"></i>
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                          @can('move_up', $question)
                                            <div class="col-6">
                                            <a class="btn btn-sm btn-icon-only text-light" href="{{ route('question.move.up', $question) }}" role="button">
                                              <i class="fas fa-sort-up"></i>
                                            </a>
                                          </div>
                                          @endcan
                                          @can('move_down', $question)
                                          <div class="col-6">
                                            <a class="btn btn-sm btn-icon-only text-light" href="{{ route('question.move.down', $question) }}" role="button">
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
