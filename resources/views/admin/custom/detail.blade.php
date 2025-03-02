@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('script')
    <script>
        function showFilePreview(fileUrl) {
            const previewModal = document.createElement('div');
            previewModal.style.position = 'fixed';
            previewModal.style.top = '0';
            previewModal.style.left = '0';
            previewModal.style.width = '100%';
            previewModal.style.height = '100%';
            previewModal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            previewModal.style.display = 'flex';
            previewModal.style.alignItems = 'center';
            previewModal.style.justifyContent = 'center';
            previewModal.style.zIndex = '9999';

            const image = document.createElement('img');
            image.src = fileUrl;
            image.style.maxWidth = '90%';
            image.style.maxHeight = '90%';
            image.style.borderRadius = '10px';
            image.style.boxShadow = '0px 0px 10px rgba(255, 255, 255, 0.5)';

            previewModal.onclick = function() {
                document.body.removeChild(previewModal);
            };

            previewModal.appendChild(image);
            document.body.appendChild(previewModal);
        }
    </script>
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

@section('script')
    <script>
        function showFilePreview(fileUrl) {
            const previewModal = document.createElement('div');
            previewModal.style.position = 'fixed';
            previewModal.style.top = '0';
            previewModal.style.left = '0';
            previewModal.style.width = '100%';
            previewModal.style.height = '100%';
            previewModal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            previewModal.style.display = 'flex';
            previewModal.style.alignItems = 'center';
            previewModal.style.justifyContent = 'center';
            previewModal.style.zIndex = '9999';

            const image = document.createElement('img');
            image.src = fileUrl;
            image.style.maxWidth = '90%';
            image.style.maxHeight = '90%';
            image.style.borderRadius = '10px';
            image.style.boxShadow = '0px 0px 10px rgba(255, 255, 255, 0.5)';

            previewModal.onclick = function() {
                document.body.removeChild(previewModal);
            };

            previewModal.appendChild(image);
            document.body.appendChild(previewModal);
        }
    </script>
@endsection

@section('back_button')
    <a href="{{ route('admin.custom.index') }}" class="btn btn-outline-dark neumorphic-button" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Back to {{ $title }} page" onclick="hideTooltip(this)">
        <i class="fas fa-circle-chevron-left"></i><span class="d-none d-sm-inline ms-1">Back</span>
    </a>
@endsection

@section('script')
    <script>
        function showFilePreview(fileUrl) {
            const previewModal = document.createElement('div');
            previewModal.style.position = 'fixed';
            previewModal.style.top = '0';
            previewModal.style.left = '0';
            previewModal.style.width = '100%';
            previewModal.style.height = '100%';
            previewModal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            previewModal.style.display = 'flex';
            previewModal.style.alignItems = 'center';
            previewModal.style.justifyContent = 'center';
            previewModal.style.zIndex = '9999';

            const image = document.createElement('img');
            image.src = fileUrl;
            image.style.maxWidth = '90%';
            image.style.maxHeight = '90%';
            image.style.borderRadius = '10px';
            image.style.boxShadow = '0px 0px 10px rgba(255, 255, 255, 0.5)';

            previewModal.onclick = function() {
                document.body.removeChild(previewModal);
            };

            previewModal.appendChild(image);
            document.body.appendChild(previewModal);
        }
    </script>
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
                        @foreach ($designTracking as $tracking)
                            <div class="timeline-item mb-4 {{ $tracking->status }}">
                                <div class="d-flex align-items-start">
                                    <div
                                        class="timeline-marker me-3 {{ $tracking->status == 'completed' ? 'bg-success' : ($tracking->status == 'in_progress' ? 'bg-warning' : 'bg-secondary') }}">
                                        <i
                                            class="fas {{ $tracking->status == 'completed' ? 'fa-check' : ($tracking->status == 'in_progress' ? 'fa-clock' : 'fa-hourglass') }} text-white"></i>
                                    </div>
                                    <div class="timeline-content p-3 flex-grow-1">
                                        <div class="d-flex flex-column flex-sm-row justify-content-between">
                                            <h6><i class="fas fa-step-forward me-1"></i> Step {{$loop->iteration}} :
                                                {{ $tracking->trackingStepDesign->step_name }}
                                            </h6>
                                            <div
                                                class="d-flex flex-row flex-sm-column align-items-center align-items-sm-end gap-2 mt-2 mt-sm-0">
                                                <small
                                                    class="neumorphic-card2 text-white px-2 py-1
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
                                        <hr>
                                        @if ($tracking->notes)
                                            <p class="mb-0 mt-2">Note : {{ $tracking->notes }}</p>
                                        @else
                                            <p class="mb-0 mt-2">Note : -</p>
                                        @endif

                                        @if ($tracking->files && $tracking->files->count() > 0)
                                            <p class="mt-2 mb-2"><i class="fas fa-paperclip me-1"></i> Attachment:</p>
                                            <div class="d-flex align-items-center gap-2 flex-wrap ms-4">
                                                @foreach ($tracking->files as $file)
                                                    <div class="position-relative" style="display: inline-block;">
                                                        <img src="{{ asset('storage/uploads/tracking/' . $file) }}"
                                                            class="img-thumbnail card-radius"
                                                            style="max-width: 100px; cursor: pointer;"
                                                            onclick="showFilePreview('{{ asset('storage/uploads/tracking/' . $file) }}')">
                                                        <button
                                                            class="btn btn-sm neumorphic-button position-absolute top-0 end-0 m-1 p-1"
                                                            style="background: rgba(0, 0, 0, 0.6); border-radius: 50%;"
                                                            onclick="showFilePreview('{{ asset('storage/uploads/tracking/' . $file) }}')">
                                                            <i class="fas fa-eye text-white"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
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
                        <span>#Code Design: <strong
                                class="neumorphic-card2 text-white px-2 py-1 bg-success">{{ $customDesign->code_design }}</strong></span>
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

@section('script')
    <script>
        function showFilePreview(fileUrl) {
            const previewModal = document.createElement('div');
            previewModal.style.position = 'fixed';
            previewModal.style.top = '0';
            previewModal.style.left = '0';
            previewModal.style.width = '100%';
            previewModal.style.height = '100%';
            previewModal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            previewModal.style.display = 'flex';
            previewModal.style.alignItems = 'center';
            previewModal.style.justifyContent = 'center';
            previewModal.style.zIndex = '9999';

            const image = document.createElement('img');
            image.src = fileUrl;
            image.style.maxWidth = '90%';
            image.style.maxHeight = '90%';
            image.style.borderRadius = '10px';
            image.style.boxShadow = '0px 0px 10px rgba(255, 255, 255, 0.5)';

            previewModal.onclick = function() {
                document.body.removeChild(previewModal);
            };

            previewModal.appendChild(image);
            document.body.appendChild(previewModal);
        }
    </script>
@endsection
