@extends('frontend.main')

@section('content')
    <section class="bg-old-blue-sec">
        <div class="container pt-5 pb-5" style="min-height: 100vh">
            <h4 class="fw-bold text-old-blue">{{ __('localization.faqtitle') }}</h4>
            <h6 class="text-old-blue mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo
                consectetur natus aliquid delectus nisi eos nemo quas rem tempora molestias. Corporis, tempora est! Aliquam
                libero suscipit minus laboriosam voluptas? Dignissimos!</h6>
            <div class="d-flex justify-content-center mb-5">
                <ul class="nav nav-pills col-md-12" id="newsArticleTabs" role="tablist">
                    <li class="nav-item col-md-4 d-grid " role="presentation">
                        <button class="nav-link me-2 fs-6 fw-bold text-old-blue active" id="news-tab" data-bs-toggle="tab"
                            data-bs-target="#news" type="button" role="tab" aria-controls="news" aria-selected="true">
                            {{ __('localization.investor') }}
                        </button>
                    </li>
                    <li class="nav-item col-md-4 d-grid " role="presentation">
                        <button class="nav-link me-2  fs-6 fw-bold text-old-blue" id="article-tab" data-bs-toggle="tab"
                            data-bs-target="#article" type="button" role="tab" aria-controls="article"
                            aria-selected="false">{{ __('localization.publisher') }}</button>
                    </li>
                    <li class="nav-item col-md-4 d-grid " role="presentation">
                        <button class="nav-link  fs-6 fw-bold text-old-blue" id="articles-tab" data-bs-toggle="tab"
                            data-bs-target="#articles" type="button" role="tab" aria-controls="articles"
                            aria-selected="false">{{ __('localization.cost') }}</button>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="newsArticleTabContent">
                <div class="tab-pane fade show active" id="news" role="tabpanel" aria-labelledby="news-tab">
                    <div class="accordion" id="faqAccordionLeft">
                        <h4 class="text-center fw-bold">{{ __('localization.inforelateinv') }}</h4>
                        <h6 class="text-center mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis
                            corporis, fugiat nisi incidunt
                            quisquam vel? Quae repudiandae debitis praesentium corrupti! Itaque amet pariatur unde
                            consequatur quasi nobis? Similique, cumque ratione?</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- FAQ Item 1 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading1">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false"
                                            aria-controls="collapse1">
                                            {{ __('localization.faq_list.faq_1.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1"
                                        data-bs-parent="#faqAccordionLeft">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">{{ __('localization.faq_list.faq_1.content') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ Item 2 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading2">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false"
                                            aria-controls="collapse2">
                                            {{ __('localization.faq_list.faq_2.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                        data-bs-parent="#faqAccordionLeft">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">{{ __('localization.faq_list.faq_2.content') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ Item 3 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading3">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false"
                                            aria-controls="collapse3">
                                            {{ __('localization.faq_list.faq_3.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                        data-bs-parent="#faqAccordionLeft">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">{{ __('localization.faq_list.faq_3.content') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ Item 4 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading4">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false"
                                            aria-controls="collapse4">
                                            {{ __('localization.faq_list.faq_4.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                        data-bs-parent="#faqAccordionLeft">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">
                                                {!! __('localization.faq_list.faq_4.content') !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item 5 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading5">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse5"
                                            aria-expanded="false" aria-controls="collapse5">
                                            {{ __('localization.faq_list.faq_5.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                                        data-bs-parent="#faqAccordionRight">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">
                                                {{ __('localization.faq_list.faq_5.content') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- FAQ Item 6 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading6">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse6"
                                            aria-expanded="false" aria-controls="collapse6">
                                            {{ __('localization.faq_list.faq_6.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6"
                                        data-bs-parent="#faqAccordionRight">
                                        <div class="accordion-body">
                                            {!! __('localization.faq_list.faq_6.content') !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ Item 7 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading7">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse7"
                                            aria-expanded="false" aria-controls="collapse7">
                                            {{ __('localization.faq_list.faq_7.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                                        data-bs-parent="#faqAccordionRight">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">{{ __('localization.faq_list.faq_7.content') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ Item 8 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading8">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse8"
                                            aria-expanded="false" aria-controls="collapse8">
                                            {{ __('localization.faq_list.faq_8.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                                        data-bs-parent="#faqAccordionRight">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">{{ __('localization.faq_list.faq_8.content') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item 9 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading9">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse9"
                                            aria-expanded="false" aria-controls="collapse9">
                                            {{ __('localization.faq_list.faq_9.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9"
                                        data-bs-parent="#faqAccordionRight">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">{{ __('localization.faq_list.faq_9.content') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- FAQ Item 9 -->
                                <div class="accordion-item mb-3 shadow-smooth">
                                    <h2 class="accordion-header" id="heading10">
                                        <button class="accordion-button collapsed fw-semibold text-old-blue"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse10"
                                            aria-expanded="false" aria-controls="collapse10">
                                            {{ __('localization.faq_list.faq_10.title') }}
                                        </button>
                                    </h2>
                                    <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10"
                                        data-bs-parent="#faqAccordionRight">
                                        <div class="accordion-body">
                                            <p class="mb-0 text-old-blue">{{ __('localization.faq_list.faq_10.content') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="article" role="tabpanel" aria-labelledby="article-tab">
                    <h4 class="text-center fw-bold">{{ __('localization.inforelatepub') }}</h4>
                    <h6 class="text-center mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis corporis,
                        fugiat nisi incidunt
                        quisquam vel? Quae repudiandae debitis praesentium corrupti! Itaque amet pariatur unde
                        consequatur quasi nobis? Similique, cumque ratione?</h6>

                </div>
                <div class="tab-pane fade" id="articles" role="tabpanel" aria-labelledby="article-tab">
                    <h4 class="text-center fw-bold">{{ __('localization.inforelatecos') }}</h4>
                    <h6 class="text-center mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis corporis,
                        fugiat nisi incidunt
                        quisquam vel? Quae repudiandae debitis praesentium corrupti! Itaque amet pariatur unde
                        consequatur quasi nobis? Similique, cumque ratione?</h6>

                </div>
            </div>

        </div>
    </section>
@endsection
