<div class="header bg-gradient-primary pb-6 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Your Quizzes</h5>
                                    <span class="h2 font-weight-bold mb-0">{{auth()->user()->my_quizzes->count()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Quizzes your part of</h5>
                                    <span class="h2 font-weight-bold mb-0">{{auth()->user()->quizzes->count()}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              @if (auth()->user()->responses->count() > 0 && auth()->user()->quizzes->count() > 0)
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Your fastest response</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ auth()->user()->fastest_response_in_seconds() }} {{ __(' seconds')}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="col-xl-3 col-lg-6">
                      <div class="card card-stats mb-4 mb-xl-0">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col">
                                      <h5 class="card-title text-uppercase text-muted mb-0">Answer Accuracy Score</h5>
                                      <span class="h2 font-weight-bold mb-0">{{ auth()->user()->percentage_correct() * 100}} %</span>
                                  </div>
                                  <div class="col-auto">
                                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                          <i class="fas fa-percent"></i>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                @endif
            </div>
        </div>
    </div>
</div>
