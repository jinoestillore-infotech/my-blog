<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Account Security Settings - Tots</title>
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Base App CSS styling mapping -->
    <link rel="stylesheet" href="{{ asset('css/feed.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <style>
        .settings-card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }
        .settings-card:hover {
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.04) !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.15);
        }
        .input-group-text-btn {
            cursor: pointer;
            background-color: #ffffff;
            border-left: none;
            transition: color 0.2s ease;
        }
        .input-group-text-btn:hover {
            color: var(--brand-primary) !important;
        }
        .password-strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
            width: 0%;
        }
    </style>
</head>
<body class="bg-feed">
    <!-- Navigation Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-2">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="{{ route('tots-feed') }}" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('tots-feed') }}" class="btn btn-outline-custom btn-sm rounded-pill px-4 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Go Back
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Container Layout -->
    <main class="py-5 pt-3">
        <div class="container" style="max-width: 850px;">
            
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('tots-feed') }}" class="text-brand text-decoration-none">Tots Feed</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Security Settings</li>
                    </ol>
                </nav>
                <h1 class="fw-extrabold text-dark tracking-tight">Security & Recovery Settings</h1>
                <p class="text-secondary small">Maintain your privacy, update your key credentials, and safeguard your author profile.</p>
            </div>
            <div class="row g-4">
                <!-- UPDATE PASSWORD COLUMN -->
                <div class="col-12 col-md-6">
                    <div class="card settings-card p-4 shadow-sm h-100 bg-white border-light-subtle">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="bg-primary-subtle text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-shield-lock-fill fs-5"></i>
                            </div>
                            <h5 class="fw-extrabold text-dark mb-0">Change Password</h5>
                        </div>
                        <p class="text-secondary small mb-4">We advise choosing a unique, strong password combining letters, numbers, and symbols.</p>

                        <form action="{{ route('settings.security.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Current Password</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password" class="form-control rounded-start-3 border-end-0" placeholder="......." required>
                                    <span class="input-group-text input-group-text-btn rounded-end-3 border-start-0 text-muted" onclick="togglePasswordVisibility('current_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password" class="form-control rounded-start-3 border-end-0" placeholder="Min. 8 characters" onkeyup="checkPasswordStrength(this.value)" required>
                                    <span class="input-group-text input-group-text-btn rounded-end-3 border-start-0 text-muted" onclick="togglePasswordVisibility('new_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <div class="progress" style="height: 4px; background-color: #f1f5f9;">
                                        <div id="strength-bar" class="password-strength-bar progress-bar" role="progressbar"></div>
                                    </div>
                                    <small id="strength-text" class="text-muted small mt-1 d-block" style="font-size: 11px;">Password Strength</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-dark small fw-bold">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control rounded-start-3 border-end-0" placeholder="....." required>
                                    <span class="input-group-text input-group-text-btn rounded-end-3 border-start-0 text-muted" onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-brand w-100 rounded-pill py-2.5 fw-bold shadow-sm">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- UPDATE SECURITY QUESTION COLUMN -->
                <div class="col-12 col-md-6">
                    <div class="card settings-card p-4 shadow-sm h-100 bg-white border-light-subtle">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="bg-warning-subtle text-warning-emphasis rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-shield-fill-plus fs-5 text-warning"></i>
                            </div>
                            <h5 class="fw-extrabold text-dark mb-0">Security Question</h5>
                        </div>
                        <p class="text-secondary small mb-4">Set a security answer to easily authorize password changes and recover your account access.</p>

                        <form action="{{ route('settings.security.question') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Select Security Question</label>
                                <select name="security_question" class="form-select rounded-3" required>
                                    <option value="" disabled selected>Choose a question...</option>
                                    @foreach($questions as $question)
                                        <option value="{{ $question }}" {{ $user->security_question == $question ? 'selected' : '' }}>
                                            {{ $question }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Your Secret Answer</label>
                                <input type="password" name="security_answer" id="security_answer" class="form-control rounded-3" 
                                       placeholder="{{ $user->security_answer ? '•••••••• (Already Configured)' : 'Your recovery answer...' }}" required>
                                <div class="form-text text-muted" style="font-size: 11px;">Answers are stored using modern hashes and are completely confidential.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-danger small fw-bold">Verify Your Account Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_verification" id="password_verification" class="form-control border-danger-subtle rounded-start-3 border-end-0" placeholder="Verify password to authorize changes" required>
                                    <span class="input-group-text input-group-text-btn rounded-end-3 border-start-0 text-muted border-danger-subtle" onclick="togglePasswordVisibility('password_verification', this)">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-brand w-100 rounded-pill py-2 fw-bold">
                                Save Recovery Setup
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </main>

<!-- Bootstrap Bundle with Popper JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="{{ asset('js/toast.js') }}"></script>
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastPlacement"></div>
@if(session('success'))
<script>
    showToast(@json(session('success')), 'success');
</script>
@endif

@if($errors->any())
<script>
    showToast(@json($errors->first()), 'error');
</script>
@endif
<!-- Interactive Security Scripting features -->
<script>
    function togglePasswordVisibility(fieldId, iconElement) {
        const passwordField = document.getElementById(fieldId);
        const icon = iconElement.querySelector('i');
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordField.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    function checkPasswordStrength(password) {
        const bar = document.getElementById('strength-bar');
        const text = document.getElementById('strength-text');
        let score = 0;

        if (password.length === 0) {
            bar.style.width = '0%';
            text.textContent = 'Password Strength';
            text.className = 'text-muted small mt-1 d-block';
            return;
        }

        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        switch(score) {
            case 1:
                bar.style.width = '25%';
                bar.style.backgroundColor = '#ef4444';
                text.textContent = 'Weak password';
                text.className = 'text-danger small mt-1 d-block fw-semibold';
                break;
            case 2:
                bar.style.width = '50%';
                bar.style.backgroundColor = '#f97316';
                text.textContent = 'Moderate';
                text.className = 'text-warning small mt-1 d-block fw-semibold';
                break;
            case 3:
                bar.style.width = '75%';
                bar.style.backgroundColor = '#3b82f6';
                text.textContent = 'Strong';
                text.className = 'text-primary small mt-1 d-block fw-semibold';
                break;
            case 4:
                bar.style.width = '100%';
                bar.style.backgroundColor = '#22c55e';
                text.textContent = 'Highly Secure';
                text.className = 'text-success small mt-1 d-block fw-semibold';
                break;
        }
    }
</script>
</body>
</html>