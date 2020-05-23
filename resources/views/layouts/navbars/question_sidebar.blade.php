<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">

            <!-- Navigation -->
            <ul class="navbar-nav">
              @foreach ($all_questions as $sidebar_question)
                <li class="nav-item">
                      @if ($sidebar_question->is_latest())
                        @if ($sidebar_question->id == $question->id)
                            <a class="nav-link" href="#">
                          <i>{{ $sidebar_question->order + 1 }}</i><i class="fas fa-dot-circle text-primary"></i><b> {{ $sidebar_question->title }}</b>
                        </a>
                        @else
                        <a class="nav-link" href="#">
                      <i>{{ $sidebar_question->order + 1 }}</i><i class="fas fa-dot-circle text-primary"></i> {{ $sidebar_question->title }}
                    </a>
                        @endif
                      @elseif ($sidebar_question->have_i_answered())

                        @if ($sidebar_question->id == $question->id)
                            <a class="nav-link" href="{{ route('question.show', $sidebar_question) }}">
                          <i>{{ $sidebar_question->order + 1 }}</i><i class="fas fa-check text-primary"></i> <b>{{ $sidebar_question->title }}</b>
                        </a>
                        @else
                        <a class="nav-link" href="{{ route('question.show', $sidebar_question) }}">
                      <i>{{ $sidebar_question->order + 1 }}</i><i class="fas fa-check text-primary"></i> {{ $sidebar_question->title }}
                    </a>
                        @endif
                      @elseif ($sidebar_question->order < $question->latest())
                      <a class="nav-link" href="{{ route('question.show', $sidebar_question) }}">
                      <i>{{ $sidebar_question->order + 1 }}</i><i class="fas fa-lock-open text-primary"></i>{{ $sidebar_question->title }}
                      </a>
                      @else
                          <a class="nav-link" href="#">
                      <i>{{ $sidebar_question->order + 1 }}</i><i class="fas fa-lock text-primary"></i> {{ $sidebar_question->title }}
                    </a>
                      @endif
                </li>
                @endforeach
            </ul>

        </div>
    </div>
</nav>
