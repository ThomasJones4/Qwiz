<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            Qwiz
        </a>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">

            <!-- Navigation -->
            <ul class="navbar-nav">
              @foreach ($all_questions as $sidebar_question)
                <li class="nav-item">
                          @if ($sidebar_question->title == "%%scores%%")
                            <a class="nav-link" @if ($master) href="{{ route('question.master', $sidebar_question) }}" @else href="{{ route('question.show', $sidebar_question) }}" @endif>
                              <i>{{ $sidebar_question->order + 1 }}</i>
                              <i class="fas fa-star text-warning"></i>
                              @if ($sidebar_question->id == $question->id) <b> @endif
                                Scores
                              @if ($sidebar_question->id == $question->id) </b> @endif
                            </a>
                          @elseif ((null != $question->latest() || $question->latest() > -1) && ($sidebar_question->order == $question->latest()) == "1")
                            @if ($sidebar_question->have_i_answered())
                              <a class="nav-link" @if ($master) href="{{ route('question.master', $sidebar_question) }}" @else href="{{ route('question.show', $sidebar_question) }}" @endif>
                                <i>{{ $sidebar_question->order + 1 }}</i>
                                <i class="fas fa-check text-primary"></i>
                                @if ($sidebar_question->id == $question->id) <b> @endif
                                  {{ $sidebar_question->title }}
                                @if ($sidebar_question->id == $question->id) </b> @endif
                              </a>
                            @else
                              <a class="nav-link" @if ($master) href="{{ route('question.master', $sidebar_question) }}" @else href="{{ route('question.show', $sidebar_question) }}" @endif>
                                <i>{{ $sidebar_question->order + 1 }}</i>
                                <i class="fas fa-dot-circle text-primary"></i>
                                @if ($sidebar_question->id == $question->id) <b> @endif
                                  {{ $sidebar_question->title }}
                                @if ($sidebar_question->id == $question->id) </b> @endif
                              </a>
                            @endif
                          @elseif (null != $question->latest() && $sidebar_question->order < $question->latest())
                            @if ($sidebar_question->have_i_answered())
                              <a class="nav-link" @if ($master) href="{{ route('question.master', $sidebar_question) }}" @else href="{{ route('question.show', $sidebar_question) }}" @endif>
                                <i>{{ $sidebar_question->order + 1 }}</i>
                                <i class="fas fa-check text-primary"></i>
                                @if ($sidebar_question->id == $question->id) <b> @endif
                                  {{ $sidebar_question->title }}
                                @if ($sidebar_question->id == $question->id) </b> @endif
                              </a>
                            @else
                              <a class="nav-link" @if ($master) href="{{ route('question.master', $sidebar_question) }}" @else href="{{ route('question.show', $sidebar_question) }}" @endif>
                                <i>{{ $sidebar_question->order + 1 }}</i>
                                <i class="fas fa-lock-open text-primary"></i>
                                @if ($sidebar_question->id == $question->id) <b> @endif
                                  {{ $sidebar_question->title }}
                                @if ($sidebar_question->id == $question->id) </b> @endif
                              </a>
                            @endif
                          @else
                            <a class="nav-link" @if ($master) href="{{ route('question.master', $sidebar_question) }}" @else href="#" @endif>
                              <i>{{ $sidebar_question->order + 1 }}</i>
                              <i class="fas fa-lock text-primary"></i>
                              @if ($sidebar_question->id == $question->id) <b> @endif
                                {{ $sidebar_question->title }}
                              @if ($sidebar_question->id == $question->id) </b> @endif
                            </a>
                          @endif
                </li>
                @endforeach
            </ul>

        </div>
    </div>
</nav>
