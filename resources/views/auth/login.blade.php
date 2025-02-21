@extends('auth.layouts.app')

@section('assets_css')
@endsection

@section('content')
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <div class="col-md-8 d-none d-md-block p-0">
                <div class="left-section h-100 text-white d-flex align-items-center justify-content-center">
                    <h1 class="display-4 text-center fw-bold">Prosperity For All</h1>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <div class="login-form w-75">
                    <h2 class="fw-bold mb-4 text-dark text-center">Login Your Account</h2>
                    <form>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold text-dark">Email</label>
                            <input type="email" class="form-control form-control-lg fs-6" placeholder="Enter your email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold text-dark">Password</label>
                            <input type="password" class="form-control form-control-lg fs-6"
                                placeholder="Enter your password" required>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label text-dark" for="rememberMe">Remember Me</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mb-4 btn-lg fs-6 fw-bold">Sign In</button>
                    </form>
                    <p class="text-muted text-center">Don't have an account? <a href="/register"
                            class="text-decoration-none fw-bold">Sign Up</a></p>
                    <p class=" fw-bold text-muted mt-5 text-center">© {{ now()->year }} JATIWORKS <br> All rights
                        reserved.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('assets_js')
    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script src="{{ asset('assets/js/restAPI.js') }}"></script>
@endsection

@section('js')
    <script>
        async function submitLogin() {
            const loginForm = document.querySelector("form");
            const notyf = new Notyf({
                duration: 3000,
                position: {
                    x: 'right',
                    y: 'top'
                },
                dismissible: true
            });

            loginForm.addEventListener("submit", async function(event) {
                event.preventDefault();

                const email = document.querySelector("input[type='email']").value.trim();
                const password = document.querySelector("input[type='password']").value.trim();

                if (!email || !password) {
                    notyf.error('Email and Password required');
                    return;
                }

                let getDataRest = await renderAPI(
                    'POST',
                    '{{ route('login.postLogin') }}', {
                        email: email,
                        password: password
                    }
                ).then(function(response) {
                    return response;
                }).catch(function(error) {
                    let resp = error.response;
                    notyf.error(resp.data.message);
                    return resp;
                });

                if (getDataRest.status == 200) {
                    let rest_data = getDataRest.data.data;
                    notyf.success('Login Succesfully');
                    setTimeout(function() {
                        window.location.href = rest_data.route_redirect;
                    }, 1000);
                }
            });
        }

        async function initPageLoad() {
            await Promise.all([
                submitLogin()
            ])
        }
    </script>
@endsection
