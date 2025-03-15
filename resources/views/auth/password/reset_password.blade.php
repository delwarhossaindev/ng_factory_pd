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
                        <h4 class="mb-2 text-center">Reset Password 🔒 🔒</h4>
                        <p class="mb-4 text-center">for <span class="fw-bold">{{ $otp->user->email }}</span></p>
                        <form action="{{ route('reset.password',$otp->id) }}" method="POST" class="mb-3 needs-validation" role="form"
                            novalidate>
                            @csrf
                            <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">New Password</label>
                                </div>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="password" id="password" class="form-control w-100" name="password"
                                        placeholder="············" aria-describedby="password" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Confirm Password</label>
                                </div>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="password" id="password" class="form-control w-100" name="password_confirmation"
                                        placeholder="············" aria-describedby="password" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary d-grid w-100">
                                Set new password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-layouts.footer-component />
</body>

</html>
