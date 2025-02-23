@extends('auth.layouts.app')

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
                    <h2 class="fw-bold mb-4 text-dark text-center">Create Your Account</h2>
                    <form id="registerForm" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Name</label>
                            <input type="text" name="name" class="form-control form-control-lg fs-6"
                                placeholder="Enter your name" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg fs-6"
                                placeholder="Enter your email" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg fs-6"
                                placeholder="Enter your password" required autocomplete="new-password">
                            <div class="mt-2" id="password-rules">
                                <small class="d-block text-danger" id="rule-length">❌ At least 8 characters</small>
                                <small class="d-block text-danger" id="rule-uppercase">❌ At least 1 uppercase letter</small>
                                <small class="d-block text-danger" id="rule-number">❌ At least 1 number</small>
                                <small class="d-block text-danger" id="rule-symbol">❌ At least 1 symbol</small>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree">
                            <label class="form-check-label text-dark" for="agree">
                                I have read and agree to the <a href="/terms-of-service" target="_blank">Terms of
                                    Service</a><br>
                                and <a href="/privacy-policy" target="_blank">Privacy Policy</a>.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg fs-6 w-100 mb-4 fw-bold">Sign Up</button>
                    </form>
                    <p class="text-muted text-center">Already have an account? <a href="{{ route('login.index') }}"
                            class="text-decoration-none fw-bold">Sign In</a></p>
                    <p class="fw-bold text-muted mt-5 text-center">© {{ now()->year }} JATIWORKS <br> All rights
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
        const passwordInput = document.querySelector("#password");
        const passwordRules = document.querySelector("#password-rules");
        const ruleLength = document.querySelector("#rule-length");
        const ruleUppercase = document.querySelector("#rule-uppercase");
        const ruleNumber = document.querySelector("#rule-number");
        const ruleSymbol = document.querySelector("#rule-symbol");

        passwordRules.style.display = "none";

        passwordInput.addEventListener("focus", function() {
            passwordRules.style.display = "block";
        });

        passwordInput.addEventListener("input", function() {
            const value = passwordInput.value;

            if (value.length >= 8) {
                ruleLength.innerHTML = "✅ At least 8 characters";
                ruleLength.classList.remove("text-danger");
                ruleLength.classList.add("text-success");
            } else {
                ruleLength.innerHTML = "❌ At least 8 characters";
                ruleLength.classList.remove("text-success");
                ruleLength.classList.add("text-danger");
            }

            if (/[A-Z]/.test(value)) {
                ruleUppercase.innerHTML = "✅ At least 1 uppercase letter";
                ruleUppercase.classList.remove("text-danger");
                ruleUppercase.classList.add("text-success");
            } else {
                ruleUppercase.innerHTML = "❌ At least 1 uppercase letter";
                ruleUppercase.classList.remove("text-success");
                ruleUppercase.classList.add("text-danger");
            }

            if (/\d/.test(value)) {
                ruleNumber.innerHTML = "✅ At least 1 number";
                ruleNumber.classList.remove("text-danger");
                ruleNumber.classList.add("text-success");
            } else {
                ruleNumber.innerHTML = "❌ At least 1 number";
                ruleNumber.classList.remove("text-success");
                ruleNumber.classList.add("text-danger");
            }

            if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
                ruleSymbol.innerHTML = "✅ At least 1 symbol";
                ruleSymbol.classList.remove("text-danger");
                ruleSymbol.classList.add("text-success");
            } else {
                ruleSymbol.innerHTML = "❌ At least 1 symbol";
                ruleSymbol.classList.remove("text-success");
                ruleSymbol.classList.add("text-danger");
            }
        });

        passwordInput.addEventListener("blur", function() {
            if (passwordInput.value === "") {
                passwordRules.style.display = "none";
            }
        });

        async function submitRegister() {
            const registerForm = document.querySelector("#registerForm");
            const notyf = new Notyf({
                duration: 3000,
                position: {
                    x: 'right',
                    y: 'top'
                },
                dismissible: true
            });

            registerForm.addEventListener("submit", async function(event) {
                event.preventDefault();

                const name = document.querySelector("input[name='name']").value.trim();
                const email = document.querySelector("input[name='email']").value.trim();
                const password = passwordInput.value.trim();
                const agree = document.querySelector("#agree").checked;

                if (!name || !email || !password) {
                    notyf.error("All fields are required.");
                    return;
                }

                if (!agree) {
                    notyf.error("You must agree to the Terms of Service.");
                    return;
                }

                let getDataRest = await restAPI(
                    'POST',
                    '{{ route('register.postregister') }}', {
                        name: name,
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
                    notyf.success('Registration successful');
                    setTimeout(function() {
                        window.location.href = '{{ route('login.index') }}';
                    }, 1000);
                }
            });
        }

        async function initPageLoad() {
            await Promise.all([
                submitRegister()
            ])
        }
    </script>
@endsection
