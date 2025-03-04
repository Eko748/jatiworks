@extends('buyer.layouts.main')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-smooth bg-old-blue-tri border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Image Carousel -->
                            <div id="orderImageCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner rounded-3">
                                    @forelse($order->files ?? [] as $index => $file)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/uploads/order/' . $file->name) }}"
                                                class="d-block w-100"
                                                alt="Order Image {{ $index + 1 }}"
                                                style="object-fit: cover; height: 400px;">
                                        </div>
                                    @empty
                                        <div class="carousel-item active">
                                            <div class="d-flex justify-content-center align-items-center bg-light" style="height: 400px;">
                                                <p class="text-muted">No images available</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                @if(isset($order->files) && count($order->files) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#orderImageCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#orderImageCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                    <div class="carousel-indicators">
                                        @foreach($order->files ?? [] as $index => $file)
                                            <button type="button"
                                                data-bs-target="#orderImageCarousel"
                                                data-bs-slide-to="{{ $index }}"
                                                class="{{ $index === 0 ? 'active' : '' }}"
                                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                                aria-label="Slide {{ $index + 1 }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-3">Order Details</h4>
                            <div class="mb-3">
                                <strong>Order Code:</strong>
                                <span>{{ $order->code_order }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Status:</strong>
                                <span class="badge {{ $order->status === 'PC' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $order->status->label() }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <strong>Created At:</strong>
                                <span>{{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Description:</strong>
                                <p class="mt-2">{{ $order->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($order->status->label() !== 'Waiting for Payment')
            <div class="card shadow-smooth bg-old-blue-tri border-0 mt-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">Order Progress</h5>
                    <div class="timeline position-relative">
                        <div class="timeline-line"></div>
                        @foreach ($order->orderTracking->sortBy('trackingStep.step_order') as $index => $tracking)
                            <div class="timeline-item {{ $tracking->status }} d-flex align-items-start mb-4">
                                <div class="timeline-marker rounded-circle me-3 d-flex align-items-center justify-content-center
                                    {{ $tracking->status === 'completed' ? 'bg-success' : ($tracking->status === 'in_progress' ? 'bg-primary' : 'bg-secondary') }}">
                                    <i class="fas {{ $tracking->status === 'completed' ? 'fa-check' : ($tracking->status === 'in_progress' ? 'fa-spinner fa-spin' : 'fa-hourglass-start') }} text-white"></i>
                                </div>
                                <div class="timeline-content p-3 bg-white rounded shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Step {{ $index + 1 }}: {{ $tracking->trackingStep->step_name }}</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge {{ $tracking->status === 'completed' ? 'bg-success' : ($tracking->status === 'in_progress' ? 'bg-primary' : 'bg-secondary') }}">
                                                {{ ucfirst($tracking->status) }}
                                            </span>
                                            @if ($tracking->completed_at)
                                                <small class="text-success" style="font-size: 0.8rem;">
                                                    {{ $tracking->completed_at->format('d M Y H:i') }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($tracking->notes)
                                        <div class="mt-2 pt-2 border-top">
                                            <small class="text-muted">Note:</small>
                                            <p class="mb-0 small">{{ $tracking->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
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
        position: relative;
        z-index: 2;
        background: white;
        border: 4px solid #ccc;
    }

    .timeline-content {
        flex: 1;
        margin-left: 15px;
    }

    @media (max-width: 576px) {
        .timeline {
            padding-left: 15px;
        }

        .timeline-line {
            left: 25px;
        }

        .timeline-marker {
            width: 24px;
            height: 24px;
            border-width: 3px;
        }
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = new bootstrap.Carousel(document.getElementById('orderImageCarousel'), {
            interval: 5000,
            wrap: true,
            touch: true
        });
    });
</script>
@endpush