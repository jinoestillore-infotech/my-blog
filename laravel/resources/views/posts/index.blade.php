<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tots Library</title>
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Library View CSS -->
    <link rel="stylesheet" href="{{ asset('css/library.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
</head>
<body class="bg-library">
    <!-- Header Navigation -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand navbar-custom py-2">
            <div class="container">
                <div class="d-flex align-items-center gap-3">
                    <a class="navbar-brand fw-extrabold fs-3 text-brand" href="/tots" style="letter-spacing: -0.5px;">
                        tots<span class="text-accent">.</span>
                    </a>
                    <span class="text-muted border-start ps-3 py-1">My Library</span>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main Content Grid -->
    <main class="py-5 pt-3">
        <div class="container">
            <a href="{{ route('pages.index') }}" class="btn btn-sm rounded-pill mt-1 mb-2">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            <!-- Library Heading and Header Controls -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
                <div>
                    <h1 class="fw-extrabold text-dark tracking-tight mb-1">Tots Library</h1>
                    <p class="text-muted mb-0">Manage, organize, edit, and keep track of your drafts and published works.</p>
                </div>
                <!-- Simple filter metrics tabs -->
                <div class="d-flex gap-2 bg-white p-1.5 rounded-pill border shadow-sm">
                    <a class="btn btn-filter rounded-pill px-3 py-1.5 small {{ request('status', 'all') == 'all' ? 'active' : '' }}" href="?status=all">
                        All ({{ $allCount }})
                    </a>
                    <a class="btn btn-filter rounded-pill px-3 py-1.5 small {{ request('status') == 'published' ? 'active' : '' }}" href="?status=published">
                        Published ({{ $publishedCount }})
                    </a>
                    <a class="btn btn-filter rounded-pill px-3 py-1.5 small {{ request('status') == 'draft' ? 'active' : '' }}" href="?status=draft">
                        Drafts ({{ $draftCount }})
                    </a>
                </div>
            </div>
            <!-- Empty State Check -->
            @if($posts->isEmpty())
                <div class="card empty-library-card p-5 border-0 text-center rounded-4 shadow-sm">
                    <div class="empty-icon-wrapper mx-auto mb-3">
                        <i class="bi bi-journals fs-3 text-brand"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Your library is currently empty</h4>
                    <p class="text-secondary small mx-auto mb-4" style="max-width: 450px;">
                        You haven't written any drafts or stories yet. Let's tap into your creative mind and start your very first post!
                    </p>
                    <a href="/write" class="btn btn-brand rounded-pill px-4 py-2.5">
                        <i class="bi bi-pencil-square me-1"></i> Start Writing Now
                    </a>
                </div>
            @else
                <!-- Dynamic Stories Library Cards Grid -->
                <div class="row g-4" id="stories-grid">
                    @foreach($posts as $post)
                        <div class="col-md-6 col-lg-4 story-item-card" data-status="{{ $post->status }}">
                            <div class="card library-card border-0 shadow-sm rounded-4 h-100 overflow-hidden d-flex flex-column">
                                <!-- Post Cover Header -->
                                <div class="position-relative overflow-hidden library-card-header">
                                    @if($post->featured_image)
                                        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="library-card-img">
                                    @else
                                        <!-- Geometric Placeholder Image styled nicely -->
                                        <div class="library-placeholder-img d-flex align-items-center justify-content-center text-center p-3">
                                            <div>
                                                <i class="bi bi-journal-text fs-1 text-brand opacity-25"></i>
                                                <span class="d-block small text-muted mt-2">No cover image uploaded</span>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Floating Status Badges -->
                                    <div class="position-absolute top-0 start-0 m-3">
                                        @if($post->status === 'published')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1.5">
                                                <i class="bi bi-cloud-check-fill me-1"></i> Published
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2.5 py-1.5">
                                                <i class="bi bi-pencil-fill me-1"></i> Draft
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Card Content Body -->
                                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                    <h5 class="fw-bold text-dark mb-2 library-card-title line-clamp-2">
                                        {{ $post->title }}
                                    </h5>
                                
                                    <p class="text-secondary small mb-4 line-clamp-3">
                                        {{ $post->excerpt ?? 'No summary available.' }}
                                    </p>
                                    <!-- Stats Metric Line -->
                                    <div class="d-flex gap-3 align-items-center text-muted small mt-auto border-top pt-3 border-light-subtle">
                                        <span><i class="bi bi-eye"></i> {{ $post->views ?? 0 }} reads</span>
                                        <span>&bull;</span>
                                        <span><i class="bi bi-calendar3"></i> {{ $post->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <!-- Card Action Footer -->
                                <div class="card-footer bg-white border-0 p-3 pt-0 d-flex gap-2 justify-content-between">
                                    <!-- Edit Link -->
                                    <a href="/posts/{{ $post->id }}/edit" class="btn btn-light-custom btn-sm rounded-pill flex-grow-1 py-2">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <!-- Trigger custom delete modal instead of browser confirm -->
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill flex-grow-1 py-2" 
                                            onclick="triggerDeleteModal('{{ route('posts.destroy', $post->id) }}', '{{ addslashes($post->title) }}')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between mt-4">
                    @if ($posts->previousPageUrl())
                        <a href="{{ $posts->previousPageUrl() }}"
                        class="btn btn-outline-secondary rounded-pill px-3">
                            ← Previous
                        </a>
                    @endif

                    @if ($posts->nextPageUrl())
                        <a href="{{ $posts->nextPageUrl() }}"
                        class="btn btn-outline-primary rounded-pill px-3">
                            Load More →
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </main>
    <!-- Beautiful Reusable Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-danger-subtle text-danger pt-4 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                        <h5 class="modal-title fw-extrabold" id="deleteConfirmModalLabel">
                            Delete 
                            @if($post->status === 'published') 
                            Published
                            @else
                            Drafted
                            @endif
                            Story</h5>
                    </div>
                </div>
                <div class="modal-body px-4 py-4">
                    <p class="text-secondary mb-3">Are you sure you want to permanently delete this story?</p>
                    <p class="fw-bold text-dark mb-0 bg-light p-3 rounded-3 border-start border-danger border-3" id="delete-story-title-display"></p>
                    <p class="text-danger small mt-2 mb-0"><i class="bi bi-info-circle"></i> This operation is permanent and cannot be undone.</p>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 pt-0">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 py-2 text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="delete-story-form" method="POST" class="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4 py-2">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Dynamic Filter Client-side Script -->
<script>
    // function filterStories(event, status) {
    //     const buttons = document.querySelectorAll('.btn-filter');
    //     buttons.forEach(btn => btn.classList.remove('active'));
    //     event.target.classList.add('active');
    //     const cards = document.querySelectorAll('.story-item-card');
    //     cards.forEach(card => {
    //         if (status === 'all') {
    //             card.classList.remove('d-none');
    //         } else {
    //             card.classList.toggle(
    //                 'd-none',
    //                 card.getAttribute('data-status') !== status
    //             );
    //         }
    //     });
    // }

    // Custom Modal triggering handler for delete action
    function triggerDeleteModal(actionUrl, storyTitle) {
        // Update modal text dynamically
        document.getElementById('delete-story-title-display').textContent = storyTitle;
        
        // Assign action url directly to the hidden form
        const form = document.getElementById('delete-story-form');
        form.action = actionUrl;
        
        // Present the modal
        const myModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        myModal.show();
    }
</script>
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