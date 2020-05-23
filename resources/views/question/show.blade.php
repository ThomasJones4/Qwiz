@extends('layouts.live_quiz', ['all_questions' => $all_questions, 'question' => $question])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $question->title }}</h1>
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ $question->content }}</h1>
                    </div>
                </div>
            </div>
            <div class="text-center mt-7 mb-7">
                <div class="row justify-content-center">
                  <form action="{{ route('store.response', [$question]) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <input class="form-control form-control-lg" type="text" id="answer" name="answer">
                    </div>

                    @error('answer')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button class="btn btn-primary" type="submit">Submit</button>
                    @if ($question->have_i_answered())
                    <a href="{{ route('question.lobby', $question)}}" class="btn btn-primary" role="button" >Next</a>
                    @endif
                  </form>

                </div>

            </div>
        </div>
        <div class="text-center mt--7">
          <div class="row justify-content-center">
              <p class="text-white" id="response_count"></p>
          </div>
        </div>
    </div>


@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>
    function fetchdata(){
     $.ajax({
      url: '{{ route('response.count', [$question]) }}',
      type: 'get',
      success: function(data){
      // quiz ready, update page

       $('#response_count').text(data['count'] + '/' + data['total'] + ' responded');

             if (data['count'] == data['total']) {
               clearInterval(interval_res);
             }
     }
     });
    }

    $(document).ready(function(){
     fetchdata();
     interval = setInterval(fetchdata,1000);
    });
    </script>
@endpush
