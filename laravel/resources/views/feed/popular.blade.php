<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Popular Writers - Tots</title>
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Share Community/Feed style base -->
    <link rel="stylesheet" href="{{ asset('css/feed.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <style>
        .popular-rank-badge {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
            background-color: var(--brand-light);
            color: var(--brand-primary);
        }
        .rank-1 {
            background-color: #fef3c7 !important;
            color: #d97706 !important;
        }
        .rank-2 {
            background-color: #e2e8f0 !important;
            color: #475569 !important;
        }
        .rank-3 {
            background-color: #ffedd5 !important;
            color: #ea580c !important;
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
                        <i class="bi bi-arrow-left"></i> Back to Feed
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main Content Container -->
    <main class="py-5 pt-3">
        <div class="container" style="max-width: 800px;">
            <!-- Header Section -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('pages.index') }}" class="text-brand text-decoration-none">Tots Feed</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Popular</li>
                    </ol>
                </nav>
                <h1 class="fw-extrabold text-dark tracking-tight">Popular Storytellers</h1>
                <p class="text-secondary small">The most followed minds on Tots. Discover active writers, connect with creators, and grow your literary circles.
                </p>
            </div>
            <!-- Writers Rankings List Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h4 class="fw-bold text-dark mb-1 pb-2">
                    <i class="bi bi-trophy text-accent me-2"></i>Writers Leaderboard
                </h4>
                <hr>
                <div class="d-flex flex-column gap-1">
                    @forelse($popularWriters as $index => $writer)
                        <div class="d-flex align-items-center justify-content-between gap-3 p-2 rounded-3 hover-badge">
                            <!-- Ranking Position Badge, Name & Details -->
                            <div class="d-flex align-items-center gap-3 overflow-hidden">
                                <!-- Rank Number Indicator -->
                                @php 
                                    $rank = $index + 1; 
                                @endphp
                                <div class="popular-rank-badge rounded-circle d-flex align-items-center justify-content-center fw-extrabold 
                                    {{ $rank == 1 ? 'rank-1' : '' }} 
                                    {{ $rank == 2 ? 'rank-2' : '' }} 
                                    {{ $rank == 3 ? 'rank-3' : '' }}">
                                    {{ $rank }}
                                </div>
                                <!-- User Avatar -->
                                @if($writer->avatar)
                                    <img src="{{ asset($writer->avatar) }}" class="rounded-circle object-fit-cover" style="width: 44px; height: 44px;" alt="Avatar">
                                @else
                                    <div class="rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-bold text-uppercase" style="width: 44px; height: 44px; font-size: 0.9rem;">
                                        {{ substr($writer->name, 0, 2) }}
                                    </div>
                                @endif
                                <!-- Details -->
                                <div class="overflow-hidden">
                                    <h6 class="mb-0 fw-bold text-dark text-truncate">{{ $writer->name }}</h6>
                                    <span class="text-muted d-block text-truncate fs-11">&#64;{{ $writer->username }}</span>
                                    
                                    <div class="d-flex flex-wrap gap-1 align-items-center mt-1">
                                        <!-- Dynamic follower metric badge -->
                                        <span class="badge bg-light text-secondary rounded-pill px-2 py-1 fs-11">
                                            <i class="bi bi-people-fill me-1"></i><span class="follower-count-{{ $writer->id }}">{{ $writer->followers_count }}</span> followers
                                        </span>
                                        <span class="badge {{ $writer->rank_badge_class }} rounded-pill px-2 py-0.5 fs-11">
                                            {{ $writer->rank_title }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Interactive Follow Form Button -->
                            <div>
                                @if(Auth::user()->isFollowing($writer->id))
                                    <button type="button" 
                                            class="btn btn-brand text-white btn-sm rounded-pill px-3 py-1 fs-11 fw-semibold follow-btn" 
                                            onclick="toggleFollow(this, '{{ $writer->id }}')">
                                        Following
                                    </button>
                                @else
                                    <button type="button" 
                                            class="btn btn-outline-brand btn-sm rounded-pill px-3 py-1.5 fs-11 fw-semibold follow-btn" 
                                            onclick="toggleFollow(this, '{{ $writer->id }}')">
                                        Follow
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-3 opacity-50"></i>
                            <p class="mb-0">No writers are registered on Tots yet!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Beautiful Pagination Controls -->
            @if(method_exists($popularWriters, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $popularWriters->links('pagination::bootstrap-5') }}
                </div>
            @endif

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
<!-- Interactive AJAX Followers Module -->
<script>
    function toggleFollow(btn, userId) {
            btn.disabled = true;

            fetch(`/users/${userId}/follow`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                if (data.success) {
                    // Instantly update the follower counter inside the specific item layout
                    const counter = document.querySelector(`.follower-count-${userId}`);
                    if (counter) {
                        counter.textContent = data.followers_count;
                    }

                    if (data.is_following) {
                        btn.textContent = 'Following';
                        btn.classList.remove('btn-outline-brand');
                        btn.classList.add('btn-brand', 'text-white');

                        showToast('You are now following this writer.', 'success');
                    } else {
                        btn.textContent = 'Follow';
                        btn.classList.remove('btn-brand', 'text-white');
                        btn.classList.add('btn-outline-brand');

                        showToast('You unfollowed this writer.', 'success');
                    }
                } else {
                    showToast(data.message || 'You unfollowed this writer.', 'error');
                }
            })
            .catch(error => {
                btn.disabled = false;
                showToast(
                error.message || 'Something went wrong.',
                'error'
                );
            });
        }
</script>
</body>
</html>