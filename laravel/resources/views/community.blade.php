<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Our Community - Tots</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/community.css') }}">
</head>
<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-3">
            <div class="container">
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="/" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#totsNavbar" aria-controls="totsNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="totsNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0 gap-md-3">
                        <li class="nav-item me-5">
                            <a class="nav-link text-brand fw-bold px-2" href="/community">Our Community</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        @auth
                            <a href="{{ route('pages.index') }}" class="text-decoration-none text-secondary fw-semibold px-3">Dashboard</a>
                            <a href="{{ route('tots-feed') }}" class="btn btn-brand px-4 text-nowrap">Enter Feed</a>
                        @else
                            <a href="{{ route('login') }}" class="text-decoration-none text-secondary fw-semibold border rounded-pill px-4 py-2">Log in</a>
                            <a href="{{ route('register') }}" class="btn btn-brand px-4 text-nowrap">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5 pt-3">
        <div class="container">
            <div class="text-center max-w-2xl mx-auto mb-5">
                <h1 class="display-5 fw-extrabold text-dark mb-3">Meet the Makers of Tots</h1>
                <p class="lead text-secondary mx-auto" style="max-width: 650px;">
                    Discover amazing storytellers, active builders, creative artists, and thought leaders pushing the limits of collaborative blogging.
                </p>
                
                <div class="row justify-content-center mt-4">
                    <div class="col-md-8 col-lg-7">
                        <form action="{{ route('community') }}" method="GET" class="search-box p-1 bg-white rounded-pill shadow-sm border d-flex align-items-center">
                            <i class="bi bi-search text-muted ms-3 me-2"></i>
                            <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control border-0 bg-transparent py-2 shadow-none" placeholder="Search creators, bios, or usernames...">
                            <button type="submit" class="btn btn-brand rounded-pill px-4 me-1 d-none d-sm-inline-block">Search</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <p class="text-muted small fw-bold text-uppercase tracking-wider mb-3">Community Hub</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('community') }}" class="btn btn-tag {{ empty($search) ? 'active' : '' }} rounded-pill px-3 py-1.5 text-decoration-none">All Creators</a>
                    <a href="{{ route('popular') }}" class="btn btn-tag rounded-pill px-3 py-1.5 text-decoration-none">
                        <i class="bi bi-trophy-fill text-warning me-1"></i> View Leaderboard
                    </a>
                </div>
            </div>

            <div class="row g-4 mb-5">
                @forelse($writers as $writer)
                    <div class="col-md-6 col-lg-4">
                        <div class="card creator-card h-100 p-4 border-0 shadow-sm bg-white">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                @if($writer->avatar)
                                    <img src="{{ asset($writer->avatar) }}" class="rounded-circle object-fit-cover" style="width: 48px; height: 48px; border: 2px solid var(--brand-primary);" alt="Avatar">
                                @else
                                    <div class="creator-avatar avatar-blue text-uppercase">
                                        {{ substr($writer->name, 0, 2) }}
                                    </div>
                                @endif
                                <span class="badge {{ $writer->rank_badge_class }} rounded-pill px-2.5 py-1.5 small">
                                    {{ $writer->rank_title }}
                                </span>
                            </div>

                            <h5 class="fw-bold text-dark mb-1">{{ $writer->name }}</h5>
                            <p class="text-brand small mb-3">&#64;{{ $writer->username }}</p>
                            
                            <p class="text-secondary small mb-4 flex-grow-1">
                                {{ $writer->bio ?? 'This creator hasn\'t customized their bio yet, but their words are waiting to be read.' }}
                            </p>

                            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                                <span class="text-muted small">
                                    <strong class="text-dark follower-count-{{ $writer->id }}">{{ $writer->followers_count }}</strong> Followers
                                </span>

                                @auth
                                    <button type="button" 
                                            class="btn btn-sm rounded-pill px-3 framework-follow-btn {{ Auth::user()->isFollowing($writer->id) ? 'btn-brand py-1 text-white' : 'btn-outline-dark' }}" 
                                            onclick="toggleCommunityFollow(this, '{{ $writer->id }}')">
                                        {{ Auth::user()->isFollowing($writer->id) ? 'Following' : 'Follow' }}
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm px-3 rounded-pill">Follow</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-people fs-1 d-block mb-3 text-muted opacity-50"></i>
                        <h4 class="fw-bold text-secondary">No Creators Found</h4>
                        <p class="text-muted">Try looking for another name, or check your query spelling.</p>
                        @if(!empty($search))
                            <a href="{{ route('community') }}" class="btn btn-brand btn-sm rounded-pill mt-2 px-4">Reset Filter</a>
                        @endif
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center my-4">
                {{ $writers->links('pagination::bootstrap-5') }}
            </div>

            @guest
                <div class="card cta-card p-4 p-md-5 text-center text-white border-0 mt-5">
                    <div class="max-w-2xl mx-auto py-3">
                        <h2 class="fw-extrabold mb-3">Share your story. Meet your crowd.</h2>
                        <p class="text-white-50 mb-4">Starting a blog shouldn't mean writing in a vacuum. Join our directory of amazing creators and start collaborating.</p>
                        <a href="{{ route('register') }}" class="btn btn-light text-brand fw-bold rounded-pill px-4 py-2.5">Join the Directory</a>
                    </div>
                </div>
            @endguest
        </div>
    </main>

    <footer class="bg-dark text-light py-5">
        <div class="container text-center">
            <span class="fw-extrabold fs-4 text-white">tots<span class="text-accent">.</span></span>
            <p class="text-light opacity-50 small mt-2 mb-0">&copy; {{ date('Y') }} Tots. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function toggleCommunityFollow(btn, userId) {
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
                    // Update counters immediately
                    const counters = document.querySelectorAll(`.follower-count-${userId}`);
                    counters.forEach(counter => {
                        counter.textContent = data.followers_count;
                    });

                    if (data.is_following) {
                        btn.textContent = 'Following';
                        btn.className = 'btn btn-brand text-white btn-sm rounded-pill px-3';
                    } else {
                        btn.textContent = 'Follow';
                        btn.className = 'btn btn-outline-brand btn-sm rounded-pill px-3';
                    }
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