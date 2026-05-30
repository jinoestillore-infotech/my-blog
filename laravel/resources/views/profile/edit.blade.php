<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Profile - Tots Workspace</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Profile Editor CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body class="bg-profile">
    <!-- Simple Navigation Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand navbar-custom py-2">
            <div class="container">
                <div class="d-flex align-items-center gap-3">
                    <a class="navbar-brand fw-extrabold fs-3 text-brand" href="{{ route('pages.index') }}" style="letter-spacing: -0.5px;">
                        tots<span class="text-accent">.</span>
                    </a>
                    <span class="text-muted border-start ps-3 py-1">Author Profile Settings</span>
                </div>
            </div>
        </nav>
    </header>
    <!-- Settings Workspace Container -->
    <main class="py-3">
        <div class="container">
            <!-- Form Error Handler -->
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                        <h6 class="fw-bold mb-0 text-dark">Please fix the errors below:</h6>
                    </div>
                    <ul class="mb-0 text-secondary ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card settings-card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h2 class="fw-extrabold text-dark tracking-tight mb-1">Author Settings</h2>
                        <p class="text-muted mb-4 pb-3 border-bottom">Update your public credentials, biography details, and brand identity.</p>
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-4 align-items-center mb-5">
                                <!-- Profile Photo Upload (Left Circle Widget) -->
                                <div class="col-md-3 text-center">
                                    <div class="avatar-upload-wrapper mx-auto position-relative">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" id="avatar-preview" class="avatar-preview-image object-fit-cover rounded-circle w-100 h-100" alt="Avatar">
                                        @else
                                            <div id="avatar-placeholder" class="avatar-preview-image rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-extrabold fs-2 w-100 h-100">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <img src="" id="avatar-preview" class="avatar-preview-image object-fit-cover rounded-circle d-none w-100 h-100" alt="Avatar Preview">
                                        @endif
                                        <div class="avatar-hover-overlay rounded-circle d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100">
                                            <i class="bi bi-camera-fill text-white fs-3"></i>
                                            <input type="file" name="avatar" id="avatar" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" accept="image/jpeg,image/png,image/jpg,image/webp">
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">Click photo to update</small>
                                </div>
                                <!-- Explanation of Bio -->
                                <div class="col-md-9 text-center text-md-start">
                                    <h5 class="fw-bold text-dark mb-1">Your Author Avatar</h5>
                                    <p class="text-secondary small mb-0" style="max-width: 480px;">
                                        This image will represent you across our collaborative publications, writer community feeds, and landing page previews. PNG, JPG or WEBP (Max 2MB).
                                    </p>
                                </div>
                            </div>
                            <!-- Input form elements -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label small fw-bold text-secondary">Display Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="username" class="form-label small fw-bold text-secondary">Username (Unique handle)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted">@</span>
                                        <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label small fw-bold text-secondary">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="bio" class="form-label small fw-bold text-secondary">Author Bio</label>
                                    <textarea name="bio" id="bio" class="form-control bio-textarea" rows="4" maxlength="1000" placeholder="Tell the Tots community who you are. What topics do you focus on?">{{ old('bio', $user->bio) }}</textarea>
                                    <div class="form-text text-muted small">Max 1000 characters. Standard Markdown/Plaintext descriptions supported.</div>
                                </div>
                            </div>
                            <hr class="my-4 text-muted opacity-10">
                            <!-- Submit button triggers -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('pages.index') }}" class="btn btn-outline-custom rounded-pill px-4 py-2">Cancel</a>
                                <button type="submit" class="btn btn-brand rounded-pill px-4 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Avatar Realtime Preview Script -->
    <script>
        document.getElementById('avatar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatar-preview');
                    const placeholder = document.getElementById('avatar-placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>