@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="neumorphic-card p-4">
                <h5 class="mb-3">Form Information</h5>
                <p class="text-muted mb-4" style="margin-top: -1rem;">Required for application user information.</p>
                <form id="addDataForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" name="address" class="form-control neumorphic-card" rows="3" placeholder="Enter address">{{ old('address', $data->address ?? '') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control neumorphic-card"
                                placeholder="Enter email" value="{{ old('email', $data->email ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input id="phone" name="phone" type="text" class="form-control neumorphic-card"
                                placeholder="Enter phone number" value="{{ old('phone', $data->phone ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="linkedin" class="form-label">LinkedIn</label>
                            <input id="linkedin" name="linkedin" type="url" class="form-control neumorphic-card"
                                placeholder="Enter LinkedIn URL" value="{{ old('linkedin', $data->linkedin ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="youtube" class="form-label">YouTube</label>
                            <input id="youtube" name="youtube" type="url" class="form-control neumorphic-card"
                                placeholder="Enter YouTube URL" value="{{ old('youtube', $data->youtube ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input id="instagram" name="instagram" type="url" class="form-control neumorphic-card"
                                placeholder="Enter Instagram URL" value="{{ old('instagram', $data->instagram ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input id="facebook" name="facebook" type="url" class="form-control neumorphic-card"
                                placeholder="Enter Facebook URL" value="{{ old('facebook', $data->facebook ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="tiktok" class="form-label">Tiktok</label>
                            <input id="tiktok" name="tiktok" type="url" class="form-control neumorphic-card"
                                placeholder="Enter Tiktok URL" value="{{ old('tiktok', $data->tiktok ?? '') }}">
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" id="submitBtn" class="btn neumorphic-button-outline fw-bold">
                            <i class="fas fa-save me-1"></i>Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let title = '{{ $title }}'

        async function addListData() {
            document.getElementById("addDataForm").addEventListener("submit", async function(e) {
                e.preventDefault();

                const saveButton = document.getElementById('submitBtn');
                const originalContent = saveButton.innerHTML;
                if (saveButton.disabled) return;

                const confirmed = await confirmSubmitData(saveButton);
                if (!confirmed) return;

                const formData = new FormData(document.getElementById('addDataForm'));

                @if (!empty($data->id))
                    formData.append('id', '{{ $data->id }}');
                @endif

                try {
                    const postData = await restAPI('POST', '{{ route('admin.cms.information.store') }}',
                        formData);

                    if (postData.status >= 200 && postData.status < 300) {
                        await notyf.success('Data saved successfully.');

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        notyf.error('An error occurred while saving data.');
                    }
                } catch (error) {
                    notyf.error('Failed to save data. Please try again.');
                } finally {
                    saveButton.disabled = false;
                    saveButton.innerHTML = originalContent;
                }
            });
        }

        async function initPageLoad() {
            await Promise.all([
                addListData()
            ])
        }
    </script>
@endsection
