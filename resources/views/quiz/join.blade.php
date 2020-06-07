@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $quiz->name }}</h1>
                        <h3 class="text-white">Quiz Master: {{ $quiz->quiz_master->name }}</h3>
                        @can('view', $quiz)
                          <h3 class="text-white"><a class="text-white" href="{!! route('show.join.quiz.emoji', $quiz) !!}" >{!! urldecode(route('show.join.quiz.emoji', $quiz)) !!}</a></h3>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">

              <div class="text-center mt-7 mb-7">
                  <div class="row justify-content-center">
                      <div class="col-lg-5 col-md-6">
                          <h2 class="text-white" id="joined_players">Waiting for players</h2>
                      </div>
                  </div>
              </div>
                <div class="row justify-content-center">
                  <form action="{{ route('join.quiz', [$quiz]) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-control-label text-white" for="invite_code">Invite Code</label>
                        @can('view', $quiz)
                          <input class="form-control form-control-lg" type="text" style="text-align:center;" value="{{ $quiz->invite_code }}" id="invite_code" name="invite_code">
                        @else
                          <input class="form-control form-control-lg" type="text" placeholder="00000000" id="invite_code" name="invite_code">
                        @endcan
                    </div>

                    @error('invite_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror


                    @cannot('view_master', $quiz)
                      <button class="btn btn-primary" type="submit">Join</button>
                    @endcan
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
      <script>
      function fetchdata_users(){
       $.ajax({
        url: '{{ route('quiz.player.get', [$quiz]) }}?api_token={{auth()->user()->api_token}}',
        type: 'get',
        success: function(data){
        // quiz ready, update page
        var players = "Players: "
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
