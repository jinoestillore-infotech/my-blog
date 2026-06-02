<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $post->title }} - Tots Stories</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2 family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Story Reader CSS -->
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>
<body class="bg-reader">
    <!-- Navigation Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-2">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="{{ route('tots-feed') }}" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <!-- Back navigation action -->
                <div class="ms-auto">
                    @auth
                    <a href="{{ route('tots-feed') }}" class="btn btn-outline-custom btn-sm rounded-pill px-4 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Back to Explore
                    </a>
                    @else
                    <a href="{{ route('home') }}" class="btn btn-outline-custom btn-sm rounded-pill px-4 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Go Back
                    </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Article Reading Space -->
    <main class="py-5 pt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <!-- Article Header Metas -->
                    <header class="mb-4">
                        <!-- Author Meta Bar -->
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 py-2">
                            <!-- Author + Avatar Group -->
                            <div class="d-flex align-items-center gap-2">
                                <!-- Avatar -->
                                @if($post->user->avatar)
                                    <img src="{{ asset($post->user->avatar) }}"
                                        class="author-avatar object-fit-cover rounded-circle"
                                        alt="Author Profile">
                                @else
                                    <div class="author-avatar-placeholder rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-bold fs-5">
                                        {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                    </div>
                                @endif
                                <!-- Name -->
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">
                                        {{ $post->user->name }}
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        &#64;{{ $post->user->username }}
                                    </p>
                                </div>
                            </div>
                            <!-- Views Counter -->
                            <div class="ms-lg-auto d-flex align-items-center gap-1 text-muted small bg-light rounded-pill">
                                <span class="badge bg-transparent text-brand rounded-pill px-2 py-1" style="font-size: .75rem;">
                                    <i class="bi bi-clock me-1"></i>{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min read
                                </span>
                                {{ $post->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <h1 class="display-5 border-top fw-extrabold text-dark lh-sm mb-4 mt-2 tracking-tight pt-3">
                            {{ $post->title }}
                        </h1>
                    </header>
                    <!-- Post Featured Cover Image -->
                    @if($post->featured_image)
                        <div class="featured-image-wrapper mb-2 rounded-4 overflow-hidden shadow-sm">
                            <img src="{{ asset($post->featured_image) }}" class="img-fluid w-100 object-fit-cover" alt="{{ $post->title }}" style="max-height: 450px;" loading="lazy">
                        </div>
                    @endif
                    <!-- Interactive Actions Toolbar (Like & Save for Later) -->
                    <div class="d-flex justify-content-between align-items-center gap-2 pt-1 pb-3 mb-4">
                        @auth
                            <div class="d-flex align-items-center">
                                <button type="button" 
                                        class="btn btn-reaction btn-sm rounded-pill d-flex align-items-center gap-2 px-3 py-1 me-3 {{ $post->isLikedBy(Auth::user()) ? 'liked-active' : '' }}" 
                                        onclick="toggleShowPageLike(this, '{{ $post->id }}')">
                                    <i class="bi {{ $post->isLikedBy(Auth::user()) ? 'bi-heart-fill text-danger' : 'bi-heart text-danger' }}"></i>
                                    <span class="small fw-semibold text-dark">
                                        <span id="show-page-likes-count">{{ $post->likes()->count() }}</span>
                                    </span>
                                </button>
                                <i class="bi bi-eye text-secondary me-1"></i>
                                <span class="small fw-semibold text-secondary">{{ $post->views }} reads</span>
                            </div>

                            <button type="button" 
                                    class="btn btn-reaction btn-sm rounded-pill d-flex align-items-center gap-2 px-4 py-2 {{ $post->isBookmarkedBy(Auth::user()) ? 'bookmarked-active' : '' }}" 
                                    onclick="toggleShowPageBookmark(this, '{{ $post->id }}')">
                                <i class="bi {{ $post->isBookmarkedBy(Auth::user()) ? 'bi-bookmark-dash-fill text-primary' : 'bi-bookmark text-secondary' }}"></i>
                                <span class="small fw-semibold text-dark" id="bookmark-status-text">
                                    {{ $post->isBookmarkedBy(Auth::user()) ? 'Saved for Later' : 'Save for Later' }}
                                </span>
                            </button>
                        @else
                            <div class="d-flex align-items-center">
                                <a href="{{ route('login') }}" class="btn btn-reaction btn-sm rounded-pill d-flex align-items-center gap-2 px-3 py-1 me-3 text-decoration-none">
                                    <i class="bi bi-heart text-danger"></i>
                                    <span class="small fw-semibold text-dark">{{ $post->likes()->count() }}</span>
                                </a>
                                <i class="bi bi-eye text-secondary me-1"></i>
                                <span class="small fw-semibold text-secondary">{{ $post->views }} reads</span>
                            </div>

                            <a href="{{ route('login') }}" class="btn btn-reaction btn-sm rounded-pill d-flex align-items-center gap-2 px-4 py-2 text-decoration-none">
                                <i class="bi bi-bookmark text-secondary"></i>
                                <span class="small fw-semibold text-dark">Save for Later</span>
                            </a>
                        @endauth
                    </div>
                    <!-- Main Body Content Text Prose -->
                    <article class="story-body-content text-secondary mb-5 text-break lh-lg">
                        {!! nl2br(e($post->content)) !!}
                    </article>
                    <!-- Author Sign-off Bio Card -->
                    <div class="card author-bio-card p-4 border-0 shadow-sm rounded-4 mb-5">
                        <div class="row align-items-center g-3">
                            <!-- Left: Profile Info -->
                            <div class="col-md-3 text-center text-md-start">
                                @if($post->user->avatar)
                                    <img src="{{ asset($post->user->avatar) }}" class="author-bio-avatar object-fit-cover rounded-circle mx-auto d-block" alt="{{ $post->user->name }}">
                                @else
                                    <div class="author-bio-placeholder rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-extrabold mx-auto fs-3">
                                        {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <!-- Right: Bio Details -->
                            <div class="col-md-9 text-center text-md-start">
                                <span class="badge bg-brand-light rounded-pill px-2.5 py-1.5 small mb-2 fw-semibold">About the Author</span>
                                <h5 class="fw-extrabold text-dark mb-1">{{ $post->user->name }}</h5>
                                <p class="text-brand small mb-2">&#64;{{ $post->user->username }}</p>
                                <p class="text-secondary small mb-0 lh-base">
                                    {{ $post->user->bio ?? "This author hasn't updated their profile bio yet. Check out more stories on their Tots dashboard." }}
                                </p>
                                <a href="{{ route('profile.show', $post->user->username) }}" class="btn btn-brand mt-3 text-decoration-none">
                                    Visit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Footer Return Button -->
                    <div class="text-center pt-3 border-top border-light-subtle">
                        <a href="{{ route('tots-feed') }}" class="btn btn-brand rounded-pill px-5 py-2.5 fw-bold">
                            <i class="bi bi-rss me-1"></i> Return to Explore Feed
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </main>
<!-- Bootstrap Bundle with Popper JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- AJAX Interactive Handlers -->
    <script>
        function toggleShowPageLike(btn, postId) {
            btn.disabled = true;

            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                const icon = btn.querySelector('i');
                const likesCount = document.getElementById('show-page-likes-count');
                
                likesCount.textContent = data.likes_count;

                if (data.liked) {
                    icon.className = 'bi bi-heart-fill text-danger';
                    btn.classList.add('liked-active');
                } else {
                    icon.className = 'bi bi-heart text-danger';
                    btn.classList.remove('liked-active');
                }
            })
            .catch(error => console.error('Error toggling like:', error))
            .finally(() => btn.disabled = false);
        }

        function toggleShowPageBookmark(btn, postId) {
            btn.disabled = true;

            fetch(`/posts/${postId}/bookmark`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                const icon = btn.querySelector('i');
                const text = document.getElementById('bookmark-status-text');

                if (data.bookmarked) {
                    icon.className = 'bi bi-bookmark-dash-fill text-primary';
                    text.textContent = 'Saved for Later';
                    btn.classList.add('bookmarked-active');
                } else {
                    icon.className = 'bi bi-bookmark text-secondary';
                    text.textContent = 'Save for Later';
                    btn.classList.remove('bookmarked-active');
                }
            })
            .catch(error => console.error('Error toggling bookmark:', error))
            .finally(() => btn.disabled = false);
        }
    </script>
</body>
</html>