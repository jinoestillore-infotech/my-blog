<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Terms of Service - Tots</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Separated CSS -->
    <link rel="stylesheet" href="{{ asset('css/terms.css') }}">
</head>
<body>
    <!-- Simple Navigation Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-3">
            <div class="container">
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="/" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <a href="/" class="btn btn-outline-custom btn-sm px-4 d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Back to Home
                </a>
            </div>
        </nav>
    </header>
    <!-- Terms of Service Content -->
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <!-- Terms Header -->
                    <div class="text-center mb-5">
                        <h1 class="display-5 fw-extrabold text-slate-900 mb-3">Terms of Service</h1>
                        <p class="text-secondary">Last updated: {{ date('F d, Y') }}</p>
                    </div>
                    <!-- Terms Card Container -->
                    <div class="card terms-card p-4 p-md-5 mb-5">
                        <p class="lead text-secondary mb-2">
                            Welcome to Tots! These Terms of Service ("Terms") govern your access to and use of our website, services, and community platform. By using Tots, you agree to be bound by these Terms.
                        </p>
                        <hr class="my-4 border-light-subtle">
                        <!-- Section 1 -->
                        <section class="mb-5">
                            <h3 class="fw-bold text-dark mb-3">1. Account Registration</h3>
                            <p class="text-secondary">
                                To publish articles and interact with the Tots community, you must register for an account. When creating your account, you agree to:
                            </p>
                            <ul class="text-secondary ps-3 mb-0">
                                <li class="mb-2">Provide accurate, current, and complete details about yourself.</li>
                                <li class="mb-2">Maintain the security and confidentiality of your password.</li>
                                <li class="mb-2">Promptly notify us if you discover or suspect any unauthorized access to your account.</li>
                            </ul>
                        </section>
                        <!-- Section 2 -->
                        <section class="mb-5">
                            <h3 class="fw-bold text-dark mb-3">2. Content & Intellectual Property</h3>
                            <p class="text-secondary">
                                You own all the rights to the stories, images, and content you write and publish on Tots. However, by publishing on our platform:
                            </p>
                            <ul class="text-secondary ps-3 mb-0">
                                <li class="mb-2"><strong>License to Tots:</strong> You grant us a non-exclusive, royalty-free, worldwide license to host, display, and distribute your content across our platform.</li>
                                <li class="mb-2"><strong>Originality:</strong> You declare that you own or have the proper permissions for all parts of the stories you share. Plagiarism is strictly prohibited.</li>
                            </ul>
                        </section>
                        <!-- Section 3 -->
                        <section class="mb-5">
                            <h3 class="fw-bold text-dark mb-3">3. Acceptable Use Policy</h3>
                            <p class="text-secondary">
                                Tots is a space built for collaboration and healthy storytelling. We expect all community members to interact with respect. You agree not to engage in:
                            </p>
                            <ul class="text-secondary ps-3 mb-3">
                                <li class="mb-2">Harassment, hate speech, or targeted abuse of other writers.</li>
                                <li class="mb-2">Spamming, posting repetitive promotional links, or spreading deceptive content.</li>
                                <li class="mb-2">Attempts to compromise the security of the server or platform.</li>
                            </ul>
                            <p class="text-secondary mb-0">
                                We reserve the right to remove articles or terminate accounts that breach this code of conduct.
                            </p>
                        </section>
                        <!-- Section 4 -->
                        <section class="mb-5">
                            <h3 class="fw-bold text-dark mb-3">4. Limitation of Liability</h3>
                            <p class="text-secondary">
                                Tots is provided "as is" and "as available" without any warranties of any kind. We do not guarantee uninterrupted platform uptime, error-free operations, or absolute preservation of your drafted content. Writers are encouraged to keep backups of their original drafts.
                            </p>
                        </section>
                        <!-- Section 5 -->
                        <section class="mb-0">
                            <h3 class="fw-bold text-dark mb-3">5. Termination</h3>
                            <p class="text-secondary mb-3">
                                You have the right to close your account and delete your content at any time. We also reserve the right to suspend or close accounts that consistently violate these Terms, without prior notification.
                            </p>
                            <div class="support-box p-3 rounded d-flex align-items-center gap-3">
                                <div class="support-icon-wrapper">
                                    <i class="bi bi-question-circle-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Have questions?</h6>
                                    <small class="text-brand">support@tots-blog.com</small>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer Section -->
    <footer class="bg-dark text-light py-5">
        <div class="container text-center">
            <span class="fw-extrabold fs-4 text-white">tots<span class="text-accent">.</span></span>
            <p class="text-light opacity-50 small mt-2 mb-0">&copy; {{ date('Y') }} Tots. All rights reserved.</p>
        </div>
    </footer>
    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>