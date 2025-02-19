@extends('auth.layouts.app')

@section('content')
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Left Section -->
            <div class="col-md-8 d-none d-md-block p-0">
                <div class="left-section h-100 text-white d-flex align-items-center justify-content-center">
                    <h1 class="display-4 text-center fw-bold">Prosperity For All</h1>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <div class="login-form w-75">
                    <h2 class="fw-bold mb-4 text-dark text-center">Welcome Back</h2>
                    <form>
                        <!-- Name Input -->
                        <div class="mb-3">
                            <label for="" class="form-label text-dark fw-bold">Name</label>
                            <input type="text" class="form-control form-control-lg fs-6" placeholder="Enter your name"
                                required>
                        </div>
                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="" class="form-label text-dark fw-bold">Email</label>
                            <input type="email" class="form-control form-control-lg fs-6" placeholder="Enter your email"
                                required>
                        </div>
                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="" class="form-label text-dark fw-bold">Password</label>
                            <input type="password" class="form-control form-control-lg fs-6"
                                placeholder="Enter your password" required>
                        </div>
                        <!-- Confirm Password Input -->
                        <div class="mb-3">
                            <label for="" class="form-label text-dark fw-bold">Password Confirmation</label>
                            <input type="password" class="form-control form-control-lg fs-6"
                                placeholder="Confirm your password" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree">
                            <label class="form-check-label text-dark" for="rememberMe">I have read and agree to the <a
                                    href="/terms-of-service" target="_blank">Terms of Service</a><br> and <a
                                    href="/privacy-policy" target="_blank">Privacy
                                    Policy</a>.</label>
                        </div>
                        <!-- Sign Up Button -->
                        <button type="submit" class="btn btn-dark btn-lg fs-6 w-100 mb-4 fw-bold">Sign Up</button>
                    </form>
                    <!-- Additional Content -->
                    <p class="text-muted text-center">Already have an account? <a href="/login"
                            class="text-decoration-none fw-bold">Sign In</a></p>
                    <p class=" fw-bold text-muted mt-5 text-center">© 2025 PT AILAND GLOBAL INVESTMENTS <br> All rights
                        reserved.</p>

                </div>
            </div>
        </div>
    </div>
@endsection
