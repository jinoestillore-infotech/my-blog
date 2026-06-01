<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Find Writers - Tots Connect</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Explore Feed CSS -->
    <link rel="stylesheet" href="{{ asset('css/feed.css') }}">
    <style>
        .search-box-container {
            background-color: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
        }
        .friend-card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            background-color: #ffffff;
            transition: all 0.25s ease;
        }
        .friend-card:hover {
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.08);
            transform: translateY(-2px);
        }
        .friend-avatar {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .friend-avatar-placeholder {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            font-size: 1.5rem;
            font-weight: 800;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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
    <!-- Main Container Layout -->
    <main class="py-5 pt-3">
        <div class="container" style="max-width: 850px;">
            <!-- Discovery Header & Search Input Box -->
            <div class="mb-4">
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('pages.index') }}" class="text-brand text-decoration-none">Tots Feed</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Find</li>
                        </ol>
                    </nav>
                    <h1 class="fw-extrabold text-dark tracking-tight">Find Writers & Creators</h1>
                    <p class="text-secondary small">Search for your favorite storytellers, classmates, or authors and follow them to customize your dashboard feed.
                    </p>
                </div>
                <!-- Facebook Aesthetic Search Bar -->
                <div class="row justify-content-end mt-3">
                    <div class="col-md-9 col-lg-8">
                        <form action="{{ route('writers.search') }}" method="GET">
                            <div class="search-box-container p-2 d-flex align-items-center shadow-sm">
                                <i class="bi bi-search text-muted ms-3 me-2"></i>
                                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control border-0 bg-transparent py-2 shadow-none" placeholder="Search by name, @username, or profile bio..." autofocus>
                                <button type="submit" class="btn btn-brand rounded-pill px-4 py-2.5">Find</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Active Discovery Section -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <h5 class="fw-bold text-dark mb-0">
                        @if(!empty($search))
                            <i class="bi bi-search text-brand me-1"></i> Search Results for "{{ $search }}"
                        @else
                            <i class="bi bi-people-fill text-brand me-1"></i> Recommended Writers
                        @endif
                    </h5>
                </div>
                <div class="p-0 m-0 mb-2">
                    <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1.5 fw-semibold small">
                        {{ $writers->total() }} total authors
                    </span>
                </div>
                <!-- Creators List Grid -->
                <div class="row g-3">
                    @forelse($writers as $writer)
                        <div class="col-12 col-md-6">
                            <div class="card friend-card p-3 h-100 border-0 shadow-none d-flex flex-row align-items-center gap-3">
                                <!-- Profile Photo Widget -->
                                @if($writer->avatar)
                                    <img src="{{ asset($writer->avatar) }}" class="friend-avatar" alt="Avatar">
                                @else
                                    <div class="friend-avatar-placeholder bg-brand-light text-brand d-flex align-items-center justify-content-center">
                                        {{ strtoupper(substr($writer->name, 0, 2)) }}
                                    </div>
                                @endif
                                <!-- Details Widget Section -->
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="mb-0 fw-extrabold text-dark text-truncate">{{ $writer->name }}</h6>
                                    <span class="text-brand fs-11 fw-semibold d-block mb-1">&#64;{{ $writer->username }}</span>
                                    <!-- Dynamic Follower Counter + Rank Badge -->
                                    <div class="d-flex flex-wrap gap-1 align-items-center">
                                        <span class="badge bg-light text-secondary rounded-pill px-2 py-0.5 fs-11">
                                            <strong class="text-dark follower-display-{{ $writer->id }}">{{ $writer->followers_count }}</strong> followers
                                        </span>
                                        <span class="badge {{ $writer->rank_badge_class }} rounded-pill px-2 py-0.5 fs-11">
                                            {{ $writer->rank_title }}
                                        </span>
                                    </div>
                                </div>
                                <!-- Dynamic AJAX Follow Actions -->
                                <div class="flex-shrink-0">
                                    @if(Auth::user()->isFollowing($writer->id))
                                        <button type="button" 
                                                class="btn btn-brand text-white btn-sm rounded-pill px-3 py-2 fw-semibold fs-11" 
                                                onclick="toggleDiscoveryFollow(this, '{{ $writer->id }}')">
                                            Following
                                        </button>
                                    @else
                                        <button type="button" 
                                                class="btn btn-outline-brand btn-sm rounded-pill px-3 py-2 fw-semibold fs-11" 
                                                onclick="toggleDiscoveryFollow(this, '{{ $writer->id }}')">
                                            Follow
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">
                            <i class="bi bi-person-exclamation fs-1 d-block mb-3 opacity-50"></i>
                            <h5 class="fw-bold text-dark">No writers match your search</h5>
                            <p class="small text-secondary mb-3">Try searching for other names or usernames instead.</p>
                            <a href="{{ route('writers.search') }}" class="btn btn-brand btn-sm rounded-pill px-4 py-2">Clear Filter</a>
                        </div>
                    @endforelse
                </div>
            </div>
            <!-- Beautiful Pagination Controls -->
            <div class="d-flex justify-content-center mt-4">
                {{ $writers->links('pagination::simple-bootstrap-5') }}
            </div>

        </div>
    </main>
    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- AJAX Follow Module mapped to standard FollowController actions -->
    <script>
        function toggleDiscoveryFollow(btn, userId) {
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
                    // Instantly update the follower counter inside the specific layout row
                    const counter = document.querySelector(`.follower-display-${userId}`);
                    if (counter) {
                        counter.textContent = data.followers_count;
                    }

                    if (data.is_following) {
                        btn.textContent = 'Following';
                        btn.classList.remove('btn-outline-brand');
                        btn.classList.add('btn-brand', 'text-white');
                    } else {
                        btn.textContent = 'Follow';
                        btn.classList.remove('btn-brand', 'text-white');
                        btn.classList.add('btn-outline-brand');
                    }
                } else {
                    alert(data.message || 'Something went wrong.');
                }
            })
            .catch(error => {
                btn.disabled = false;
                console.error('AJAX Error toggling follow status:', error);
            });
        }
    </script>
</body>
</html>