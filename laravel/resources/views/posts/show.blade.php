<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tots - Explore Stories and Connect with Bloggers</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Explore Feed CSS -->
    <link rel="stylesheet" href="{{ asset('css/feed.css') }}">
</head>
<body class="bg-feed">

    <!-- Navigation Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-3">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="{{ route('home') }}" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>

                <!-- Responsive Menu Toggle -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#totsNavbar" aria-controls="totsNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation items -->
                <div class="collapse navbar-collapse" id="totsNavbar">
                    <ul class="navbar-nav mx-auto mb-2 mb-md-0 gap-md-3">
                        <li class="nav-item">
                            <a class="nav-link text-brand fw-bold px-2" href="{{ route('home') }}">Explore</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary fw-semibold px-2" href="{{ route('community') }}">Community</a>
                        </li>
                    </ul>

                    <!-- Call To Action / User State Buttons -->
                    <div class="d-flex align-items-center gap-3">
                        @auth
                            <!-- Logged In User Navbar View -->
                            <span class="text-secondary small fw-bold d-none d-lg-inline">Hi, {{ Auth::user()->name }}</span>
                            <a href="{{ route('pages.index') }}" class="btn btn-outline-custom btn-sm rounded-pill px-3 py-2">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                            <a href="{{ route('posts.create') }}" class="btn btn-brand btn-sm rounded-pill px-3 py-2">
                                <i class="bi bi-pencil-square me-1"></i> Write
                            </a>
                        @else
                            <!-- Guest Navbar View -->
                            <a href="{{ route('login') }}" class="text-decoration-none text-secondary fw-semibold px-3">Log in</a>
                            <a href="{{ route('register') }}" class="btn btn-brand px-4 py-2">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Container Layout -->
    <main class="py-5">
        <div class="container">
            <div class="row g-4">

                <!-- LEFT SIDEBAR: User Quick Card / Guest Invitation Card -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="sticky-sidebar">
                        @auth
                            <!-- Logged In User Quick Sidebar Info Card -->
                            <div class="card profile-card p-4 border-0 shadow-sm rounded-4 text-center mb-4">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset(Auth::user()->avatar) }}" class="profile-avatar mx-auto mb-3 object-fit-cover" alt="Avatar">
                                @else
                                    <div class="profile-avatar-placeholder mx-auto mb-3 d-flex align-items-center justify-content-center fw-extrabold text-brand">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                @endif
                                <h5 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h5>
                                <p class="text-brand small mb-3">&#64;{{ Auth::user()->username }}</p>
                                <p class="text-secondary small px-2 mb-4">
                                    {{ Auth::user()->bio ?? "No author bio added yet. Tell the Tots community who you are!" }}
                                </p>
                                <hr class="opacity-10 mb-4">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('posts.create') }}" class="btn btn-brand rounded-pill btn-sm py-2">
                                        <i class="bi bi-pencil-square me-1"></i> Write New Post
                                    </a>
                                    <a href="{{ route('posts.index') }}" class="btn btn-outline-custom rounded-pill btn-sm py-2">
                                        <i class="bi bi-journal-bookmark-fill me-1"></i> My Library
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Guest CTA Sidebar Card -->
                            <div class="card guest-card p-4 border-0 shadow-sm rounded-4 text-white text-center mb-4">
                                <div class="guest-card-icon mx-auto mb-3">
                                    <i class="bi bi-award-fill fs-3 text-accent"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Publish on Tots</h5>
                                <p class="small text-white-50 mb-4">Join our global writing community, document your thoughts, and find your circle.</p>
                                <a href="{{ route('register') }}" class="btn btn-light text-brand fw-bold rounded-pill w-100 py-2">Create Free Account</a>
                            </div>
                        @endauth

                        <!-- Informational Footer Links Inside Left Sidebar -->
                        <div class="px-3 small text-muted">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <a href="{{ route('privacy') }}" class="text-muted text-decoration-none hover-accent">Privacy Policy</a>
                                <span>&bull;</span>
                                <a href="{{ route('terms') }}" class="text-muted text-decoration-none hover-accent">Terms</a>
                                <span>&bull;</span>
                                <a href="{{ route('community') }}" class="text-muted text-decoration-none hover-accent">Community Directory</a>
                            </div>
                            <p class="mb-0">&copy; {{ date('Y') }} Tots. All rights reserved.</p>
                        </div>
                    </div>
                </div>

                <!-- CENTER FEED: The Social Explore Post Feed -->
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    
                    <!-- Quick Feed Greeting Banner -->
                    <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                        <h4 class="fw-extrabold text-dark mb-0">Explore Feed</h4>
                        <span class="badge bg-white text-brand border rounded-pill px-3 py-1.5 small fw-semibold">
                            <span class="spinner-grow spinner-grow-sm text-brand me-1" style="width: 6px; height: 6px;" role="status" aria-hidden="true"></span>
                            Live Updates
                        </span>
                    </div>

                    <!-- Dynamic Post Check -->
                    @if($posts->isEmpty())
                        <!-- Empty Feed Slate Placeholder -->
                        <div class="card empty-feed-card p-5 border-0 text-center rounded-4 shadow-sm">
                            <div class="empty-icon-wrapper mx-auto mb-3">
                                <i class="bi bi-rss fs-3 text-brand"></i>
                            </div>
                            <h5 class="fw-bold text-dark">No published stories yet!</h5>
                            <p class="text-secondary small mx-auto mb-4" style="max-width: 400px;">
                                Be the pioneer storyteller of Tots! Click below to write and publish your very first article to the community feed.
                            </p>
                            @auth
                                <a href="{{ route('posts.create') }}" class="btn btn-brand rounded-pill px-4">Publish First Story</a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-brand rounded-pill px-4">Register and Write</a>
                            @endauth
                        </div>
                    @else
                        <!-- Scrollable List of Published Stories -->
                        <div class="d-flex flex-column gap-4">
                            @foreach($posts as $post)
                                <article class="card feed-post-card border-0 shadow-sm rounded-4 overflow-hidden">
                                    
                                    <!-- Post Author Metadata Header -->
                                    <div class="p-4 pb-3 d-flex align-items-center gap-3">
                                        <!-- Author Profile Pic -->
                                        @if($post->user->avatar)
                                            <img src="{{ asset($post->user->avatar) }}" class="feed-author-img object-fit-cover rounded-circle" alt="Author">
                                        @else
                                            <div class="feed-author-placeholder rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-bold">
                                                {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <!-- User details -->
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-bold text-dark">{{ $post->user->name }}</h6>
                                            <small class="text-muted">&#64;{{ $post->user->username }} &bull; {{ $post->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>

                                    <!-- Post Content Details -->
                                    <div class="px-4 pb-3">
                                        <!-- Title -->
                                        <h3 class="h5 fw-extrabold text-dark mb-2 feed-post-title">
                                            <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-brand-link">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <!-- Excerpt -->
                                        <p class="text-secondary small mb-0 lh-base">
                                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 180) }}
                                        </p>
                                    </div>

                                    <!-- Post Cover Image -->
                                    @if($post->featured_image)
                                        <div class="feed-image-container position-relative">
                                            <a href="{{ route('posts.show', $post->slug) }}">
                                                <img src="{{ asset($post->featured_image) }}" class="w-100 img-fluid feed-cover-img" alt="Cover">
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Interactive Reactions Footer Panel -->
                                    <div class="px-4 py-3 bg-light border-top border-light-subtle d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Interactive Like Toggle Button (JS Client-side Mock) -->
                                            <button type="button" class="btn btn-reaction btn-sm rounded-pill d-flex align-items-center gap-1.5 px-3 py-1.5" onclick="toggleLike(this)">
                                                <i class="bi bi-heart text-danger"></i>
                                                <span class="small fw-semibold reaction-count">12</span>
                                            </button>
                                            
                                            <!-- Total Reads Indicator -->
                                            <span class="text-secondary small d-flex align-items-center gap-1">
                                                <i class="bi bi-eye"></i>
                                                {{ $post->views }} reads
                                            </span>
                                        </div>

                                        <!-- Direct Link to Post Details -->
                                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-custom btn-sm rounded-pill px-3 py-1.5 fw-semibold d-flex align-items-center gap-1">
                                            Read More <i class="bi bi-arrow-right-short fs-5"></i>
                                        </a>
                                    </div>

                                </article>
                            @endforeach
                        </div>

                        <!-- Paginated Navigation Controls -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $posts->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>

                <!-- RIGHT SIDEBAR: Community Widget suggestions & Trending Topics -->
                <div class="col-md-4 col-lg-3 d-none d-md-block">
                    <div class="sticky-sidebar">
                        
                        <!-- Who To Follow Card suggestions -->
                        <div class="card community-widget-card p-4 border-0 shadow-sm rounded-4 mb-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-lightning-charge-fill text-accent me-1"></i>Who to Follow</h6>
                            
                            <div class="d-flex flex-column gap-3">
                                <!-- Suggested Creator 1 -->
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-gradient-1">AM</div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-0 fw-bold text-dark text-truncate small">Amara Miller</h6>
                                        <small class="text-muted d-block text-truncate fs-11">&#64;amaramiller</small>
                                    </div>
                                    <a href="{{ route('community') }}" class="btn btn-outline-brand btn-xs rounded-pill px-2.5 py-1">Follow</a>
                                </div>

                                <!-- Suggested Creator 2 -->
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-gradient-2">KH</div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-0 fw-bold text-dark text-truncate small">Kenji Haneda</h6>
                                        <small class="text-muted d-block text-truncate fs-11">&#64;kenjih</small>
                                    </div>
                                    <a href="{{ route('community') }}" class="btn btn-outline-brand btn-xs rounded-pill px-2.5 py-1">Follow</a>
                                </div>
                            </div>

                            <hr class="opacity-10 my-3">
                            <a href="{{ route('community') }}" class="text-brand text-decoration-none small fw-semibold d-flex align-items-center gap-1">
                                View Creator Directory <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>

                        <!-- Trending Topics tag cloud -->
                        <div class="card community-widget-card p-4 border-0 shadow-sm rounded-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-hash text-brand"></i>Trending Topics</h6>
                            <div class="d-flex flex-wrap gap-1.5">
                                <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1.5 hover-badge">#Technology</span>
                                <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1.5 hover-badge">#Mindfulness</span>
                                <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1.5 hover-badge">#Design</span>
                                <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1.5 hover-badge">#Travel</span>
                                <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1.5 hover-badge">#Laravel</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Global Layout Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container text-center">
            <span class="fw-extrabold fs-4 text-white">tots<span class="text-accent">.</span></span>
            <p class="text-muted small mt-2 mb-0">&copy; {{ date('Y') }} Tots. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Client-side Like Animation Handler -->
    <script>
        function toggleLike(btn) {
            const icon = btn.querySelector('i');
            const countSpan = btn.querySelector('.reaction-count');
            let currentCount = parseInt(countSpan.textContent);

            if (icon.classList.contains('bi-heart')) {
                // Change status to Liked state
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                countSpan.textContent = currentCount + 1;
                btn.classList.add('liked-active');
            } else {
                // Revert to default standard unliked state
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                countSpan.textContent = currentCount - 1;
                btn.classList.remove('liked-active');
            }
        }
    </script>
</body>
</html>