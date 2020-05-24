@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
          <div class="container-fluid mt--6">

<div class="card mb-4">
      <!-- Card header -->
      <div class="card-header">
        <h3 class="mb-0">Edit Question</h3>
      </div>
      <!-- Card body -->
      <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('questions.update', $question) }}" method="POST">
              @csrf
              @method('PUT')
            <div class="form-group">
              <label class="form-control-label" for="title">Question Category</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ $question->title ?? '' }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label" for="question">Question</label>
              <input type="text" class="form-control" id="question" name="question" value="{{ $question->question ?? '' }}">
            </div>
          </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label" for="correct_answer">Correct Answer</label>
              <input type="text" class="form-control" id="correct_answer" name="correct_answer" value="{{ $question->correct_answer ?? '' }}">
            </div>
          </div>

                  <div class="row">
                    @if($errors->any())
                      @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                      @endforeach
                    @endif
                  </div>
                    <button class="btn btn-primary" type="submit">Update question</button>

        </div>
        <div class="row">

            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="mb-0">Media</h3>
                            </div>
                            <div class="col-6 text-right">
                              <a href="{{ route('media.create', $question) }}" class="btn btn-sm btn-primary">{{ __('Add Media') }}</a>
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
                                  <th scope="col">{{ __('Media') }}</th>
                                  <th scope="col"></th>
                                  <th scope="col"></th>
                              </tr>
                          </thead>
                          <tbody>
                            @php $count = 0 @endphp
                            @foreach($question->media as $media)
                            @php $count++ @endphp

                                  <tr>
                                    <td>{{$count}}</td>
                                    <td>
                                        @if ($media->type == 'image')
                                          <img max-width="20%" height="auto" src="{{ asset('quiz-media') . '/' .$media->url}}">
                                        @elseif ($media->type == 'video')
                                          <video width="400" controls>
                                            <source src="{{ asset('quiz-media') . '/' .$media->url}}" type="video/{{$media->extension}}">
                                            Your browser does not support HTML video.
                                          </video>
                                        @elseif ($media->type == 'audio')
                                        <audio controls>
                                          <source src="{{ asset('quiz-media') . '/' .$media->url}}" type="audio/mp3">
                                          Your browser does not support the audio element.
                                        </audio>
                                        @endif
                                    </td>

                                    <td>
                                      <a class="btn btn-sm btn-icon-only text-light" href="{{ route('media.delete', compact('media', 'question')) }}" role="button">
                                        <i class="fas fa-trash"></i>
                                      </a>
                                  </td>

                                  <td class="text-right">
                                    <div class="dropdown">

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


        </form>
      </div>
    </div>
    </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
