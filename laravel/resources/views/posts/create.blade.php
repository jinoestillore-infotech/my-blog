<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Write a New Story - Tots</title>
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Separated Editor CSS -->
    <link rel="stylesheet" href="{{ asset('css/editor.css') }}">
</head>
<body class="bg-editor">
    <!-- Distraction-free Writing Navbar -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand navbar-custom py-3">
            <div class="container">
                <div class="d-flex align-items-center gap-3">
                    <a class="navbar-brand fw-extrabold fs-3 text-brand" href="/dashboard" style="letter-spacing: -0.5px;">
                        tots<span class="text-accent">.</span>
                    </a>
                    <span class="text-muted border-start ps-3 py-1">New Draft</span>
                </div>
                <div class="ms-auto d-flex align-items-center gap-2">
                </div>
            </div>
        </nav>
    </header>
    <!-- Editor Main Form Section -->
    <main class="py-3">
        <div class="container">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Display Validation Error Alert Banner if any errors are detected -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                            <h6 class="fw-bold mb-0 text-dark">Please fix the validation errors below:</h6>
                        </div>
                        <ul class="mb-0 text-secondary ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row g-3">
                    <!-- Left Main Content Column: Writer Canvas -->
                    <div class="col-lg-8">
                        <div class="card editor-card p-4 p-md-5 border-0 shadow-sm h-100 rounded-4">
                            <!-- Large Stylized Post Title Input -->
                            <div class="mb-1">
                                <label for="title" class="visually-hidden">Story Title</label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       class="form-control title-input border-0 bg-transparent px-0 @error('title') is-invalid @enderror" 
                                       placeholder="Title of your story..." 
                                       value="{{ old('title') }}" 
                                       required 
                                       autocomplete="off">
                                @error('title')
                                    <div class="invalid-feedback ps-1 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr class="editor-divider my-3">
                            <!-- Minimalist Writing Text Area -->
                            <div class="mb-4">
                                <label for="content" class="visually-hidden">Write your thoughts...</label>
                                <textarea name="content" 
                                          id="content" 
                                          class="form-control content-input border-0 bg-transparent px-0 @error('content') is-invalid @enderror" 
                                          rows="12" 
                                          placeholder="Tell your story. Tap into your imagination, research notes, and insights..." 
                                          required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback ps-1 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Right Sidebar Column: Publishing Control Panel -->
                    <div class="col-lg-4">
                        <!-- Publishing Options Card -->
                        <div class="card sidebar-card p-4 border-0 shadow-sm rounded-4 h-100 mb-4">
                            <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                                <i class="bi bi-sliders text-brand"></i> Publish Controls
                            </h5>
                            <!-- Cover/Featured Image Upload Zone -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Cover Image</label>
                                <div class="upload-zone position-relative text-center p-4 rounded-4" id="upload-zone">
                                    <input type="file" 
                                           name="featured_image" 
                                           id="featured_image" 
                                           class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" 
                                           accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <!-- Upload Placeholder State -->
                                    <div id="upload-placeholder">
                                        <div class="upload-icon-wrapper mx-auto mb-2">
                                            <i class="bi bi-image text-brand fs-4"></i>
                                        </div>
                                        <span class="d-block small fw-bold text-dark mb-1">Upload banner photo</span>
                                        <span class="d-block text-muted" style="font-size: 0.75rem;">JPEG, PNG, WEBP (Max 2MB)</span>
                                    </div>
                                    <!-- Upload Active Preview State -->
                                    <div id="upload-preview-container" class="d-none">
                                        <img id="image-preview" src="#" alt="Cover Preview" class="img-fluid rounded-3 mb-2 shadow-sm">
                                        <div class="d-flex justify-content-center align-items-center gap-1 text-brand small fw-semibold">
                                            <i class="bi bi-arrow-repeat"></i> Change Image
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Post Visibility Status -->
                            <div class="mb-4">
                                <label for="status" class="form-label small fw-bold text-secondary">Visibility Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Save as Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Immediately</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Custom Story Excerpt (Optional Summary) -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="excerpt" class="form-label small fw-bold text-secondary mb-0">Story Excerpt</label>
                                    <span class="text-muted" style="font-size: 0.75rem;">Optional</span>
                                </div>
                                <textarea name="excerpt" 
                                          id="excerpt" 
                                          class="form-control excerpt-textarea @error('excerpt') is-invalid @enderror" 
                                          rows="3" 
                                          maxlength="500" 
                                          placeholder="A short, catchy summary for preview cards...">{{ old('excerpt') }}</textarea>
                                <div class="form-text text-muted" style="font-size: 0.75rem;">
                                    If left empty, we will auto-generate one from your main text.
                                </div>
                                @error('excerpt')
                                    <div class="invalid-feedback mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr class="text-muted opacity-10 mb-4">
                            <!-- Submit and Save Action Buttons -->
                            <button type="submit" class="btn btn-brand w-100 py-2.5 rounded-pill fw-bold mb-2">
                                <i class="bi bi-check-circle-fill me-1"></i> Save and Publish
                            </button>
                            <a href="{{ route('tots') }}" class="btn btn-outline-custom btn-sm text-center rounded-pill px-3 py-2">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Dynamic Image File Reader Preview Scripts -->
    <script>
        document.getElementById('featured_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update visual state to image preview
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('upload-placeholder').classList.add('d-none');
                    document.getElementById('upload-preview-container').classList.remove('d-none');
                    document.getElementById('upload-zone').classList.add('upload-active');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>