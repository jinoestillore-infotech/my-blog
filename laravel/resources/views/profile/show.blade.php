<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $user->name }} - Tots Profile</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Profile Show CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile_show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
</head>
<body class="bg-profile-show">
    <!-- Header Navigation -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-2">
            <div class="container">
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="/tots" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <div class="ms-auto d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('pages.index') }}" class="btn btn-outline-custom btn-sm rounded-pill py-1 px-3 small">
                            <i class="bi bi-arrow-left"></i> Go Back
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-custom btn-sm rounded-pill px-4 py-2">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-brand btn-sm rounded-pill px-4 py-2">Get Started</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>
    <main class="py-5 pt-3">
        <div class="container">
            <a href="{{ route('tots-feed') }}" class="btn btn-brand btn-sm rounded-pill small mb-3">
                <i class="bi bi-globe me-1"></i> Tots Feed
            </a>
            <!-- Profile Cover Card Jumbotron -->
            <div class="card profile-header-card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="profile-banner-bg"></div>
                <div class="p-4 p-md-5 pt-0 position-relative">
                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-end gap-4 profile-header-content">
                        <!-- Avatar Container -->
                        <div class="profile-avatar-container">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" class="profile-avatar object-fit-cover rounded-circle" alt="{{ $user->name }}">
                                <div class="d-flex justify-content-center my-2">
                                    <span class="badge {{ $user->rank_badge_class }} rounded-pill px-2.5 py-1.5 fs-11 mt-1">
                                        {{ $user->rank_title }}
                                    </span>
                                </div>
                            @else
                                <div class="profile-avatar rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-extrabold fs-1 border">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="d-flex justify-content-center my-2">
                                    <span class="badge {{ $user->rank_badge_class }} rounded-pill px-2.5 py-1.5 fs-11 mt-1">
                                        {{ $user->rank_title }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <!-- User Info -->
                        <div class="text-center text-md-start flex-grow-1">
                            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-1">
                                <h1 class="h2 fw-extrabold text-dark mb-0 mt-2">{{ $user->name }}</h1>
                            </div>
                            <p class="text-brand fs-6 fw-semibold mb-2">&#64;{{ $user->username }}</p>
                            <!-- Social Counter stats -->
                            <div class="d-flex justify-content-center justify-content-md-start gap-4 text-secondary small py-2 mb-0">
                                <span>
                                    <strong class="text-dark follower-count-{{ $user->id }}">{{ $user->followers_count }}</strong> Followers
                                </span>
                                <span>
                                    <strong class="text-dark">{{ $user->following_count }}</strong> Following
                                </span>
                                <span>
                                    <strong class="text-dark">{{ $user->posts()->published()->count() }}</strong> Stories
                                </span>
                            </div>
                        </div>
                        <!-- Call-to-action Action Buttons (Follow vs Edit Settings) -->
                        <div class="mt-3 mt-md-0">
                            @auth
                                @if(Auth::id() === $user->id)
                                    <!-- Own profile settings -->
                                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-custom rounded-pill px-4 py-2.5 fw-semibold d-flex align-items-center gap-1">
                                        Edit Profile
                                    </a>
                                @else
                                    <!-- Other profile follow interaction -->
                                    <button type="button" 
                                            class="btn {{ Auth::user()->isFollowing($user->id) ? 'btn-brand text-white' : 'btn-outline-brand' }} rounded-pill px-4 py-2.5 fw-bold" 
                                            onclick="toggleProfileFollow(this, '{{ $user->id }}')">
                                        {{ Auth::user()->isFollowing($user->id) ? 'Following' : 'Follow' }}
                                    </button>
                                @endif
                            @else
                                <!-- Guest follow fallback -->
                                <a href="{{ route('login') }}" class="btn btn-outline-brand rounded-pill px-4 py-2.5 fw-bold">
                                    Follow Creator
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Split Layout Grid -->
            <div class="row g-4">
                <!-- Left Column: Biography & Author Milestones -->
                <div class="col-lg-4">
                    <div class="card bio-card p-4 border-0 shadow-sm rounded-4 mb-4">
                        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">About the Storyteller</h5>
                        <p class="text-secondary small lh-lg">
                            {{ $user->bio ?? "This writer hasn't customized their author bio yet, but they let their stories do the talking." }}
                        </p>
                        <div class="mt-4 pt-3 border-top text-muted small">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-calendar3 text-brand"></i>
                                <span>Member since {{ $user->created_at->format('F Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Milestones Widget Box -->
                    <div class="card bio-card p-4 border-0 shadow-sm rounded-4">
                        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">Storyteller Status</h5>
                        <div class="d-flex align-items-center gap-3">
                            <div class="status-icon-wrapper">
                                <i class="bi bi-trophy-fill {{ $user->rank_textile }} fs-4"></i>
                            </div>
                            <div>
                                <h6 class="{{ $user->rank_textile }} fw-bold mb-0">{{ $user->rank_title }}</h6>
                                <p class="text-secondary small mb-0">Dynamic milestone rank</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Column: List of Published Articles/Stories -->
                <div class="col-lg-8">
                    <h4 class="fw-extrabold text-dark mb-4">Published Stories</h4>
                    @if($posts->isEmpty())
                        <!-- Empty Stories State -->
                        <div class="card empty-profile-posts p-5 border-0 text-center rounded-4 shadow-sm bg-white">
                            <div class="empty-icon-wrapper mx-auto mb-3">
                                <i class="bi bi-journal-x fs-2 text-brand"></i>
                            </div>
                            <h5 class="fw-bold text-dark">No stories published yet</h5>
                            <p class="text-secondary small mx-auto mb-0" style="max-width: 400px;">
                                This storyteller is still gathering their thoughts. Be sure to check back soon!
                            </p>
                        </div>
                    @else
                        <!-- List of Published Stories Grid -->
                        <div class="row g-4">
                            @foreach($posts as $post)
                                <div class="col-md-6">
                                    <div class="card article-profile-card h-100 border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column">
                                        <!-- Post Cover -->
                                        <div class="post-card-cover position-relative overflow-hidden bg-light">
                                            @if($post->featured_image)
                                                <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="post-card-img">
                                            @else
                                                <div class="post-card-placeholder d-flex align-items-center justify-content-center p-3">
                                                    <i class="bi bi-journal-text fs-1 text-brand opacity-25"></i>
                                                </div>
                                            @endif
                                            <!-- Floating Badge -->
                                            <div class="position-absolute top-0 start-0 m-3">
                                                <span class="badge bg-light text-brand rounded-pill px-2.5 py-1.5 small shadow-sm fs-11">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min read
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                            <!-- Title -->
                                            <h5 class="fw-bold text-dark mb-2 post-card-title">
                                                <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-brand-link">
                                                    {{ $post->title }}
                                                </a>
                                            </h5>
                                            <!-- Excerpt -->
                                            <p class="text-secondary small mb-3 line-clamp-3">
                                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                                            </p>
                                            <!-- Footer details -->
                                            <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top border-light-subtle text-muted small">
                                                <span class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-eye"></i> {{ $post->views }} reads
                                                </span>
                                                <span>{{ $post->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $posts->links('pagination::simple-bootstrap-5') }}
                        </div>
                    @endif
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
<!-- Client-side Follow Controller AJAX trigger -->
<script>
    function toggleProfileFollow(btn, userId) {
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
                // Update follower counts immediately in the header
                const counter = document.querySelector(`.follower-count-${userId}`);
                if (counter) {
                    counter.textContent = data.followers_count;
                }

                if (data.is_following) {
                    btn.textContent = 'Following';
                    btn.className = 'btn btn-brand text-white rounded-pill px-4 py-2.5 fw-bold';
                } else {
                    btn.textContent = 'Follow Creator';
                    btn.className = 'btn btn-outline-brand rounded-pill px-4 py-2.5 fw-bold';
                }
            } else {
                alert(data.message || 'Something went wrong.');
            }
        })
        .catch(error => {
            btn.disabled = false;
            console.error('AJAX network error toggling follow status:', error);
        });
    }
</script>
</body>
</html>