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
                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold text-dark">Email</label>
                            <input type="email" class="form-control form-control-lg fs-6" placeholder="Enter your email"
                                required>
                        </div>
                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold text-dark">Password</label>
                            <input type="password" class="form-control form-control-lg fs-6"
                                placeholder="Enter your password" required>
                        </div>
                        <!-- Remember Me and Forgot Password -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label text-dark" for="rememberMe">Remember Me</label>
                            </div>
                            <a href="#" class="text-decoration-none">Forgot Password?</a>
                        </div>
                        <!-- Sign In Button -->
                        <button type="submit" class="btn btn-dark w-100 mb-4 btn-lg fs-6 fw-bold">Sign In</button>
                    </form>
                    <!-- Additional Content -->
                    <p class="text-muted text-center">Don't have an account? <a href="/register"
                            class="text-decoration-none fw-bold">Sign Up</a></p>
                    <p class=" fw-bold text-muted mt-5 text-center">© 2025 PT AILAND GLOBAL INVESTMENTS <br> All rights reserved.</p>

                </div>

            </div>
        </div>
    </div>
@endsection
