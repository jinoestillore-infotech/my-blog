<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Account Security Settings - Tots</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Base App CSS styling mapping -->
    <link rel="stylesheet" href="{{ asset('css/feed.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <style>
        .portal-card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            background-color: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none !important;
            display: block;
        }
        .portal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.08) !important;
            border-color: var(--brand-primary) !important;
        }
        .portal-icon {
            transition: transform 0.3s ease;
        }
        .portal-card:hover .portal-icon {
            transform: scale(1.1);
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
    <main class="py-5 pt-4">
        <div class="container" style="max-width: 850px;">
            
            <div class="mb-5 text-center text-md-start">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center justify-content-md-start">
                        <li class="breadcrumb-item"><a href="{{ route('tots-feed') }}" class="text-brand text-decoration-none">Tots Feed</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Security Settings</li>
                    </ol>
                </nav>
                <h1 class="fw-extrabold text-dark tracking-tight">Security & Recovery Portal</h1>
                <p class="text-secondary mb-0">Select an action option below to protect your identity, verify authorization, or setup recovery overrides.</p>
            </div>

            <div class="row g-4 justify-content-center">
                
                <!-- PASSWORD ROUTING LINK CARD -->
                <div class="col-12 col-md-6">
                    <a href="{{ route('settings.password') }}" class="card portal-card p-4 shadow-sm h-100 border-light-subtle">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-primary-subtle text-primary rounded-4 p-3 d-flex align-items-center justify-content-center portal-icon" style="width: 54px; height: 54px;">
                                <i class="bi bi-shield-lock-fill fs-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-extrabold text-dark mb-1">Change Password</h5>
                                <p class="text-secondary small mb-3">Update and protect your account credential criteria using security indicators.</p>
                                <span class="text-brand fw-bold small d-flex align-items-center gap-1">
                                    Manage Password <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- SECURITY QUESTION ROUTING LINK CARD -->
                <div class="col-12 col-md-6">
                    <a href="{{ route('settings.question') }}" class="card portal-card p-4 shadow-sm h-100 border-light-subtle">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-warning-subtle text-warning-emphasis rounded-4 p-3 d-flex align-items-center justify-content-center portal-icon" style="width: 54px; height: 54px;">
                                <i class="bi bi-shield-fill-plus fs-3 text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-extrabold text-dark mb-1">Security Question</h5>
                                <p class="text-secondary small mb-3">Setup a challenge question-answer mechanism to allow password recovery.</p>
                                <span class="text-brand fw-bold small d-flex align-items-center gap-1">
                                    Configure Challenge <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </main>

    <!-- Toasts Placement -->
    <div class="toast-container position-fixed top-0 end-0 p-3" id="toastPlacement"></div>

    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/toast.js') }}"></script>
    
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
</body>
</html>