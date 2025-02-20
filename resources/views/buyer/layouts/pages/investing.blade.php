@extends('frontend.main')

@section('content')
    <section class="bg-old-blue-sec">
        <div class="container pt-5 pb-5">
            <h4 class="fw-bold text-old-blue ">{{ __('localization.investing') }}</h4>
            <h6 class="text-old-blue mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo
                consectetur natus aliquid delectus nisi eos nemo quas rem tempora molestias. Corporis, tempora est! Aliquam
                libero suscipit minus laboriosam voluptas? Dignissimos!</h6>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3" src="{{ asset('assets/img/cigede-group.png') }}"
                                    alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label" aria-valuenow="50"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3" src="{{ asset('assets/img/cigede-group.png') }}"
                                    alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label" aria-valuenow="50"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3" src="{{ asset('assets/img/cigede-group.png') }}"
                                    alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label" aria-valuenow="50"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 ">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Cigede Group Project</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">-
                                        Day</span></span>
                                <a href="/detail-invest"
                                    class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                  <li class="page-item"><a class="page-link text-old-blue fw-bold" href="#">{!! __('pagination.previous') !!}</a></li>
                  <li class="page-item"><a class="page-link text-old-blue fw-bold" href="#">1</a></li>
                  <li class="page-item"><a class="page-link text-old-blue fw-bold" href="#">2</a></li>
                  <li class="page-item"><a class="page-link text-old-blue fw-bold" href="#">3</a></li>
                  <li class="page-item"><a class="page-link text-old-blue fw-bold" href="#">{!! __('pagination.next') !!}</a></li>
                </ul>
              </nav>
        </div>
    </section>
@endsection
