@extends('admin.layouts.app')

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
                left: 25px;
            }

            .timeline-marker {
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
    <div class="row">
        <div class="col-md-12">
            <div class="neumorphic-card p-3 mb-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-receipt fa-2x me-3"></i>
                    <h4 class="card-title mb-0">Order Detail - {{ $order->code_order }}</h4>
                </div>
                <a href="{{ route('admin.order.index') }}" class="btn btn-outline-dark neumorphic-button">
                    <i class="fas fa-circle-chevron-left me-1"></i>Back
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="neumorphic-card p-3 mb-3">
                <h5 class="fw-bold">Order Progress</h5>
                <hr>
                @if ($order->status->label() === 'Waiting for Payment')
                    <div class="text-center fw-bold">
                        {{ $order->status->label() }}
                    </div>
                @else
                    <div class="timeline position-relative">
                        <div class="timeline-line"></div>
                        @php
                            $hasInProgressStep = false;
                        @endphp
                        @foreach ($order->orderTracking->sortBy('trackingStep.step_order') as $index => $tracking)
                            @php
                                if ($tracking->status === 'in_progress') {
                                    $hasInProgressStep = true;
                                }
                                $isDisabled = $hasInProgressStep && $tracking->status === 'pending';
                            @endphp
                            <div class="timeline-item {{ $tracking->status }} d-flex align-items-start mb-4">
                                <div
                                    class="timeline-marker rounded-circle me-3 d-flex align-items-center justify-content-center
                                    {{ $tracking->status === 'completed' ? 'bg-success shadow-success' : ($tracking->status === 'in_progress' ? 'bg-primary shadow-primary' : 'bg-secondary') }}">
                                    <i
                                        class="fas {{ $tracking->status === 'completed' ? 'fa-check' : ($tracking->status === 'in_progress' ? 'fa-spinner fa-spin' : 'fa-hourglass-start') }} text-white"></i>
                                </div>
                                <div class="timeline-content neumorphic-card2 p-3">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between">
                                        <h6><i class="fas fa-step-forward me-1"></i> Step {{ $index + 1 }}:
                                            {{ $tracking->trackingStep->step_name }}
                                        </h6>
                                        <div
                                            class="d-flex flex-row flex-sm-column align-items-center align-items-sm-end gap-2 mt-2 mt-sm-0">
                                            <small
                                                class="neumorphic-card2 text-white px-2 py-1
                                                {{ $tracking->status === 'completed' ? 'bg-success' : ($tracking->status === 'in_progress' ? 'bg-primary' : 'bg-info') }}">
                                                {{ ucfirst($tracking->status) }}
                                            </small>
                                            @if ($tracking->completed_at)
                                                <small class="text-success fw-bold" style="font-size: 11px;">
                                                    {{ $tracking->completed_at->format('d M Y H:i') }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>

                                    @if ($tracking->notes)
                                        <p class="mt-2 mb-0"><strong><i class="fas fa-sticky-note me-1"></i>
                                                Notes:</strong>
                                            {{ $tracking->notes }}</p>
                                    @endif

                                    @if ($tracking->file_name)
                                        <p class="mt-2 mb-0 neu-text"><strong><i class="fas fa-paperclip me-1"></i>
                                                Attachment:</strong></p>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ asset('storage/uploads/tracking/' . $tracking->file_name) }}"
                                                class="img-thumbnail" style="max-width: 100px;"
                                                onclick="showFilePreview('{{ asset('storage/uploads/tracking/' . $tracking->file_name) }}')">
                                            <button class="btn btn-sm neumorphic-button"
                                                onclick="showFilePreview('{{ asset('storage/uploads/tracking/' . $tracking->file_name) }}' . $tracking->file_name) }}')">
                                                <i class="fas fa-eye me-1"></i> View Full Size
                                            </button>
                                        </div>
                                    @elseif (!$isDisabled)
                                        @if ($tracking->status === 'completed' && $tracking->notes && $tracking->file_name)
                                        @else
                                            <form action="{{ route('order.updateTracking', $tracking->id_order) }}"
                                                method="POST" enctype="multipart/form-data" class="mt-3">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_order_tracking" value="{{ $tracking->id }}">
                                                <input type="hidden" name="id_tracking_step"
                                                    value="{{ $tracking->id_tracking_step }}">
                                                <div class="row">
                                                    @if ($tracking->status !== 'completed' || !$tracking->notes)
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"><i
                                                                    class="fas fa-sticky-note me-1"></i>
                                                                Add Note (Optional)</label>
                                                            <textarea name="notes" class="form-control neumorphic-card" rows="2" placeholder="Enter note">{{ $tracking->notes }}</textarea>
                                                        </div>
                                                    @endif
                                                    @if ($tracking->status !== 'completed' || !$tracking->file_name)
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"><i class="fas fa-paperclip me-1"></i>
                                                                Upload Image</label>
                                                            <input type="file" name="file"
                                                                class="form-control neumorphic-card" accept="image/*">
                                                            <small class="neu-text ms-1">You can upload maximum 3
                                                                images</small>
                                                            <div id="imagePreviewContainer" class="ms-1 mt-3"></div>
                                                        </div>
                                                    @endif
                                                    @if ($tracking->status !== 'completed')
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"><i class="fas fa-tasks me-1"></i>
                                                                Update
                                                                Status</label>
                                                            <select name="status" class="form-select neumorphic-card">
                                                                @if ($tracking->status !== 'in_progress')
                                                                    <option value="pending"
                                                                        {{ $tracking->status === 'pending' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                @endif
                                                                <option value="in_progress"
                                                                    {{ $tracking->status === 'in_progress' ? 'selected' : '' }}>
                                                                    In Progress</option>
                                                                <option value="completed"
                                                                    {{ $tracking->status === 'completed' ? 'selected' : '' }}>
                                                                    Completed</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                    @if ($tracking->status !== 'completed' || !$tracking->notes || !$tracking->file_name)
                                                        <div class="col-md-12 mb-3 text-center text-md-end">
                                                            <button type="submit"
                                                                class="btn neumorphic-btn-success fw-bold">
                                                                <i class="fas fa-save me-1"></i> Save Changes
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                        @endif
                                    @else
                                        <div class="neumorphic-card2">
                                            <div class="alert alert-warning mt-3" role="alert">
                                                <i class="fas fa-lock me-1"></i> This step is locked. Please wait until the worker has finished the previous step.
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="neumorphic-card p-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-between">
                            <h5 class="mb-0 fw-bold">Order Information</h5>
                            <span>#Code Order: <strong
                                    class="neumorphic-card2 text-white px-2 py-1 bg-success">{{ $order->code_order }}</strong></span>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-info-circle me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Status:</span>
                                    <span
                                        class="neumorphic-card2 fw-bold text-white px-2
                                        {{ $order->status->label() === 'Not Completed'
                                            ? 'bg-warning'
                                            : ($order->status->label() === 'Waiting for Payment'
                                                ? 'bg-info'
                                                : 'bg-success') }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-cube me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Item Name:</span>
                                    <span>{{ $order->id_katalog ? $order->katalog->item_name : $order->item_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-industry me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Material:</span>
                                    <span>{{ $order->id_katalog ? $order->katalog->material : $order->material }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-ruler-combined me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Dimensions:</span>
                                    <span>
                                        L
                                        {{ $orderDetails['length'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}
                                        x W
                                        {{ $orderDetails['width'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}
                                        x H
                                        {{ $orderDetails['height'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-weight-hanging me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Weight:</span>
                                    <span>{{ $order->id_katalog ? $order->katalog->weight : $order->weight }} kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-sticky-note me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Description:</span>
                                    <span>{{ $order->id_katalog ? $order->katalog->desc : $order->desc }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="neumorphic-card p-3">
                        <h5 class="fw-bold">Buyer Information</h5>
                        <hr>
                        <div class="col-md-12">
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-user-circle me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Name:</span>
                                    <span>{{ $order->user->name }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-envelope me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Email:</span>
                                    <span>{{ $order->user->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-phone me-2 mt-1"></i>
                                <div>
                                    <span class="fw-bold d-block">Phone:</span>
                                    <span>{{ $order->user->phone ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                                <i class="fas fa-map-marker-alt me-2 mt-1"></i>
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
