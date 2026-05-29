<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard - Tots</title>
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Separated CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
</head>
<body>
    <!-- Main Dashboard Section -->
    <main class="py-3">
        <div class="container">
            <!-- Welcome Header Panel -->
            <div class="card welcome-card p-4 p-md-5 border-0 shadow-sm text-white mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="fw-extrabold mb-2">What story will you tell the world today?</h3>
                        <p class="mb-0 text-white-50 opacity-90">Inspire others through your ideas, experiences, and creativity. Start writing and grow your community one post at a time.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('posts.create') }}" class="btn btn-light text-brand fw-bold rounded-pill px-4 py-2.5">
                            <i class="bi bi-pencil-square me-1"></i> Write a New Post
                        </a>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 mb-3">
                <a href="" class="btn btn-primary-custom text-decoration-none ms-lg-auto rounded-3">
                    <i class="bi bi-globe fs-4"></i>
                </a>
            </div>

            <div class="row g-4">
                <!-- Left Main Content Column: Creator's Stats and Posts -->
                <div class="col-lg-8">
                    <!-- Quick Stats Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-4">
                            <div class="stat-box p-4 rounded-4 text-center">
                                <i class="bi bi-file-earmark-text text-brand fs-3 mb-2 d-block"></i>
                                <h3 class="fw-extrabold text-dark mb-0">0</h3>
                                <span class="text-secondary small fw-medium">Published Posts</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box p-4 rounded-4 text-center">
                                <i class="bi bi-eye text-brand fs-3 mb-2 d-block"></i>
                                <h3 class="fw-extrabold text-dark mb-0">0</h3>
                                <span class="text-secondary small fw-medium">Total Reads</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="stat-box p-4 rounded-4 text-center">
                                <i class="bi bi-people text-brand fs-3 mb-2 d-block"></i>
                                <h3 class="fw-extrabold text-dark mb-0">0</h3>
                                <span class="text-secondary small fw-medium">Followers</span>
                            </div>
                        </div>
                    </div>
                    <!-- My Stories Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold text-dark mb-0">My Recent Stories</h4>
                        <a href="{{ route('posts.index') }}" class="text-brand text-decoration-none small fw-semibold">View All</a>
                    </div>
                    <!-- Empty State Placeholder (since we have no post model/tables yet) -->
                    <div class="card empty-state-card p-5 border-0 text-center rounded-4 shadow-sm mb-4">
                        <div class="empty-icon-wrapper mx-auto mb-3">
                            <i class="bi bi-journal-plus fs-3 text-brand"></i>
                        </div>
                        <h5 class="fw-bold text-dark">You haven't written anything yet!</h5>
                        <p class="text-secondary small mx-auto mb-4" style="max-width: 400px;">
                            The world is waiting for your thoughts. Click below to create your very first blog post on Tots.
                        </p>
                        <a href="{{ route('posts.create') }}" class="btn btn-brand rounded-pill px-4">Create First Story</a>
                    </div>
                </div>
                <!-- Right Sidebar Column: User Quick Profile & Quick Draft -->
                <div class="col-lg-4">
                    <!-- Quick Profile Details -->
                    <div class="card profile-summary-card p-4 border-0 shadow-sm rounded-4 mb-4">
                        <div class="text-center">
                            <!-- Placeholder avatar initials -->
                            <div class="profile-avatar-placeholder mx-auto mb-3">
                                {{ strtoupper(substr(Auth::user()->name, 0, 3)) }}
                            </div>
                            <h5 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h5>
                            <p class="text-brand small mb-3">&#64;{{ Auth::user()->username }}</p>
                            <!-- Bio Field -->
                            <p class="text-muted small px-2">
                                {{ Auth::user()->bio ?? "No author bio added yet. Tell the community who you are!" }}
                            </p>
                            <hr class="text-muted opacity-20">
                            <div class="m-1 d-flex align-items-center gap-2">
                                <a href="#" class="btn btn-outline-custom btn-sm rounded-pill px-3 py-2">
                                    <i class="bi bi-gear me-1"></i> Edit Author Profile
                                </a>
                                <!-- Secure Logout Link -->
                                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2" 
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Quick Draft Form Module -->
                    <div class="card quick-draft-card p-4 border-0 shadow-sm rounded-4">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-lightning-charge-fill text-accent me-1"></i>Quick Draft</h5>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Catchy title goes here..." required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="What's on your mind? Spill your thoughts..." required></textarea>
                            </div>
                            <button type="button" class="btn btn-brand btn-sm rounded-pill w-100 py-2">Save Draft</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
<!-- Bootstrap Bundle with Popper JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
</body>
</html>