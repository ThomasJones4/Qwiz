<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
    <div class="container px-4">

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-collapse-main">
          <!-- Collapse header -->
          <div class="navbar-collapse-header d-md-none">
              <div class="row">
                  <div class="col-6 collapse-brand">

                  </div>
                  <div class="col-6 collapse-close">
                      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                          <span></span>
                          <span></span>
                      </button>
                  </div>
              </div>
          </div><!-- User -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link nav-link-icon  d-none d-md-block" href="{{ route('show.my.quiz') }}">
                    <i class="ni ni-circle-08"></i>
                    <span class="nav-link-inner--text">{{ __('My Quizzes') }}</span>
                </a>
                <a class="nav-link nav-link-icon d-md-none" href="{{ route('show.my.quiz') }}">
                    <i class="ni ni-circle-08"></i>
                    <span class="nav-link-inner--text text-primary">{{ __('My Quizzes') }}</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="https://api.adorable.io/avatars/400/{{ auth()->user()->id }}"">
                        </span>

                        <div class="media-body ml-2 d-none d-md-block">
                            <span class="mb-0 text-sm font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="media-body ml-2 d-md-none">
                            <span class="mb-0 text-sm font-weight-bold text-primary">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="{{ route('show.my.quiz')}}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('My Stats') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
