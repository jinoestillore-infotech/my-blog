<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Change Password - Tots</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/feed.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <style>
        .settings-card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }
        .form-control:focus {
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
        .nav-link-custom {
            color: #64748b;
            font-weight: 600;
            padding: 10px 16px;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .nav-link-custom:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .nav-link-custom.active {
            background-color: var(--brand-light);
            color: var(--brand-primary);
        }
    </style>
</head>
<body class="bg-feed">
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-2">
            <div class="container">
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="{{ route('tots-feed') }}" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('settings') }}" class="btn btn-outline-custom btn-sm rounded-pill px-4 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Security Portal
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5 pt-3">
        <div class="container" style="max-width: 850px;">
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('tots-feed') }}" class="text-brand text-decoration-none">Tots Feed</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('settings') }}" class="text-brand text-decoration-none">Security Portal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                    </ol>
                </nav>
                <h1 class="fw-extrabold text-dark tracking-tight">Update Authentication Password</h1>
                <p class="text-secondary small">Maintain secure authentication boundaries across sessions by updating your keys.</p>
            </div>

            <div class="d-flex gap-2 mb-4 bg-white p-2 rounded-4 shadow-sm border border-light-subtle">
                <a href="{{ route('settings.password') }}" class="nav-link-custom text-decoration-none active flex-fill text-center">
                    <i class="bi bi-shield-lock-fill me-2"></i>Change Password
                </a>
                <a href="{{ route('settings.question') }}" class="nav-link-custom text-decoration-none flex-fill text-center">
                    <i class="bi bi-shield-fill-plus me-2"></i>Security Question
                </a>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card settings-card p-4 shadow-sm bg-white border-light-subtle">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="bg-primary-subtle text-primary rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-shield-lock-fill fs-5"></i>
                            </div>
                            <h5 class="fw-extrabold text-dark mb-0">Update Password Credentials</h5>
                        </div>
                        <p class="text-secondary small mb-4">Protect your writer identity by setting a robust credential configuration utilizing lowercase, uppercase, and symbols.</p>

                        <form action="{{ route('settings.security.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">Current Password</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password" class="form-control rounded-start-3 border-end-0" placeholder="••••••••" required>
                                    <span class="input-group-text input-group-text-btn rounded-end-3 border-start-0 text-muted" onclick="togglePasswordVisibility('current_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small fw-bold">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password" class="form-control rounded-start-3 border-end-0" placeholder="Minimum 12 characters" onkeyup="checkPasswordStrength(this.value)" required>
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
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control rounded-start-3 border-end-0" placeholder="Match your new password" required>
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
            </div>
        </div>
    </main>

    <div class="toast-container position-fixed top-0 end-0 p-3" id="toastPlacement"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/toast.js') }}"></script>
    @if(session('success'))
        <script>showToast(@json(session('success')), 'success');</script>
    @endif
    @if($errors->any())
        <script>showToast(@json($errors->first()), 'error');</script>
    @endif

    <script>
        function togglePasswordVisibility(fieldId, iconElement) {
            const passwordField = document.getElementById(fieldId);
            const icon = iconElement.querySelector('i');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.className = 'bi bi-eye-slash';
            } else {
                passwordField.type = "password";
                icon.className = 'bi bi-eye';
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

            if (password.length >= 12) score++;
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