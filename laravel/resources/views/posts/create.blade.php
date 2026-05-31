<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Write Your Tots</title>
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
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
</head>
<body class="bg-editor">
    <!-- Distraction-free Writing Navbar -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand navbar-custom py-2">
            <div class="container">
                <div class="d-flex align-items-center gap-3">
                    <a class="navbar-brand fw-extrabold fs-3 text-brand" href="{{ route('pages.index') }}" style="letter-spacing: -0.5px;">
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
            <form id="post-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
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
                    @include('posts.partials.form')
                </div>
            </form>
        </div>

        <div class="modal fade" id="aiImproveModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-4 border-0">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-robot me-2 text-brand"></i>
                        Tots Bot Improved Version
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-2">
                        Review the improved version before applying it to your draft.
                    </p>
                    <textarea id="ai-improved-text"
                            class="form-control"
                            rows="12"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-brand" id="apply-ai-text">
                        Use This Version
                    </button>
                </div>
            </div>
        </div>

    </main>
    <script>
    const form = document.getElementById('post-form');
    const submitBtn = document.getElementById('submit-btn');

    const submitText = document.getElementById('submit-text');
    const submitLoading = document.getElementById('submit-loading');

    let isSubmitting = false;
    form.addEventListener('submit', function () {
        // Prevent multiple submissions
        if (isSubmitting) {
            return false;
        }
        isSubmitting = true;
        // Disable button
        submitBtn.disabled = true;
        // Show loading state
        submitText.classList.add('d-none');
        submitLoading.classList.remove('d-none');
    });
</script>
<!-- Bootstrap Bundle with Popper JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Dynamic Image File Reader Preview Scripts -->
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
<script>
    document.getElementById('apply-ai-text').addEventListener('click', function () {
    const contentEl = document.getElementById('content');
    const improved = document.getElementById('ai-improved-text').value;

    contentEl.value = improved;

    // close modal
    const modalEl = document.getElementById('aiImproveModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();

    showToast("AI version applied successfully.", "success");
});

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
    async function improveGrammar() {
        const contentEl = document.getElementById('content');
        const original = contentEl.value;

        if (!original.trim()) {
            showToast("Write something first before improving.", "error");
            return;
        }

        showToast("Wait 1-2 minutes Tots Bot is improving your writing.", "success");

        const res = await fetch("{{ route('ai.improve') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ text: original })
        });

        const data = await res.json();

        if (data.success) {

            // put improved text in modal
            document.getElementById('ai-improved-text').value = data.text;

            // show modal
            const modal = new bootstrap.Modal(document.getElementById('aiImproveModal'));
            modal.show();
            showToast("AI suggestion ready.", "success");
        } else {
            showToast(data.message || "AI failed.", "error");
        }
    }
</script>
</body>
</html>