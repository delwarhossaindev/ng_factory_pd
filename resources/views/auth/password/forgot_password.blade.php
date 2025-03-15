<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide">

<head>
    <x-layouts.header-component />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <x-alert.alert-component />
                        <h4 class="mb-2 text-center">Forgot Password? 🔒</h4>
                        <p class="mb-4 text-center">Enter your email and we'll send you instructions to reset your password</p>
                        <form action="{{ route('forgot.password') }}" method="POST" class="mb-3 needs-validation" role="form"
                            novalidate>
                            @csrf
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control w-100" id="email" name="email"
                                    placeholder="Enter your email" required value="{{ old('email') }}">
                            </div>
                            <button class="btn btn-primary d-grid w-100">Send Reset Link </button>
                        </form>
                        <div class="text-center">
                            <a href="/login" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-layouts.footer-component />
</body>

</html>
