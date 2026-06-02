<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tots - Explore Stories and Connect with Bloggers</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
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
        <nav class="navbar navbar-expand-md navbar-custom py-2">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="{{ route('tots-feed') }}" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-custom btn-sm rounded-pill px-3 py-2 dropdown-toggle d-flex align-items-center gap-2"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                        <span class="text-secondary small fw-bold">
                            Hi, {{ Auth::user()->name }}
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-0 m-0 mt-2 rounded-3">
                        <li class="p-0 m-0">
                            <a class="dropdown-item d-flex align-items-center gap-2 small" href="{{ route('pages.index') }}">
                                <i class="bi bi-speedometer2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li><hr class="dropdown-divider p-0 m-0"></li>
                        <li class="p-0 m-0">
                            <a class="dropdown-item d-flex align-items-center gap-2 small" href="{{ route('settings') }}">
                                <i class="bi bi-gear"></i>
                                Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider p-0 m-0"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger small">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main Container Layout -->
    <main class="pt-4 pb-3">
        <div class="container">
            <div class="row g-4">
                <div class="ms-2 p-1 pb-1 d-flex align-items-center gap-3">
                    @if(Auth::user()->avatar)
                    <img src="{{ asset(Auth::user()->avatar) }}" class="feed-author-img object-fit-cover rounded-circle d-block d-lg-none" alt="Avatar">
                    @else
                    <div class="feed-author-placeholder rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-bold d-block d-lg-none">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    @endif
                    <!-- User details -->
                    <div class="flex-grow-1 d-block d-lg-none">
                        <h6 class="mb-0 fw-bold text-dark">{{ Auth::user()->name }}</h6>
                        <small class="text-muted" style="font-size: .75rem;">&#64;{{ Auth::user()->username }}</small>
                    </div>
                </div>
                <!-- LEFT SIDEBAR: Logged-in User Card -->
                <div class="col-12 col-lg-3">
                    <div class="sticky-sidebar">
                        <!-- Logged In User Quick Sidebar Info Card -->
                        <div class="card profile-card p-4 border-0 shadow-sm rounded-4 text-center mb-2">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" class="profile-avatar mx-auto mb-3 object-fit-cover d-none d-lg-block" alt="Avatar">
                            @else
                                <div class="profile-avatar-placeholder mx-auto mb-3 d-flex align-items-center justify-content-center fw-extrabold text-brand d-none d-md-block">
                                    <i class="bi bi-person fs-1"></i>
                                </div>
                            @endif
                            <h5 class="fw-bold text-dark mb-1 d-none d-lg-block">{{ Auth::user()->name }}</h5>
                            <p class="text-brand small mb-2 d-none d-lg-block">&#64;{{ Auth::user()->username }}</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('posts.create') }}" class="btn btn-brand rounded-pill btn-sm py-2">
                                    <i class="bi bi-pencil-square me-1"></i> Write New Post
                                </a>
                                <a href="{{ route('posts.index') }}" class="btn btn-outline-custom rounded-pill btn-sm py-2">
                                    <i class="bi bi-journal-bookmark-fill me-1"></i> My Library
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2 m-1 p-3 bg-white card shadow-sm border-0">
                            <a href="{{ route('popular') }}" class="text-brand text-decoration-none small fw-semibold gap-1">
                                View Popular Writers <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                        <!-- Dynamic Who To Follow Card suggestions -->
                        <div id="whoToFollowCard" class="card community-widget-card d-lg-none d-md-block p-4 border-0 shadow-0 rounded-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="bi bi-lightning-charge-fill text-accent me-1"></i>
                                    Who to Follow
                                </h6>

                                <div class="dropdown">
                                    <button class="btn btn-sm border-0 p-1 text-muted"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                        <li>
                                            <button class="dropdown-item"
                                                    onclick="hideWhoToFollowCard()">
                                                <i class="bi bi-eye-slash me-2"></i>
                                                Hide
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                @forelse($suggestedUsers as $suggestedUser)
                                    <div class="d-flex align-items-center gap-3">
                                        
                                        <!-- User Avatar or Initials Fallback -->
                                        @if($suggestedUser->avatar)
                                            <img src="{{ asset($suggestedUser->avatar) }}" class="rounded-circle object-fit-cover" style="width: 38px; height: 38px;" alt="Avatar">
                                        @else
                                            <div class="rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-bold small" style="width: 38px; height: 38px;">
                                                {{ strtoupper(substr($suggestedUser->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <!-- User Details -->
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h6 class="mb-0 fw-bold text-dark text-truncate small">{{ $suggestedUser->name }}</h6>
                                            <small class="text-muted d-block text-truncate fs-11">&#64;{{ $suggestedUser->username }}</small>
                                        </div>
                                        
                                        <!-- Interactive Follow Form Button Triggering FollowController AJAX -->
                                        <button type="button" 
                                                class="btn btn-sm rounded-pill px-2.5 py-1 follow-btn btn-outline-brand" 
                                                onclick="toggleFollow(this, '{{ $suggestedUser->id }}')">
                                            Follow
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center py-2">
                                        <p class="text-secondary small mb-0">No suggestions right now!</p>
                                    </div>
                                @endforelse
                            </div>
                            <h6 class="fw-bold text-dark mb-3 mt-4"><i class="bi bi-hash text-brand"></i>Trending Topics</h6>
                            <div class="d-flex flex-wrap gap-1.5">
                                @forelse($trendingTags as $tag => $data)
                                    <!-- Here is where we insert the dynamic data count in a small badge next to the tag name -->
                                    <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1.5 hover-badge" 
                                          style="cursor: pointer;" 
                                          onclick="filterByTag('{{ $tag }}')"
                                          title="Popularity score: {{ round($data['score'], 1) }}">
                                        #{{ $tag }} 
                                        <span class="ms-1 px-1.5 py-0.2 bg-white rounded-circle text-warning border" style="font-size: 0.65rem;">
                                            {{ $data['count'] >= 9 ? '9+' : $data['count'] }}
                                        </span>
                                    </span>
                                @empty
                                    <span class="text-muted small">No popular topics this week.</span>
                                @endforelse
                            </div>
                            <hr class="opacity-10 my-3">
                            <a href="{{ route('writers.search') }}" class="text-brand text-decoration-none small fw-semibold d-flex align-items-center gap-1">
                                Follow/Search Writers <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- CENTER FEED: The Social Explore Post Feed -->
                <div class="col-12 col-md-12 col-lg-6 mx-auto">
                    <!-- Quick Feed Greeting Banner -->
                    <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                        <h4 class="fw-semibold text-dark mb-0">
                            @if(request('tag'))
                                Tag: <span class="text-brand">#{{ request('tag') }}</span>
                            @else
                                Explore Tots Feed
                            @endif
                        </h4>
                        
                        @if(request('tag'))
                            <!-- Elegant Clear Filter Trigger -->
                            <a href="{{ url()->current() }}" class="btn text-danger btn-sm rounded-pill px-3 py-1.5 fw-bold fs-9">
                                <i class="bi bi-x-circle me-1"></i> Clear Filter
                            </a>
                        @else
                            <!-- Interactive Auto-Refresh Control Widget -->
                            <div class="d-flex align-items-center gap-2">
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-outline-custom btn-sm rounded-pill px-2.5 py-1.5 d-flex align-items-center gap-1.5 fs-9 text-secondary border border-light-subtle bg-white hover-brand-link" 
                                            type="button" 
                                            id="autoRefreshDropdown" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false"
                                            style="font-size: 0.75rem;">
                                        <i class="bi bi-arrow-clockwise text-brand me-1" id="refresh-icon"></i>
                                        <span id="refresh-status-text" class="fw-semibold text-muted">Auto: 1 Min</span>
                                        <span class="badge bg-brand-light text-brand font-monospace rounded-pill ms-1 py-0.5 px-1.5" id="refresh-timer" style="font-size: 0.65rem;">60s</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 small p-1" aria-labelledby="autoRefreshDropdown">
                                        <li><button class="dropdown-item rounded-2 py-1.5 small" type="button" onclick="changeRefreshInterval(60, '1 Min')"><i class="bi bi-clock me-1 text-primary"></i>1 Minute</button></li>
                                        <li><button class="dropdown-item rounded-2 py-1.5 small" type="button" onclick="changeRefreshInterval(120, '2 Mins')"><i class="bi bi-clock me-1 text-success"></i>2 Minutes</button></li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li><button class="dropdown-item rounded-2 py-1.5 small" type="button" onclick="changeRefreshInterval(0, 'Off')"><i class="bi bi-slash-circle me-1 text-danger"></i>Turn Off</button></li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- Beautiful Feed Story Search Bar Form -->
                     <div class="d-flex justify-content-end mb-4">
                        <form action="{{ route('tots-feed') }}" method="GET" class="search-bar">
                            <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border border-light-subtle p-1">
                                <span class="input-group-text bg-white border-0 text-muted ps-3">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control border-0 bg-transparent py-2 shadow-none"
                                    placeholder="Search stories by title..."
                                >
                                @if(request('tag'))
                                    <input type="hidden" name="tag" value="{{ request('tag') }}">
                                @endif
                                @if(request('search'))
                                    <a href="{{ route('tots-feed', request()->except('search')) }}"
                                    class="btn btn-link text-decoration-none text-muted d-flex align-items-center px-3 small">
                                        Clear
                                    </a>
                                @endif
                                <button type="submit" class="btn btn-brand rounded-pill px-4">
                                    Search
                                </button>
                            </div>
                        </form>
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
                            <a href="{{ route('posts.create') }}" class="btn btn-brand rounded-pill px-4">Publish First Story</a>
                        </div>
                    @else
                        <!-- Scrollable List of Published Stories -->
                        <div class="d-flex flex-column gap-4" id="posts-container">
                            @include('feed.partials.posts')
                        </div>
                        <!-- Paginated Navigation Controls -->
                        <div class="d-flex justify-content-center mt-3">
                            @if($posts->hasMorePages())
                                <div class="text-center mt-5">
                                    <a href="{{ $posts->nextPageUrl() }}"
                                    class="btn btn-brand rounded-pill px-4"
                                    id="load-more-btn">
                                        Load More Tots.
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <!-- RIGHT SIDEBAR: Community Widget suggestions & Trending Topics -->
                <div class="col-md-4 col-lg-3"> <!-- d-none d-md-block -->
                    <div class="sticky-sidebar">
                        <!-- Dynamic Who To Follow Card suggestions -->
                        <div class="card community-widget-card d-none d-lg-block p-4 border-0 shadow-sm rounded-4 mb-4">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="bi bi-lightning-charge-fill text-accent me-1"></i>Who to Follow
                            </h6>
                            <div class="d-flex flex-column gap-3">
                                @forelse($suggestedUsers as $suggestedUser)
                                    <div class="d-flex align-items-center gap-3">
                                        
                                        <!-- User Avatar or Initials Fallback -->
                                        @if($suggestedUser->avatar)
                                            <img src="{{ asset($suggestedUser->avatar) }}" class="rounded-circle object-fit-cover" style="width: 38px; height: 38px;" alt="Avatar">
                                        @else
                                            <div class="rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-bold small" style="width: 38px; height: 38px;">
                                                {{ strtoupper(substr($suggestedUser->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        
                                        <!-- User Details -->
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h6 class="mb-0 fw-bold text-dark text-truncate small">{{ $suggestedUser->name }}</h6>
                                            <small class="text-muted d-block text-truncate fs-11">&#64;{{ $suggestedUser->username }}</small>
                                        </div>
                                        
                                        <!-- Interactive Follow Form Button Triggering FollowController AJAX -->
                                        <button type="button" 
                                                class="btn btn-sm rounded-pill px-2.5 py-1 follow-btn btn-outline-brand" 
                                                onclick="toggleFollow(this, '{{ $suggestedUser->id }}')">
                                            Follow
                                        </button>
                                    </div>
                                @empty
                                    <div class="text-center py-2">
                                        <p class="text-secondary small mb-0">No suggestions right now!</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            <hr class="opacity-10 my-3">
                            <a href="{{ route('writers.search') }}" class="text-brand text-decoration-none small fw-semibold d-flex align-items-center gap-1">
                                Follow/Search Writers <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                        <!-- Trending Topics tag cloud (True Dynamic Algorithm Output with Mention Counts) -->
                        <div class="card community-widget-card p-4 border-0 shadow-sm rounded-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-hash text-brand"></i>Trending Topics</h6>
                            <div class="d-flex flex-wrap gap-1.5">
                                @forelse($trendingTags as $tag => $data)
                                    <!-- Here is where we insert the dynamic data count in a small badge next to the tag name -->
                                    <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1.5 hover-badge" 
                                          style="cursor: pointer;" 
                                          onclick="filterByTag('{{ $tag }}')"
                                          title="Popularity score: {{ round($data['score'], 1) }}">
                                        #{{ $tag }} 
                                        <span class="ms-1 px-1.5 py-0.2 text-warning" style="font-size: 0.65rem;">
                                            {{ $data['count'] >= 10 ? '9+' : $data['count'] }}
                                        </span>
                                    </span>
                                @empty
                                    <span class="text-muted small">No popular topics this week.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Real AJAX Database Like Handler -->
    <script>
        function hideWhoToFollowCard() {
            const card = document.getElementById('whoToFollowCard');

            card.style.transition = 'opacity .3s ease';
            card.style.opacity = '0';

            setTimeout(() => {
                card.remove();
            }, 300);
        }

        function toggleLike(btn, postId) {
            const icon = btn.querySelector('i');
            const countSpan = btn.querySelector('.reaction-count');

            // Disable button briefly to prevent double clicks during processing
            btn.disabled = true;

            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.liked) {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                    btn.classList.add('liked-active');
                } else {
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                    btn.classList.remove('liked-active');
                }
                countSpan.textContent = data.likes_count;
            })
            .catch(error => {
                console.error('Error toggling like:', error);
            })
            .finally(() => {
                btn.disabled = false;
            });
        }

        function toggleFollow(btn, userId) {
            // Prevent double clicking during active requests
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
                    if (data.is_following) {
                        // UI state when following
                        btn.textContent = 'Following';
                        btn.classList.remove('btn-outline-brand');
                        btn.classList.add('btn-brand', 'text-white');
                    } else {
                        // UI state when unfollowing
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
                console.error('Error handling follow process:', error);
            });
        }

        function filterByTag(tag) {
            const url = new URL(window.location.href);
            // Append target tag as query parameter
            url.searchParams.set('tag', tag);
            // Delete pagination parameter to prevent out-of-bounds page results on the new filter
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        let refreshTimer = null;
        let refreshCountdown = 60; // default value
        let currentInterval = 60;  // dynamic interval placeholder

        function startRefreshTimer() {
            if (refreshTimer) clearInterval(refreshTimer);
            
            if (currentInterval === 0) {
                const timerBadge = document.getElementById('refresh-timer');
                if (timerBadge) timerBadge.classList.add('d-none');
                return;
            }

            const timerBadge = document.getElementById('refresh-timer');
            if (timerBadge) {
                timerBadge.classList.remove('d-none');
                timerBadge.textContent = refreshCountdown + 's';
            }

            refreshTimer = setInterval(() => {
                refreshCountdown--;
                if (timerBadge) {
                    timerBadge.textContent = refreshCountdown + 's';
                }

                if (refreshCountdown <= 0) {
                    clearInterval(refreshTimer);
                    triggerBackgroundFeedRefresh();
                }
            }, 1000);
        }

        function triggerBackgroundFeedRefresh() {
            const statusText = document.getElementById('refresh-status-text');
            const refreshIcon = document.getElementById('refresh-icon');

            if (statusText) statusText.textContent = 'Refreshing...';
            if (refreshIcon) refreshIcon.classList.add('spin-animation');

            // Execute full-page hard reload to pull down fresh data and synchronize with database natively
            setTimeout(() => {
                window.location.reload();
            }, 300);
        }

        function changeRefreshInterval(seconds, displayLabel) {
            currentInterval = seconds;
            refreshCountdown = seconds;
            
            const statusText = document.getElementById('refresh-status-text');
            const timerBadge = document.getElementById('refresh-timer');
            
            if (statusText) {
                statusText.textContent = 'Auto: ' + displayLabel;
            }

            if (seconds === 0) {
                if (refreshTimer) clearInterval(refreshTimer);
                if (timerBadge) timerBadge.classList.add('d-none');
            } else {
                startRefreshTimer();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            startRefreshTimer();
            const loadMoreBtn = document.getElementById('load-more-btn');
            if (!loadMoreBtn) return;

            loadMoreBtn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent normal navigation
                const url = this.href;

                this.disabled = true;
                this.textContent = 'Loading...';

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Parse returned HTML
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newPosts = doc.querySelectorAll('#posts-container > article');

                    // Append new posts
                    const container = document.getElementById('posts-container');
                    newPosts.forEach(post => container.appendChild(post));

                    // Update / replace the Load More button
                    const newBtn = doc.getElementById('load-more-btn');
                    if (newBtn) {
                        loadMoreBtn.href = newBtn.href;
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = 'Load More';
                    } else {
                        loadMoreBtn.remove(); // No more pages
                    }

                    // Re-initialize any JS like toggleLike if needed
                })
                .catch(err => {
                    console.error('Error loading more posts:', err);
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.textContent = 'Load More';
                });
            });
        });
        </script>
</body>
</html>