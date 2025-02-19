@extends('frontend.main')
@section('content')
    <section class="bg-old-blue-tri">
        <div class="container py-5 min-vh-100">
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <img src="{{ asset('assets/img/cigede-group.png') }}" alt="" class="img-fluid rounded-4">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolorem, enim!</h2>
                    <div class="d-flex gap-4 align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="bi bi-geo-alt-fill h5 me-2"></span>
                            <h5>Bandung, Jawa Barat</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="bi bi-clock-fill h5 me-2"></span>
                            <h5>14 Days</h5>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Total Investasi</h5>
                    <div class="progress mb-5" role="progressbar" aria-label="Example with label" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-old-blue-pri" style="width: 50%">50%</div>
                    </div>
                    <div class="d-flex align-items-center gap-4 justify-content-end mb-3">
                        <h5 class="fw-bold">Target</span>
                            <h5 class="fw-bold">Rp 8.000.000.000</h5>
                    </div>
                    <div class="d-flex flex-wrap gap-4">
                        <button class="btn btn-old-blue  fw-bold flex-fill">{{ __('localization.investing') }}</button>
                        <a class="btn btn-old-blue  fw-bold flex-fill"
                            href="{{ asset('assets/pdfs/Prospektus Project Cigede Group 201224.pdf') }}" download><i
                                class="bi bi-download me-2 h4"></i>
                            Download Prospectus</a>
                        <div class="dropdown">
                            <a id="share"
                                class="btn btn-old-blue  flex-fill dropdown-toggle d-flex align-items-center justify-content-center gap-2"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-share-fill h4 m-0"></i>
                                <span class="fw-bold">Share</span>
                            </a>
                            <ul class="dropdown-menu border-0 shadow-lg rounded" style="min-width: auto;">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                        onclick="copyLink()">
                                        <i class="bi bi-clipboard"></i> Copy Link
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 text-success"
                                        href="https://wa.me/?text=Check%20this%20out!">
                                        <i class="bi bi-whatsapp"></i> WhatsApp
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 text-primary"
                                        href="https://facebook.com/sharer/sharer.php?u=example.com">
                                        <i class="bi bi-facebook"></i> Facebook
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn-old-blue fw-bold flex-fill"><i
                                class="bi bi-hand-thumbs-up-fill h4"></i></button>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills mb-5" id="newsArticleTabs" role="tablist">
                <li class="nav-item d-grid " role="presentation">
                    <button class="nav-link me-2 fs-6 fw-bold text-old-blue active" id="news-tab" data-bs-toggle="tab"
                        data-bs-target="#news" type="button" role="tab" aria-controls="news" aria-selected="true">
                        Information Details
                    </button>
                </li>
                <li class="nav-item d-grid " role="presentation">
                    <button class="nav-link me-2  fs-6 fw-bold text-old-blue" id="article-tab" data-bs-toggle="tab"
                        data-bs-target="#article" type="button" role="tab" aria-controls="article"
                        aria-selected="false">Disscussion</button>
                </li>
            </ul>
            <div class="tab-content" id="newsArticleTabContent">
                <div class="tab-pane fade show active" id="news" role="tabpanel" aria-labelledby="news-tab">
                    <h4 class="fw-bold">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, assumenda?</h4>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Et nam sint provident dolore ipsam,
                        voluptates est nemo dignissimos, quia nobis in obcaecati. Amet, minus iusto. Ad itaque
                        exercitationem eaque quasi consequuntur pariatur, nisi vitae iure qui, tenetur incidunt deserunt
                        rerum facere ipsum dolorem ullam necessitatibus? Iure, expedita odio, mollitia ipsa hic perferendis
                        alias rerum exercitationem velit voluptatibus quasi natus voluptatum eius, ad quis corporis nostrum
                        magni laudantium repudiandae animi odit nulla recusandae nam neque! Sunt eligendi laborum, tempore
                        iusto, nobis eius, reiciendis assumenda laudantium vitae illum labore autem? Reprehenderit, nihil!
                        Voluptas aliquam reiciendis culpa magni suscipit incidunt ullam accusantium rem iste dolorum
                        corrupti esse odio assumenda unde tempore fugit reprehenderit alias hic sed, sit mollitia,
                        architecto minima, voluptate dicta. Eveniet necessitatibus iure quod. Sit enim exercitationem at
                        saepe delectus, quod nulla tempora reprehenderit laboriosam explicabo fugiat ex natus quidem itaque
                        fugit dolorem, doloribus porro numquam libero ea. Omnis error, natus porro repellendus, voluptatem
                        vitae hic minima labore accusamus dolorem vel quam exercitationem est ab ea aliquid, perferendis
                        mollitia facilis magni excepturi corrupti nostrum pariatur id. Reprehenderit et distinctio doloribus
                        animi eum aliquam non quaerat quam, impedit est, hic enim earum minima aspernatur harum officiis nam
                        beatae modi perspiciatis in eveniet.
                    </p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Et nam sint provident dolore ipsam,
                        voluptates est nemo dignissimos, quia nobis in obcaecati. Amet, minus iusto. Ad itaque
                        exercitationem eaque quasi consequuntur pariatur, nisi vitae iure qui, tenetur incidunt deserunt
                        rerum facere ipsum dolorem ullam necessitatibus? Iure, expedita odio, mollitia ipsa hic perferendis
                        alias rerum exercitationem velit voluptatibus quasi natus voluptatum eius, ad quis corporis nostrum
                        magni laudantium repudiandae animi odit nulla recusandae nam neque! Sunt eligendi laborum, tempore
                        iusto, nobis eius, reiciendis assumenda laudantium vitae illum labore autem? Reprehenderit, nihil!
                        Voluptas aliquam reiciendis culpa magni suscipit incidunt ullam accusantium rem iste dolorum
                        corrupti esse odio assumenda unde tempore fugit reprehenderit alias hic sed, sit mollitia,
                        architecto minima, voluptate dicta. Eveniet necessitatibus iure quod. Sit enim exercitationem at
                        saepe delectus, quod nulla tempora reprehenderit laboriosam explicabo fugiat ex natus quidem itaque
                        fugit dolorem, doloribus porro numquam libero ea. Omnis error, natus porro repellendus, voluptatem
                        vitae hic minima labore accusamus dolorem vel quam exercitationem est ab ea aliquid, perferendis
                        mollitia facilis magni excepturi corrupti nostrum pariatur id. Reprehenderit et distinctio doloribus
                        animi eum aliquam non quaerat quam, impedit est, hic enim earum minima aspernatur harum officiis nam
                        beatae modi perspiciatis in eveniet.
                    </p>
                    <h4 class="fw-bold">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, Lorem, ipsum
                        dolor.</h4>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Temporibus voluptatem nobis obcaecati ex
                        nostrum voluptate perspiciatis dicta dignissimos nesciunt rem! Neque accusantium eius itaque ut quas
                        quaerat nihil natus possimus vitae? Id dignissimos illum illo in dolor voluptatem repudiandae beatae
                        quasi necessitatibus aut eius facere corporis magnam facilis esse ullam, voluptates maiores ratione
                        vel architecto perspiciatis. Incidunt dolore blanditiis dolorem assumenda obcaecati optio voluptas
                        recusandae atque est mollitia architecto sed iusto, et ipsum natus? Fugiat ex corporis, enim
                        deleniti natus tenetur cupiditate ipsum delectus libero, eveniet ea magnam impedit, labore maxime
                        dolorum. Amet, accusamus ea maxime ex, laborum quas sunt consectetur assumenda quod id culpa natus,
                        libero veniam quam ipsam. Perferendis quam a assumenda. Soluta perspiciatis vitae tempora,
                        architecto impedit laborum asperiores totam aperiam veritatis ut accusamus libero autem velit
                        possimus blanditiis optio, et repellat dignissimos ipsum. Accusamus, est. Unde iste impedit illum
                        quisquam, corporis at atque adipisci facere? Eum, illum! In nulla dolores, aliquid voluptatem non
                        cumque? Nesciunt minus, inventore consequatur quibusdam sed vel, ab commodi voluptate tempora aut
                        laudantium iste non ut delectus enim dolorem mollitia, est illum nihil esse? Autem eveniet quo
                        necessitatibus quam omnis saepe molestias esse culpa veniam nemo atque aut, laboriosam quod natus
                        qui eum quasi ipsa, facilis ullam facere minima illum modi! Consequatur nemo facere expedita
                        adipisci amet? Quam ea unde iure, odio vel voluptatum a quas tempore molestias ut optio facilis
                        pariatur corporis necessitatibus, minus beatae animi modi? Quod quo obcaecati et? Laborum eveniet,
                        nesciunt cupiditate quasi repellat distinctio modi voluptate repellendus.</p>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.9049997023644!2d107.61651866108505!3d-6.901963767517309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64c5e8866e5%3A0x37be7ac9d575f7ed!2sGedung%20Sate!5e0!3m2!1sid!2sid!4v1736218194414!5m2!1sid!2sid"
                        class="w-100 rounded-4" height="500" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="tab-pane fade" id="article" role="tabpanel" aria-labelledby="article-tab">
                    <form action="" class="mb-4">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label fw-bold h5">Comments</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                placeholder="Login for send comments"></textarea>
                        </div>
                        <button class="btn btn-old-blue">Send</button>
                    </form>
                    <div class="content mb-4">
                        <h5 class="fw-bold">Lorem ipsum dolor sit amet.</h5>
                        <p>1 Januari 2025, 18.00 WIB</p>
                        <h6>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus laudantium vel, praesentium
                            et, delectus sed rem iste ipsa quas sequi nesciunt dolorem eos a, ipsum maiores eaque illum
                            doloribus quam!</h6>
                        <div class="d-flex align-items-center gap-2">
                            <span class="bi bi-hand-thumbs-up-fill h4"></span>
                            <h5 class="fw-bold">5</h5>
                        </div>
                        <a class="text-decoration-none fw-bold text-old-blue fs-6" data-bs-toggle="collapse"
                            href="#collapseExample" role="button" aria-expanded="false"
                            aria-controls="collapseExample">Balas Komentar</a>
                        <div class="collapse" id="collapseExample">
                            <form action="">
                                <textarea class="form-control mt-3 mb-3" id="exampleFormControlTextarea1" rows="3"
                                    placeholder="Login for send comments"></textarea>
                                <button class="btn btn-old-blue">Send</button>
                            </form>

                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="bg-secondary" style="height: 2px; width:2rem"></div>
                            <button class="btn btn-link text-decoration-none fw-bold text-muted fs-6 toggle-replies"
                                data-replies="replies-1">Lihat Balasan</button>
                        </div>
                        <div class="replies ms-5 d-none" id="replies-1">
                            <div class="reply">
                                <div class="content mb-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold">CS Ailand.id</h5>
                                        <span class="bi bi-check-circle-fill h5"></span>
                                    </div>
                                    <p>1 Januari 2025, 18.05 WIB</p>
                                    <h6>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus laudantium vel,
                                        praesentium
                                        et, delectus sed rem iste ipsa quas sequi nesciunt dolorem eos a, ipsum maiores
                                        eaque illum
                                        doloribus quam!</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="bi bi-hand-thumbs-up-fill h4"></span>
                                        <h5 class="fw-bold">5</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Link copied to clipboard!"
                });
            });
        }
    </script>
    <script>
        document.querySelectorAll('.toggle-replies').forEach(button => {
            button.addEventListener('click', () => {
                const repliesId = button.getAttribute('data-replies');
                const repliesDiv = document.getElementById(repliesId);

                if (repliesDiv.classList.contains('d-none')) {
                    repliesDiv.classList.remove('d-none');
                    button.textContent = "Sembunyikan Balasan";
                } else {
                    repliesDiv.classList.add('d-none');
                    button.textContent = "Lihat Balasan";
                }
            });
        });
    </script>
@endsection
