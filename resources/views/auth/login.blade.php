<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Sign in - Apotek</title>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template-bootstrap/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-bootstrap/vendor/css/pages/page-auth.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-bootstrap/css/demo.css') }}" />
</head>

<body>
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Login Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <span class="app-brand-text demo text-body fw-bold">Apotek</span>
                    </div>
                    
                    <h4 class="mb-2">Welcome! 👋</h4>
                    <p class="mb-4">Please enter your account</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required />
                        </div>
                        
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                                <label class="form-check-label" for="remember-me"> Remember me </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>
                    
                    <p class="text-center">
                        <span>Don't have an account?</span>
                        <a href="{{ route('register') }}">
                            <span>Sign up</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('template-bootstrap/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template-bootstrap/js/main.js') }}"></script>
</body>
</html>