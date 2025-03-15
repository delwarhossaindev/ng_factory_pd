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
                        <form action="{{ route('login') }}" method="POST" class="mb-3 needs-validation" role="form"
                            novalidate>
                            @csrf
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="username" class="form-label">User ID</label>
                                <input type="text" class="form-control w-100" id="username" name="user_id"
                                    placeholder="UserID" required>
                            </div>
                            <div class="mb-3 fv-plugins-icon-container">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <input type="password" class="form-control w-100" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-layouts.footer-component />
</body>

</html>
