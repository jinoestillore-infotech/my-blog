<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Your Tots</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Reusing custom editor CSS styled perfectly for Tots branding -->
    <link rel="stylesheet" href="{{ asset('css/editor.css') }}">
    <style>
        .content-input {
            overflow: auto;
            resize: none;
        }
    </style>
</head>
<body class="bg-editor">

    <!-- Editor Header Controls -->
    <header class="sticky-top bg-white border-bottom py-2">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="/tots" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <span class="text-muted border-start ps-3 py-1 d-none d-sm-inline-block">Edit Story Workspace</span>
            </div>
        </div>
    </header>

    <!-- Main Workspace Container -->
    <main class="py-3">
        <div class="container">
            <!-- System Error Alerts Display -->
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-4 p-4 mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-octagon-fill text-danger fs-4 me-2"></i>
                        <h6 class="fw-bold mb-0 text-danger">Please fix the following validation errors:</h6>
                    </div>
                    <ul class="mb-0 text-secondary ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <!-- LEFT COLUMN: Content Editor Canvas -->
                    <div class="col-lg-8">
                        <div class="card editor-card border-0 shadow-sm h-100 rounded-4 p-4 pb-1 p-md-5">
                            <!-- Large Title Textarea -->
                            <div class="mb-4">
                                <label for="title" class="form-label text-uppercase text-muted tracking-wide fw-bold">Title</label>
                                <textarea name="title" id="title" class="form-control title-input" rows="1" placeholder="Title your masterpiece..." required>{{ old('title', $post->title) }}</textarea>
                            </div>
                            <!-- Excerpt/Short Summary Box -->
                            <div class="mb-4">
                                <label for="excerpt" class="form-label text-uppercase text-muted tracking-wide fw-bold">Short Excerpt</label>
                                <textarea name="excerpt" id="excerpt" class="form-control excerpt-input" rows="2" placeholder="Write a catchy 2-3 sentence overview that captures readers' attention...">{{ old('excerpt', $post->excerpt) }}</textarea>
                            </div>
                            <!-- Main Body Text Canvas -->
                            <div class="mb-3">
                                <label for="content" class="form-label text-uppercase text-muted tracking-wide fw-bold">Story Body</label>
                                <textarea name="content" id="content" class="form-control content-input" placeholder="Start your story here..." rows="7" required>{{ old('content', $post->content) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT COLUMN: Publishing Panel Sidebar -->
                    <div class="col-lg-4">
                        <div class="card sidebar-card border-0 shadow-sm h-100 rounded-4 p-4 pb-2 mb-4 sticky-lg-top-sidebar">
                            <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                                <i class="bi bi-sliders2 text-brand"></i>Publishing Settings
                            </h5>
                            <!-- Document Status Select -->
                            <div class="mb-4">
                                <label for="status" class="form-label text-uppercase text-muted tracking-wide small fw-bold">Post Visibility Status</label>
                                <select class="form-select custom-select" name="status" id="status">
                                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft (Private)</option>
                                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published (Public)</option>
                                </select>
                            </div>
                            <!-- Cover Image upload block -->
                            <div class="mb-4">
                                <label class="form-label text-uppercase text-muted tracking-wide small fw-bold d-block">Featured Cover Image</label>
                                <div class="upload-zone rounded-4 text-center p-3 position-relative d-flex align-items-center justify-content-center overflow-hidden" id="preview-container">
                                    @if($post->featured_image)
                                        <img src="{{ asset($post->featured_image) }}" id="image-preview" class="img-fluid rounded-3" alt="Post cover">
                                    @else
                                        <img src="" id="image-preview" class="img-fluid rounded-3 d-none" alt="Preview Cover">
                                    @endif
                                    <div id="upload-placeholder" class="py-3 {{ $post->featured_image ? 'd-none' : '' }}">
                                        <div class="upload-icon-wrapper mx-auto mb-2">
                                            <i class="bi bi-image text-brand fs-4"></i>
                                        </div>
                                        <span class="d-block small fw-bold text-dark mb-1">Upload banner photo</span>
                                        <span class="d-block text-muted" style="font-size: 0.75rem;">JPEG, PNG, WEBP (Max 2MB)</span>
                                    </div>
                                </div>
                                <div class="mt-3 mb-0 pb-0">
                                    <input class="form-control form-control-sm border-0 bg-light rounded-pill" type="file" id="featured_image" name="featured_image" accept="image/*" onchange="previewUpload(this)">
                                    <small class="text-muted d-block mt-1.5 fs-11">Recommended resolution: 1200x630. If empty, the existing image will remain.</small>
                                </div>
                            </div>
                            <!-- Actions triggers -->
                            <div class="d-grid gap-2 pb-0 mt-3">
                                <button type="submit" class="btn btn-brand rounded-pill py-2.5">
                                    <i class="bi bi-cloud-arrow-up-fill"></i> Save Changes
                                </button>
                                <a href="{{ route('posts.index') }}" class="btn btn-outline-custom btn-sm text-center rounded-pill px-3 py-2">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Image Preview Script and Auto-growth for title text area -->
    <script>
        // Real-time Upload Preview Logic
        function previewUpload(input) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        // Auto-growth height controller for Title text area
        const titleArea = document.getElementById('title');
        titleArea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        // Initialize growth immediately on page load
        window.addEventListener('load', () => {
            titleArea.style.height = 'auto';
            titleArea.style.height = (titleArea.scrollHeight) + 'px';
        });
    </script>
</body>
</html>