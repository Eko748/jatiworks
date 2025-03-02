@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('css')
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-line {
            width: 4px;
            background: #ccc;
            height: 100%;
            left: 15px;
        }

        .timeline-marker {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: inset 1px 1px 2px var(--shadow-dark), inset -1px -1px 2px var(--shadow-light);
        }

        .timeline-content {
            border-radius: 12px;
            box-shadow: 6px 6px 12px #b8b8b8, -6px -6px 12px #ffffff;
        }
    </style>
@endsection

@section('back_button')
    <a href="{{ route('admin.custom.index') }}" class="btn btn-outline-dark neumorphic-button" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Back to {{ $title }} page" onclick="hideTooltip(this)">
        <i class="fas fa-circle-chevron-left"></i><span class="d-none d-sm-inline ms-1">Back</span>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="neumorphic-card p-3 mb-3">
                <h5 class="fw-bold">Design Progress : {{ $customDesign->item_name }}</h5>
                <hr>
                <div class="timeline position-relative">
                    <div class="timeline-line"></div>
                    <div class="timeline-container">
                        @foreach($designTracking as $tracking)
                            <div class="timeline-item mb-4 {{ $tracking->status }}">
                                <div class="d-flex align-items-start">
                                    <div class="timeline-marker me-3 {{ $tracking->status == 'completed' ? 'bg-success' : ($tracking->status == 'in_progress' ? 'bg-warning' : 'bg-secondary') }}">
                                        <i class="fas {{ $tracking->status == 'completed' ? 'fa-check' : ($tracking->status == 'in_progress' ? 'fa-clock' : 'fa-hourglass') }} text-white"></i>
                                    </div>
                                    <div class="timeline-content p-3 flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="fw-bold mb-1">{{ $tracking->trackingStepdesign->step_name }}</h6>
                                            <span class="badge {{ $tracking->status == 'completed' ? 'bg-success' : ($tracking->status == 'in_progress' ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ ucfirst($tracking->status) }}
                                            </span>
                                        </div>
                                        @if($tracking->notes)
                                            <p class="mb-0 mt-2">{{ $tracking->notes }}</p>
                                        @endif
                                        <small class="text-muted">{{ $tracking->updated_at->format('d M Y H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12 mb-3">
                <div class="neumorphic-card p-3">
                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                        <h5 class="mb-0 fw-bold">Design Information</h5>
                        <span>#Code Design: <strong class="neumorphic-card2 text-white px-2 py-1 bg-success">{{ $customDesign->code_design }}</strong></span>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user me-2"></i>
                                <div>
                                    <span class="fw-bold d-block">Customer Name:</span>
                                    <span>{{ $customDesign->user->name }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-envelope me-2"></i>
                                <div>
                                    <span class="fw-bold d-block">Email:</span>
                                    <span>{{ $customDesign->user->email }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-phone me-2"></i>
                                <div>
                                    <span class="fw-bold d-block">Phone:</span>
                                    <span>{{ $customDesign->user->phone }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <div>
                                    <span class="fw-bold d-block">Address:</span>
                                    <span>{{ $customDesign->user->address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
