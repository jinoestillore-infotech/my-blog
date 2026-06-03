<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Security Question Settings - Tots</title>
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
                        <li class="breadcrumb-item active" aria-current="page">Security Question</li>
                    </ol>
                </nav>
                <h1 class="fw-extrabold text-dark tracking-tight">Setup Recovery Question</h1>
                <p class="text-secondary small">Maintain backup authentication details in case of identity lockouts.</p>
            </div>

            <div class="row justify-content-center justify-content-lg-start">
                <div class="col-12 col-lg-8">
                    <div class="card settings-card p-4 shadow-sm bg-white border-light-subtle">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="bg-warning-subtle text-warning-emphasis rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-shield-fill-plus fs-5 text-warning"></i>
                            </div>
                            <h5 class="fw-extrabold text-dark mb-0">Recovery Challenge Configuration</h5>
                        </div>
                        <p class="text-secondary small mb-4">Choose a static question-answer challenge pairing. Your answers are hashed using one-way cryptographic functions.</p>

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
                                       placeholder="{{ $user->security_answer ? '(Already Configured)' : 'Your recovery answer...' }}" required>
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

                            <button type="submit" class="btn btn-brand w-100 rounded-pill py-2.5 fw-bold">
                                Save Recovery Setup
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
    </script>
</body>
</html>