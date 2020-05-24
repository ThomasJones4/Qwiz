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
        <h3 class="mb-0">Add media to {{ $question }}</h3>
      </div>
      <!-- Card body -->
      <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('media.store', $id) }}" method="POST" enctype="multipart/form-data">
              @csrf
            <div class="form-group">
              <label class="form-control-label" for="file">Add new Media</label>
              <input type="file" class="form-control" id="file" name="file" value="{{ old('file') }}">
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
          <button class="btn btn-primary" type="submit">Upload</button>
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
