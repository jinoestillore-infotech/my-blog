<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Recovery - Forgot Password</title>
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Separated CSS -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="bg-auth d-flex align-items-center justify-content-center min-vh-100 m-0 p-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md-8 col-lg-5">
                <!-- Brand Logo Centered -->
                <div class="text-center mb-4">
                    <a class="text-decoration-none fw-extrabold fs-2 text-brand" href="/" style="letter-spacing: -0.5px;">
                        tots<span class="text-accent">.</span>
                    </a>
                </div>
                <!-- Recovery Card -->
                <div class="card auth-card p-4 p-md-5 border-0 shadow-sm">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-dark mb-1">Forgot Password?</h4>
                        <p class="text-muted small">Enter your email below. We'll verify your details and present your recovery question challenge.</p>
                    </div>
                    <!-- Validation Feedback Alerts -->
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small p-2.5 mb-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <!-- Email Address Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label small fw-bold text-secondary">Registered Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="email" name="email" class="form-control border-start-0 ps-0" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-brand w-100 py-2.5 rounded-pill fw-bold mb-3">
                            Verify Email Address
                        </button>
                    </form>
                    <!-- Cancel / Return Link -->
                    <div class="text-center mt-2">
                        <a href="{{ route('login') }}" class="text-brand text-decoration-none small fw-bold">
                            <i class="bi bi-arrow-left me-1"></i> Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>