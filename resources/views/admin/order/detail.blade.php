@extends('admin.layouts.app')

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

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="neumorphic-card p-3 mb-3 d-flex align-items-center">
                <i class="fas fa-receipt fa-2x me-3"></i>
                <h4 class="card-title mb-0">Order Detail - {{ $order->code_order }}</h4>
            </div>

            <div class="neumorphic-card p-3 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <h5><i class="fas fa-box me-1"></i> Order Information</h5>
                            <hr>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-hashtag fa-lg me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Code Order:</span>
                                        <span>{{ $order->code_order }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Status:</span>
                                        <span>{{ $order->status->label() }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-cube me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Item Name:</span>
                                        <span>{{ $order->id_katalog ? $order->katalog->item_name : $order->item_name }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-industry me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Material:</span>
                                        <span>{{ $order->id_katalog ? $order->katalog->material : $order->material }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-ruler-combined me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Dimensions:</span>
                                        <span>L
                                            {{ $orderDetails['length'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}
                                            x W
                                            {{ $orderDetails['width'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}
                                            x
                                            H
                                            {{ $orderDetails['height'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-weight-hanging me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Weight:</span>
                                        <span>{{ $order->id_katalog ? $order->katalog->weight : $order->weight }}kg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-sticky-note me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Description:</span>
                                        <span>{{ $order->id_katalog ? $order->katalog->desc : $order->desc }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">
                            <h5><i class="fas fa-user me-2"></i> Buyer Information</h5>
                            <hr>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-user-circle me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Name:</span>
                                        <span>{{ $order->user->name }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Email:</span>
                                        <span>{{ $order->user->email }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Phone:</span>
                                        <span>{{ $order->user->phone ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <div>
                                        <span class="fw-bold d-block">Address:</span>
                                        <span>{{ $order->user->address ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="neumorphic-card p-3">
                <h5><i class="fas fa-tasks me-2"></i> Order Progress</h5>
                <hr>
                @if ($order->status->label() === 'Waiting for Payment')
                    <div class="text-center fw-bold">
                        {{ $order->status->label() }}
                    </div>
                @else
                    <div class="timeline position-relative">
                        @foreach ($order->orderTracking->sortBy('trackingStep.step_order') as $index => $tracking)
                            <div class="timeline-item d-flex align-items-start mb-4">
                                <div
                                    class="timeline-marker rounded-circle me-3 d-flex align-items-center justify-content-center
                                        {{ $tracking->status === 'completed' ? 'bg-success shadow-success' : ($tracking->status === 'in_progress' ? 'bg-primary shadow-primary' : 'bg-secondary') }}">
                                    <i
                                        class="fas {{ $tracking->status === 'completed' ? 'fa-check' : ($tracking->status === 'in_progress' ? 'fa-spinner fa-spin' : 'fa-hourglass-start') }} text-white"></i>
                                </div>
                                <div class="timeline-content neumorphic-card p-3">
                                    <h6 class="mb-2"><i class="fas fa-step-forward me-1"></i> Step {{ $index + 1 }}:
                                        {{ $tracking->trackingStep->step_name }}</h6>
                                    <small class="d-block">
                                        <i class="fas fa-info-circle me-1"></i> Status: <span
                                            class="neumorphic-card px-2 py-1 {{ $tracking->status === 'completed' ? 'bg-success' : ($tracking->status === 'in_progress' ? 'bg-primary' : 'bg-info') }}"">{{ ucfirst($tracking->status) }}</span>
                                    </small>
                                    @if ($tracking->completed_at)
                                        <small class="text-muted d-block mt-1"><i class="fas fa-calendar-check me-1"></i>
                                            Completed:
                                            {{ $tracking->completed_at->format('d M Y H:i') }}</small>
                                    @endif

                                    @if ($tracking->notes)
                                        <p class="mt-2 mb-0 text-muted"><strong><i class="fas fa-sticky-note me-1"></i>
                                                Notes:</strong>
                                            {{ $tracking->notes }}</p>
                                    @endif

                                    @if ($tracking->file_name)
                                        <p class="mt-2 mb-0 text-muted"><strong><i class="fas fa-paperclip me-1"></i>
                                                Attachment:</strong></p>
                                        <button class="btn btn-sm neumorphic-button mt-2"
                                            onclick="showFilePreview('{{ asset('storage/uploads/order/' . $tracking->file_name) }}')">
                                            <i class="fas fa-file me-1"></i> View File
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function showFilePreview(fileUrl) {
            document.getElementById('previewImage').src = fileUrl;
            var modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            modal.show();
        }

        function handleViewTimiline() {
            const timelineContents = document.querySelectorAll(".timeline-content");

            if (timelineContents.length > 0) {
                let maxWidth = 0;

                timelineContents.forEach(el => {
                    let width = el.offsetWidth;
                    if (width > maxWidth) {
                        maxWidth = width;
                    }
                });

                timelineContents.forEach(el => {
                    el.style.width = maxWidth + "px";
                });
            }
        }

        async function initPageLoad() {
            await handleViewTimiline();
        }
    </script>
@endsection
