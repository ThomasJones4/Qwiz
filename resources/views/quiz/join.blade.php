@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $quiz->name }}</h1>
                        <h3 class="text-white">{{ $quiz->quiz_master->name }}</h3>
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                  <form action="{{ route('join.quiz', [$quiz]) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-control-label text-white" for="invite_code">Invite Code</label>
                        <input class="form-control form-control-lg" type="text" placeholder="00000000" id="invite_code" name="invite_code">
                    </div>

                    @error('invite_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button class="btn btn-primary" type="submit">Join</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

@endpush
