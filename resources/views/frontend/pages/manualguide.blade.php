@extends('frontend.main')

@section('content')
    <section class="bg-old-blue-sec">
        <div class="container pt-5 pb-5" style="min-height: 100vh">
            <h4 class="fw-bold text-old-blue ">{{ __('localization.usermanual') }}</h4>
            <h6 class="text-old-blue  mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo
                consectetur natus aliquid delectus nisi eos nemo quas rem tempora molestias. Corporis, tempora est! Aliquam
                libero suscipit minus laboriosam voluptas? Dignissimos! Lorem ipsum dolor sit amet consectetur adipisicing
                elit. Molestias tempore distinctio voluptate quo? Iure, quae ullam corrupti tenetur molestiae animi, ut
                ratione dolorum repellendus doloribus consequatur quam consectetur debitis architecto!</h6>
            <div class="row align-items-center">
                <div class="col-md-6 mb-5">
                    <div class="card bg-glass mx-5">
                        <div class="card-body">
                            <h5 class="fw-bold text-old-blue text-center mb-4">{{ __('localization.register') }}</h5>
                            <input type="text" class="form-control bg-glass mb-4 rounded-3" disabled>
                            <input type="text" class="form-control bg-glass mb-4 rounded-3" disabled>
                            <input type="text" class="form-control bg-glass mb-4 rounded-3" disabled>
                            <input type="text" class="form-control bg-glass mb-4 rounded-3 w-25" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-5">
                    <h5 class="fw-bold text-old-blue">{{ __('localization.free') }}</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore, corrupti! Nemo vel dolor minima ad
                        labore eum ipsum, provident eligendi voluptates quam dicta itaque tempore sed, tenetur aspernatur
                        laboriosam voluptatem! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam atque non
                        nemo! Asperiores aperiam earum sapiente ipsum quod exercitationem obcaecati esse aspernatur labore,
                        numquam a, ex reiciendis id distinctio at!</p>
                    <a class="btn btn-old-blue px-5 py-2" href="/register">{{ __('localization.now') }}</a>
                </div>
            </div>
            <ul class="nav nav-underline border-bottom mb-5" id="newsArticleTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link fs-6 fw-bold text-old-blue active" id="news-tab" data-bs-toggle="tab"
                        data-bs-target="#news" type="button" role="tab" aria-controls="news"
                        aria-selected="true">{{ __('localization.investor') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fs-6 fw-bold text-old-blue" id="article-tab" data-bs-toggle="tab"
                        data-bs-target="#article" type="button" role="tab" aria-controls="article"
                        aria-selected="false">{{ __('localization.bussinessown') }}</button>
                </li>
            </ul>
            <div class="tab-content mb-5" id="newsArticleTabContent">
                <div class="tab-pane fade show active" id="news" role="tabpanel" aria-labelledby="news-tab">
                    <h4 class="fw-bold text-old-blue text-center">{{ __('localization.investor') }}</h4>
                    <p class="text-center mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur possimus id
                        exercitationem quia qui alias deserunt, iure error pariatur repudiandae impedit maiores nostrum
                        ratione
                        veniam? Quas ipsa facilis ad distinctio!</p>
                    <div class="timeline">
                        <div class="box left">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 1</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box right">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 2</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box left">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 3</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box right">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 3</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box left">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 4</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box right">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 5</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="article" role="tabpanel" aria-labelledby="article-tab">
                    <h4 class="fw-bold text-old-blue text-center">{{ __('localization.bussinessown') }}</h4>
                    <p class="text-center mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur possimus id
                        exercitationem quia qui alias deserunt, iure error pariatur repudiandae impedit maiores nostrum
                        ratione
                        veniam? Quas ipsa facilis ad distinctio!</p>
                    <div class="timeline">
                        <div class="box left">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 1</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box right">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 2</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box left">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 3</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box right">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 3</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box left">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 4</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                        <div class="box right">
                            <div class="content">
                                <h4 class="fw-bold">{{ __('localization.step') }} 5</h4>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate totam nulla ad,
                                    officia vero
                                    atque? Neque modi facere adipisci atque inventore dicta eius assumenda est saepe
                                    exercitationem,
                                    cum rerum beatae, quibusdam aperiam doloribus harum autem ipsa odio tenetur delectus
                                    tempora
                                    placeat quam eligendi magni. Sint, in quae rerum ad quisquam at unde commodi est
                                    deleniti
                                    consequatur, labore quod molestiae! Debitis minima, fugiat reiciendis enim ad aspernatur
                                    beatae
                                    nobis esse porro dicta impedit ex nulla placeat soluta id expedita odio molestiae
                                    pariatur
                                    optio! Ratione aut at sint fugit sequi! Itaque ut consectetur error fugit laborum alias
                                    commodi
                                    dolor voluptatem, laboriosam adipisci.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
