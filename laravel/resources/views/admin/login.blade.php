<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Master Portal - Tots Administration</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body class="bg-auth d-flex align-items-center justify-content-center min-vh-100 py-5 pt-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md-8 col-lg-5">
                <div class="text-center mb-4">
                    <span class="text-decoration-none fw-extrabold fs-2 text-brand" style="letter-spacing: -0.5px;">
                        tots<span class="text-accent">.</span><span class="fs-6 text-muted font-monospace bg-light border p-1 rounded-3 ms-1">admin</span>
                    </span>
                </div>

                <div class="card auth-card p-4 p-md-5 border-0 shadow-sm">
                    <div class="text-center mb-2">
                        <h4 class="fw-bold text-dark mb-1">Administrative Sign In</h4>
                        <p class="text-muted small">Enter credentials to open secure master database systems.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small p-2.5 mb-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold text-secondary">Master Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-shield-lock"></i></span>
                                <input type="email" id="email" name="email" class="form-control border-start-0 ps-0" value="{{ old('email') }}" placeholder="admin@tots-blog.com" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small fw-bold text-secondary">Security Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-key"></i></span>
                                <input type="password" id="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-brand w-100 py-2.5 rounded-pill fw-bold">
                            Authenticate Portal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>