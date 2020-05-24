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
        <h3 class="mb-0">Create a new quiz</h3>
      </div>
      <!-- Card body -->
      <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('quizzes.store') }}" method="POST">
              @csrf
            <div class="form-group">
              <label class="form-control-label" for="name">Quiz Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Quiz Name">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label" for="scheduled_start">Scheduled Start</label>
              <input type="date" class="form-control" id="scheduled_start" name="scheduled_start" placeholder="">
            </div>
          </div>
        </div>

        <div class="row">
          @error('scheduled_start')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          @error('name')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>
          <button class="btn btn-primary" type="submit">Create Quiz</button>
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
