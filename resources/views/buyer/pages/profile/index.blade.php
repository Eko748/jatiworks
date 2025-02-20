@extends('buyer.layouts.main')

@section('content')
    <section class="bg-old-blue-tri">
        <div class="container pt-5 pb-5">
            <h3 class="fw-bold">Update your profile</h3>
            <h6 class="subtitle h6 mb-5">For information</h6>
            <form id="updateProfileForm">
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user?->name ?? '' }}" autocomplete="off" placeholder="Enter your full name">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user?->email ?? '' }}" autocomplete="off" placeholder="Enter your email">
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                autocomplete="new-password" placeholder="Enter new password">
                            <small id="passwordHelp" class="form-text text-muted">
                                Must be at least 8 characters, including an uppercase letter, a number, and
                                a special character.
                            </small>
                            <div id="passwordValidation" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="rek" class="form-label">Bank Account</label>
                            <input type="text" class="form-control" id="rek" name="rek"
                                value="{{ $profile?->rek ?? '' }}" autocomplete="off"
                                placeholder="Enter your bank account number">
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $profile?->phone ?? '' }}" autocomplete="off"
                                placeholder="Enter your phone number">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" autocomplete="off"
                                placeholder="Enter your address">{{ $profile?->address ?? '' }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-old-blue float-end">
                            <i class="fas fa-paper-plane me-1"></i>Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('js')
    <script>
        const passwordInput = document.getElementById('password');
        const passwordValidation = document.getElementById('passwordValidation');

        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            let errors = [];

            if (password.length > 0) {
                if (password.length < 8) {
                    errors.push("At least 8 characters");
                }
                if (!/[A-Z]/.test(password)) {
                    errors.push("At least one uppercase letter");
                }
                if (!/[0-9]/.test(password)) {
                    errors.push("At least one number");
                }
                if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                    errors.push("At least one special character");
                }
            }

            if (errors.length > 0) {
                passwordValidation.innerHTML =
                    `<ul class="text-danger">${errors.map(err => `<li>${err}</li>`).join('')}</ul>`;
            } else {
                passwordValidation.innerHTML = password.length > 0 ?
                    `<span class="text-success">Password is valid</span>` : '';
            }
        });

        document.getElementById('updateProfileForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            try {
                let getDataRest = await renderAPI(
                    'POST',
                    '{{ route('profile.update') }}',
                    formData
                );

                if (getDataRest.status === 200) {
                    notyf.success('Profile updated successfully.');
                }
            } catch (error) {
                let resp = error.response;
                notyf.error(resp.data.message || 'An error occurred.');
            }
        });
    </script>
@endsection
