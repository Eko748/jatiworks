@extends('buyer.layouts.main')

@section('css')
    <style>
        .scrollable-cards {
            display: flex;
            justify-content: center;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            padding: 1rem 0;
        }

        .neumorphic-card {
            box-shadow: 2px 2px 5px #b8bcc4, -2px -2px 5px #ffffff;
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
        }

        .timeline-item.completed .timeline-line {
            background: #28a745;
        }

        .timeline-item.in_progress .timeline-line {
            background: #ffc107;
        }

        .timeline-item.pending .timeline-line {
            background: #6c757d;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-line {
            position: absolute;
            width: 4px;
            background: #b9b9b9;
            top: 0;
            height: 100%;
            left: 45px;
            z-index: 1;
        }

        .timeline::after {
            content: none !important;
        }

        .timeline-item {
            position: relative;
            display: flex;
            align-items: start;
        }

        .timeline-marker {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: inset 1px 1px 2px var(--shadow-dark), inset -1px -1px 2px var(--shadow-light);
            position: relative;
            z-index: 2;
            background: white;
            border: 4px solid #ccc;
        }

        .timeline-marker i {
            transition: transform 0.3s ease-in-out;
        }

        .timeline-marker:hover i {
            transform: scale(1.2);
        }

        .timeline-marker {
            animation: fadeInScale 0.5s ease-in-out;
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 576px) {
            .timeline {
                padding-left: 15px;
            }

            .timeline-line {
                left: 10px;
            }

            .timeline-marker {
                left: -25px;
                width: 24px;
                height: 24px;
                border-width: 3px;
            }

            .timeline-item {
                flex-direction: column;
                align-items: start;
                text-align: start;
                margin-left: 10px;
            }

            .timeline-content {
                width: 100%;
                max-width: 90%;
            }
        }
    </style>
@endsection

@section('content')
    <section id="main-section" class="main-section bg-green-white">
        <div class="container pt-5 pb-5">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="heading fw-bold">{{ $order->id_katalog ? $order->katalog->item_name : $order->item_name }}
                    </h3>
                    <h6 class="subtitle h6 mb-3">Code Order : #{{ $order->code_order }}</h6>
                </div>
                <a href="{{ url()->previous() }}" type="button" id="toggleFilter" class="filter-data btn-success btn btn-md">
                    <i class="fas fa-circle-chevron-left"></i><span class="d-none d-sm-inline ms-1">Back</span>
                </a>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-7 mb-3">
                    @php
                        $imageNullUrl = asset('assets/img/public/image_null.webp');

                        if ($order->id_katalog) {
                            $storageUrl = asset('storage/uploads/katalog');
                            $files = $order->katalog->file ?? [];
                        } else {
                            $storageUrl = asset('storage/uploads/order');
                            $files = $order->file ?? [];
                        }

                        $images =
                            count($files) > 0
                                ? collect($files)->map(fn($file) => "{$storageUrl}/{$file->file_name}")->toArray()
                                : [$imageNullUrl];
                    @endphp
                    <div id="carouselContainer" class="mb-3">
                        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $image }}" class="d-block w-100 img-fluid card-radius"
                                            alt="Slide {{ $index === 0 ? 'active' : '' }}">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <h6 class="fw-bold text-old-blue">
                            <span class="badge {{ $order->status === 'PC' ? 'bg-success' : 'bg-warning' }}">
                                {{ $order->status->label() }}
                            </span>
                        </h6>
                    </div>
                    <div>
                        <h3 class="fw-bold">Description</h3>
                        <p>{{ $order->id_katalog ? $order->katalog->desc : $order->desc }}</p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="neumorphic-card p-3 mb-3 bg-green-young">
                        <h5 class="fw-bold">Order Progress</h5>
                        <hr>
                        <div class="timeline position-relative">
                            <div class="timeline-line"></div>
                            @foreach ($order->orderTracking->sortBy('trackingStep.step_order') as $index => $tracking)
                                <div class="timeline-item {{ $tracking->status }} d-flex align-items-start mb-4">
                                    <div
                                        class="timeline-marker rounded-circle me-3 d-flex align-items-center justify-content-center
        {{ $tracking->status === 'completed' ? 'bg-success' : ($tracking->status === 'in_progress' ? 'bg-primary' : 'bg-secondary') }}">
                                        <i
                                            class="fas {{ $tracking->status === 'completed' ? 'fa-check' : ($tracking->status === 'in_progress' ? 'fa-spinner fa-spin' : 'fa-hourglass-start') }} text-white"></i>
                                    </div>
                                    <div class="timeline-content neumorphic-card p-3 bg-green-white">
                                        <div class="d-flex flex-column flex-sm-row justify-content-between">
                                            <h4><i class="fas fa-step-forward me-1"></i> Step {{ $index + 1 }}:
                                                {{ $tracking->trackingStep->step_name }}</h4>
                                            <div
                                                class="d-flex flex-row flex-sm-column align-items-center align-items-sm-end gap-2 mt-2 mt-sm-0">
                                                <small
                                                    class="neumorphic-card text-white px-2 py-1
                                                        {{ $tracking->status === 'completed' ? 'bg-success' : ($tracking->status === 'in_progress' ? 'bg-primary' : 'bg-secondary') }}">
                                                    {{ ucfirst($tracking->status) }}
                                                </small>
                                                @if ($tracking->completed_at)
                                                    <small class="text-success fw-bold" style="font-size: 11px;">
                                                        {{ $tracking->completed_at->format('d M Y H:i') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($tracking->status === 'pending')
                                            <hr>
                                            <div class="neumorphic-card p-3 bg-light">
                                                <div class="d-flex align-items-center text-secondary">
                                                    <i class="fas fa-lock me-2"></i>
                                                    <p class="mb-0">Please wait, each process is done sequentially and
                                                        is
                                                        being worked on.</p>
                                                </div>
                                            </div>
                                        @elseif ($tracking->notes)
                                            <hr>
                                            <div class="neumorphic-card p-3">
                                                <span class="fw-bold">
                                                    <i class="fas fa-sticky-note me-1"></i>Note :
                                                </span>
                                                <span>{{ $tracking->notes }}</span>
                                                <hr>
                                                <span class="fw-bold">
                                                    <i class="fas fa-paperclip me-1"></i>Attachment :
                                                </span>
                                                @if ($tracking->file_name)
                                                    @php
                                                        $decodedFiles = json_decode($tracking->file_name, true);
                                                        $files = is_array($decodedFiles)
                                                            ? $decodedFiles
                                                            : [$tracking->file_name];
                                                        $filesJson = json_encode($files); // Encode array ke JSON
                                                    @endphp
                                                    <div
                                                        class="d-flex align-items-center gap-2 flex-nowrap overflow-auto ms-4">
                                                        <a href="#" class="view-image text-primary"
                                                            data-files='{{ $filesJson }}'>View Image</a>
                                                    </div>
                                                @else
                                                    @if ($tracking->status === 'completed')
                                                        <p class="mt-2 mb-2"><i class="fas fa-paperclip me-1"></i>No
                                                            attachments available.</p>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="modal fade" id="imagePreviewModal" tabindex="-1"
                                aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                            <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner"></div>
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#carouselImages" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#carouselImages" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Script Loaded!"); // Debugging

        document.querySelectorAll('.view-image').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                console.log("View Image Clicked!"); // Debugging

                const files = JSON.parse(this.getAttribute('data-files'));
                console.log("Files Data:", files); // Debugging

                const carouselInner = document.querySelector('#carouselImages .carousel-inner');
                const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));

                // Kosongkan carousel sebelum diisi ulang
                carouselInner.innerHTML = '';

                files.forEach((file, index) => {
                    const isActive = index === 0 ? 'active' : '';
                    const imageUrl =
                        `{{ asset('storage/uploads/tracking/') }}/${file}`;

                    carouselInner.innerHTML += `
                        <div class="carousel-item ${isActive}">
                            <img src="${imageUrl}" class="d-block w-100" alt="Image ${index + 1}" style="object-fit: cover; height: 400px;">
                        </div>
                    `;
                });

                // Tampilkan atau sembunyikan tombol navigasi berdasarkan jumlah gambar
                document.querySelector('.carousel-control-prev').style.display = files.length >
                    1 ? 'block' : 'none';
                document.querySelector('.carousel-control-next').style.display = files.length >
                    1 ? 'block' : 'none';

                console.log("Opening Modal..."); // Debugging
                modal.show();
            });
        });

        let carousel = new bootstrap.Carousel(document.getElementById('imageCarousel'), {
            interval: 2000,
            ride: "carousel"
        });
    });
</script>
