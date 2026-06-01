<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reset Password - Recovery Question Challenge</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
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
    <style>
        .question-box {
            background-color: var(--brand-light);
            border: 1px solid rgba(99, 102, 241, 0.15);
            border-radius: 12px;
        }
    </style>
</head>
<body class="bg-auth d-flex align-items-center justify-content-center min-vh-100 py-5 pt-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md-8 col-lg-5">
                <!-- Brand Logo Centered -->
                <div class="text-center mb-4">
                    <a class="text-decoration-none fw-extrabold fs-2 text-brand" href="/" style="letter-spacing: -0.5px;">
                        tots<span class="text-accent">.</span>
                    </a>
                </div>
                <!-- Verification Challenge Card -->
                <div class="card auth-card p-4 p-md-5 border-0 shadow-sm">
                    <div class="text-center mb-4">
                        <span class="badge bg-brand-light rounded-pill px-3 py-1.5 fw-semibold text-brand mb-2.5">
                            <i class="bi bi-shield-lock-fill"></i> Step 2 of 2
                        </span>
                        <h4 class="fw-bold text-dark mb-1">Verify Recovery Answer</h4>
                        <p class="text-muted small">Answer your account question below to configure your fresh login details.</p>
                    </div>
                    <!-- Form Error Handlers -->
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small p-2.5 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                        </div>
                    @endif
                    <!-- Display the Active Question -->
                    <div class="question-box p-3 mb-4 text-center">
                        <small class="text-secondary d-block mb-1 fw-bold text-uppercase tracking-wider">Your Question</small>
                        <h6 class="text-brand fw-extrabold mb-0">"{{ $question }}"</h6>
                    </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <!-- Answer Input Field -->
                        <div class="mb-4">
                            <label for="security_answer" class="form-label small fw-bold text-secondary">Your Security Answer</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-key-fill"></i></span>
                                <input type="password" id="security_answer" name="security_answer" class="form-control border-start-0 ps-0" placeholder="Type your answer here..." required autofocus>
                            </div>
                        </div>
                        <hr class="text-muted opacity-10 my-2">
                        <div class="form-text small text-muted mb-2">
                            <span style="font-size: .75rem;">
                            NOTE: Use at least 12 characters, including uppercase and lowercase letters,
                            a number, and a special character (e.g. !, @, #, $).
                            </span>
                        </div>
                        <!-- Password Configuration Fields -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold text-secondary">Choose New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" id="password" name="password" class="form-control border-start-0 ps-0" placeholder="Min. 12 chars + symbol" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small fw-bold text-secondary">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-shield-lock"></i></span>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="Repeat your password" required>
                            </div>
                        </div>
                        <!-- Reset Trigger Button -->
                        <button type="submit" class="btn btn-brand w-100 py-2.5 rounded-pill fw-bold mb-3">
                            Reset & Apply Password
                        </button>
                    </form>
                    <div class="text-center mt-2">
                        <a href="{{ route('password.request') }}" class="text-brand text-decoration-none small fw-semibold">
                            <i class="bi bi-chevron-left"></i> Start Over
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