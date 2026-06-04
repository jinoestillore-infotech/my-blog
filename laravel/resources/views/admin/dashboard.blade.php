<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Dashboard - Tots Administration</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <!-- Admin Navbar -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-2">
            <div class="container">
                <span class="navbar-brand fw-extrabold fs-3 text-brand" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span><span class="fs-6 text-muted font-monospace bg-light border p-1 rounded-3 ms-1">admin</span>
                </span>
                
                <div class="ms-auto d-flex align-items-center gap-3">
                    <span class="text-muted small fw-bold d-none d-sm-inline-block">Master session: <span class="text-brand">{{ Auth::user()->name }}</span></span>
                    
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1.5 fw-semibold">
                            <i class="bi bi-box-arrow-right"></i> Terminate Portal
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Portal Greeting -->
            <div class="mb-5 text-center text-md-start">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 fw-bold mb-2">Live Status Terminal</span>
                <h1 class="fw-extrabold text-dark tracking-tight">Systems Overview Control Center</h1>
                <p class="text-secondary">Audit community interactions, enforce registration criteria, and resolve moderation queues.</p>
            </div>

            <!-- Dynamic System Metrics Panel -->
            <div class="row g-4 mb-5">
                <div class="col-12 col-md-4">
                    <div class="card metric-box p-4 rounded-4 border-0 shadow-sm text-center">
                        <i class="bi bi-people-fill text-brand fs-1 mb-2"></i>
                        <h2 class="fw-extrabold text-dark mb-0">{{ $totalUsers }}</h2>
                        <span class="text-muted small font-semibold uppercase">Total Registered Accounts</span>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card metric-box p-4 rounded-4 border-0 shadow-sm text-center">
                        <i class="bi bi-activity text-success fs-1 mb-2"></i>
                        <h2 class="fw-extrabold text-success mb-0">{{ $activeUsers }}</h2>
                        <span class="text-muted small font-semibold uppercase">Currently Active Users (5m)</span>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card metric-box p-4 rounded-4 border-0 shadow-sm text-center">
                        <i class="bi bi-shield-fill-exclamation text-danger fs-1 mb-2"></i>
                        <h2 class="fw-extrabold text-danger mb-0">{{ $pendingStoryReports + $pendingWriterReports }}</h2>
                        <span class="text-muted small font-semibold uppercase">Unresolved System Flags</span>
                    </div>
                </div>
            </div>

            <h4 class="fw-extrabold text-dark mb-4">Operations & Directory Access</h4>

            <!-- Grid of Interactive Navigation Cards -->
            <div class="row g-4">
                <!-- User Registry Card -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.users.index') }}" class="card admin-card p-4 shadow-sm border-light-subtle h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="flex-grow-1">
                                <h5 class="fw-extrabold text-dark mb-1">User Registry</h5>
                                <p class="text-secondary small mb-3">Audit registration details, reclassify system roles, or remove violating profiles.</p>
                                <span class="text-brand fw-bold small">Manage Users <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Flagged Story Reports Card -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.reports.stories') }}" class="card admin-card p-4 shadow-sm border-light-subtle h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="flex-grow-1">
                                <h5 class="fw-extrabold text-dark mb-1">Story Reports</h5>
                                <p class="text-secondary small mb-3">Verify flagged story content. Dismiss reports or delete violations straight from the queue.</p>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <span class="text-brand fw-bold small">Review Story Flags <i class="bi bi-arrow-right"></i></span>
                                    @if($pendingStoryReports > 0)
                                        <span class="badge bg-danger rounded-pill">{{ $pendingStoryReports }} pending</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Flagged Writer Reports Card -->
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.reports.writers') }}" class="card admin-card p-4 shadow-sm border-light-subtle h-100">
                        <div class="d-flex align-items-start gap-3">
                            <div class="flex-grow-1">
                                <h5 class="fw-extrabold text-dark mb-1">Writer Reports</h5>
                                <p class="text-secondary small mb-3">Inspect writers accused of impersonation, copyright theft, or harassment.</p>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <span class="text-brand fw-bold small">Review Writer Flags <i class="bi bi-arrow-right"></i></span>
                                    @if($pendingWriterReports > 0)
                                        <span class="badge bg-danger rounded-pill">{{ $pendingWriterReports }} pending</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </main>
</body>
</html>