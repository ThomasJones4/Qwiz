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
        <h3 class="mb-0">Add new question to {{ $quiz->name }}</h3>
      </div>
      <!-- Card body -->
      <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('quiz.question.store', $quiz) }}" method="POST">
              @csrf
            <div class="form-group">
              <label class="form-control-label" for="title">Question Category</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="eg. Music" value="{{ old('title') }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label" for="question">Question</label>
              <input type="text" class="form-control" id="question" name="question" value="{{ old('question') }}">
            </div>
          </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label" for="correct_answer">Correct Answer</label>
              <input type="text" class="form-control" id="correct_answer" name="correct_answer" value="{{ old('correct_answer') }}">
            </div>
          </div>
        </div>

        <div class="row">
          @if($errors->any())
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger">{{$error}}</div>
            @endforeach
          @endif
        </div>
          <button class="btn btn-primary" type="submit">Add question</button>
          <h3 >Add then edit this question to add media </h3>
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
