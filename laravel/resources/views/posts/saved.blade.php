<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Saved Queue - Tots Reading List</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Library View CSS styling -->
    <link rel="stylesheet" href="{{ asset('css/library.css') }}">
    <style>
        .unsave-btn {
            background-color: #fff1f2;
            color: #f43f5e;
            border: 1px solid #fecdd3;
            transition: all 0.2s ease;
        }
        .unsave-btn:hover {
            background-color: #e11d48;
            color: #ffffff;
            border-color: #e11d48;
        }
    </style>
</head>
<body class="bg-library">
    <!-- Header Navigation -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand navbar-custom py-3">
            <div class="container">
                <div class="d-flex align-items-center gap-1">
                    <a class="navbar-brand fw-extrabold fs-3 text-brand" href="{{ route('pages.index') }}" style="letter-spacing: -0.5px;">
                        tots<span class="text-accent">.</span>
                    </a>
                    <span class="text-muted border-start ps-2 py-1">Saved Queue</span>
                </div>
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('tots-feed') }}" class="btn btn-outline-custom btn-sm rounded-circle">
                        <i class="bi bi-globe"></i>
                    </a>
                    <a href="{{ route('pages.index') }}" class="btn btn-outline-custom btn-sm rounded-circle">
                        <i class="bi bi-speedometer2"></i>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main Content Area -->
    <main class="py-5 pt-2">
        <div class="container">
            <div class="mb-5">
                <h1 class="fw-extrabold text-dark tracking-tight mb-1">My Saved Queue</h1>
                <p class="text-muted mb-0">High-intent stories and references you have bookmarked to digest later.</p>
            </div>
            <!-- Empty Queue Slate -->
            @if($posts->isEmpty())
                <div class="card empty-library-card p-5 border-0 text-center rounded-4 shadow-sm bg-white">
                    <div class="empty-icon-wrapper mx-auto mb-3">
                        <i class="bi bi-bookmark-dash-fill fs-3 text-brand"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Your reading queue is empty</h4>
                    <p class="text-secondary small mx-auto mb-4" style="max-width: 450px;">
                        No bookmarks configured yet. Browse your community social feed and pin high-quality stories to read later.
                    </p>
                    <a href="{{ route('tots-feed') }}" class="btn btn-brand rounded-pill px-4 py-2.5">
                        <i class="bi bi-search me-1"></i> Discover Stories to Save
                    </a>
                </div>
            @else
                <!-- Dynamic Bookmarked Grid -->
                <div class="row g-4" id="saved-queue-grid">
                    @foreach($posts as $post)
                        <div class="col-md-6 col-lg-4 story-item-card">
                            <div class="card library-card border-0 shadow-sm rounded-4 h-100 overflow-hidden d-flex flex-column">
                                <!-- Post Cover Header -->
                                <div class="position-relative overflow-hidden library-card-header">
                                    @if($post->featured_image)
                                        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="library-card-img">
                                    @else
                                        <div class="library-placeholder-img d-flex align-items-center justify-content-center text-center p-3">
                                            <div>
                                                <i class="bi bi-journal-text fs-1 text-brand opacity-25"></i>
                                                <span class="d-block small text-muted mt-2">No cover image uploaded</span>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Floating Author Tag -->
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-white text-dark shadow-sm border rounded-pill px-2.5 py-1.5 small d-flex align-items-center gap-1">
                                            <i class="bi bi-person-fill text-brand"></i> @ {{ $post->user->username }}
                                        </span>
                                    </div>
                                </div>
                                <!-- Card Content Body -->
                                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                    <h5 class="fw-bold text-dark mb-2 library-card-title line-clamp-2">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-brand-link">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <p class="text-secondary small mb-4 line-clamp-3">
                                        {{ $post->excerpt ?? 'No summary available.' }}
                                    </p>
                                    <!-- Stats Metrics -->
                                    <div class="d-flex gap-3 align-items-center text-muted small mt-auto border-top pt-3 border-light-subtle">
                                        <span><i class="bi bi-clock"></i> {{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min read</span>
                                        <span>&bull;</span>
                                        <span><i class="bi bi-eye"></i> {{ $post->views }} reads</span>
                                    </div>
                                </div>
                                <!-- Card Action Footer -->
                                <div class="card-footer bg-light border-0 p-3 d-flex gap-2 justify-content-between">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-brand btn-sm rounded-pill flex-grow-1 py-1 fw-semibold">
                                        <i class="bi bi-book-half me-1"></i> Read
                                    </a>
                                    <button type="button" class="btn unsave-btn btn-sm rounded-pill px-3 py-1" 
                                            title="Remove from queue"
                                            onclick="unsaveFromQueue(this, '{{ $post->id }}')">
                                        <i class="bi bi-bookmark-dash-fill me-1"></i> Unsave
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Simple Pagination links matching standard setups -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $posts->links('pagination::simple-bootstrap-5') }}
                </div>
            @endif

        </div>
    </main>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- AJAX Queue Removal Handler -->
<script>
    function unsaveFromQueue(btn, postId) {
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
            if (!data.bookmarked) {
                // Smooth visual fade out and translation slide away
                const cardItem = btn.closest('.story-item-card');
                cardItem.style.transition = 'all 0.35s cubic-bezier(0.4, 0, 0.2, 1)';
                cardItem.style.opacity = '0';
                cardItem.style.transform = 'scale(0.92) translateY(10px)';
                
                setTimeout(() => {
                    cardItem.remove();
                    // If no more items are present on the layout, refresh to draw empty state
                    const remaining = document.querySelectorAll('.story-item-card');
                    if (remaining.length === 0) {
                        location.reload();
                    }
                }, 350);
            } else {
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('AJAX removal failed:', error);
            btn.disabled = false;
        });
    }
</script>
</body>
</html>