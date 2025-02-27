@extends('admin.layouts.app')

@section('content')
<!-- File Preview Modal -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filePreviewModalLabel">File Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" class="img-fluid" alt="File Preview">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Detail - {{ $order->code_order }}</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Order Information</h5>
                            <p><strong>Order Code:</strong> {{ $order->code_order }}</p>
                            <p><strong>Buyer:</strong> {{ $order->user->name }}</p>
                            <p><strong>Item Name:</strong> {{ $order->id_katalog ? $order->katalog->item_name : $order->item_name }}</p>
                            <p><strong>Material:</strong> {{ $order->id_katalog ? $order->katalog->material : $order->material }}</p>
                            <p><strong>Dimensions (l x w x h):</strong> {{ $orderDetails['length'] }} x {{ $orderDetails['width'] }} x {{ $orderDetails['height'] }}</p>
                            <p><strong>Weight:</strong> {{ $order->id_katalog ? $order->katalog->weight : $order->weight }}</p>
                            <p><strong>Unit:</strong> {{ $order->id_katalog ? $order->katalog->unit : $order->unit }}</p>
                            <p><strong>Description:</strong> {{ $order->id_katalog ? $order->katalog->description : $order->description }}</p>
                            <p><strong>Status:</strong> {{ $order->status->label() }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5>Order Progress</h5>
                            <div class="timeline">
                                @foreach($order->orderTracking->sortBy('trackingStep.step_order') as $tracking)
                                    <div class="timeline-item">
                                        <div class="timeline-marker {{ $tracking->status === 'completed' ? 'bg-success' : ($tracking->status === 'in_progress' ? 'bg-primary' : 'bg-secondary') }}"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-0">{{ $tracking->trackingStep->step_name }}</h6>
                                            <small class="text-muted">Status: {{ ucfirst($tracking->status) }}</small>
                                            @if($tracking->completed_at)
                                                <br>
                                                <small class="text-muted">Completed: {{ $tracking->completed_at->format('d M Y H:i') }}</small>
                                            @endif
                                            @if($tracking->notes)
                                                <p class="mt-2 mb-0">{{ $tracking->notes }}</p>
                                            @endif
                                            @if($tracking->file_name)
                                                <button class="btn btn-sm neumorphic-button mt-2" onclick="showFilePreview('{{ asset('storage/uploads/order/' . $tracking->file_name) }}')">
                                                    <i class="fas fa-file me-1"></i>View File
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    display: flex;
    margin-bottom: 20px;
}

.timeline-marker {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    margin-right: 15px;
    margin-top: 5px;
}

.timeline-content {
    flex: 1;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.timeline-content:last-child {
    border-bottom: none;
}
</style>

<script>
function showFilePreview(fileUrl) {
    document.getElementById('previewImage').src = fileUrl;
    var modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
    modal.show();
}
</script>
@endsection
