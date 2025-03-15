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
                        <h4 class="mb-2 text-center">Verify OTP 🔒</h4>
                        <p class="text-start mb-4 text-center">
                            We sent a verification code to your email. Enter the code from the email in the field below.
                            Your OTP last two digit is <span
                                class="fw-bold">{{ str()->of($otp->otp)->mask('*', 0, 4) }}</span>
                                @if(!$otp->hasExpired())
                                <p>Your OTP will expire within <span id="countdowntimer" class="fw-bold text-red">60 </span> Seconds</p>
                                @endif
                        </p>
                        <p class="mb-0 fw-semibold">Type your 6 digit security code</p>
                        <form id="twoStepsForm" action="{{ route('verify.otp',$otp->id) }}" method="POST" class="mb-3 needs-validation fv-plugins-bootstrap5 fv-plugins-framework"
                            role="form" novalidate>
                            @csrf
                            <div class="mb-3 fv-plugins-icon-container">
                                <div
                                    class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                                    <input type="text"
                                        class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                        maxlength="1" autofocus required name="otp[]">
                                    <input type="text"
                                        class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                        maxlength="1" required name="otp[]">
                                    <input type="text"
                                        class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                        maxlength="1" required name="otp[]">
                                    <input type="text"
                                        class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                        maxlength="1" required name="otp[]">
                                    <input type="text"
                                        class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                        maxlength="1" required name="otp[]">
                                    <input type="text"
                                        class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                        maxlength="1" required name="otp[]">
                                </div>
                                <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
                                    Verify OTP
                                </button>
                            </div>
                        </form>
                        <div class="text-center">Didn't get the email?
                            <form action="{{ route('resend.otp',$otp->user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-default">
                                    Resend
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-layouts.footer-component />
        <script src="{{ asset('admin/js/two-steps.js') }}"></script>
        <script>
            var timeleft = 60;
            var downloadTimer = setInterval(function(){
            timeleft--;
            document.getElementById("countdowntimer").textContent = timeleft;
            if(timeleft <= 0)
                clearInterval(downloadTimer);
            },1000);
        </script>
</body>

</html>
