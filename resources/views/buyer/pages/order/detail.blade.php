@extends('buyer.layouts.app')

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
                                    @foreach($order->files as $index => $file)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/uploads/order/' . $file->name) }}" 
                                                class="d-block w-100" 
                                                alt="Order Image {{ $index + 1 }}"
                                                style="object-fit: cover; height: 400px;">
                                        </div>
                                    @endforeach
                                </div>
                                @if(count($order->files) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#orderImageCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#orderImageCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                    <div class="carousel-indicators">
                                        @foreach($order->files as $index => $file)
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
                                <span class="badge {{ $order->status === 'completed' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($order->status) }}
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
        </div>
    </div>
</div>
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