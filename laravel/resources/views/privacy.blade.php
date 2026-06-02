<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Privacy Policy - Tots</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Separated CSS -->
    <link rel="stylesheet" href="{{ asset('css/privacy.css') }}">
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
    <!-- Privacy Policy Content -->
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <!-- Policy Header -->
                    <div class="text-center mb-5">
                        <h1 class="display-5 fw-extrabold text-slate-900 mb-3">Privacy Policy</h1>
                        <p class="text-secondary">Last updated: May 30, 2026</p>
                    </div>
                    <!-- Policy Card Container -->
                    <div class="card policy-card p-4 p-md-5 mb-5">
                        <p class="lead text-secondary mb-2">
                            At Tots, we respect your privacy and are committed to protecting the personal data you share with us. This Privacy Policy explains how we collect, use, and safeguard your information when you write, connect, and read stories on our platform.
                        </p>
                        <hr class="my-4 border-light-subtle">
                        <!-- Section 1 -->
                        <section class="mb-5">
                            <h3 class="fw-bold text-dark mb-3">1. Information We Collect</h3>
                            <p class="text-secondary">We collect information to provide a better, more connected blogging experience for our users. This includes:</p>
                            <ul class="text-secondary ps-3 mb-0">
                                <li class="mb-2"><strong>Account Information:</strong> When you register on Tots, we collect your name, username, email address, and account password.</li>
                                <li class="mb-2"><strong>Profile Data:</strong> If you choose, you may provide a public bio, profile avatar, and website links.</li>
                                <li class="mb-2"><strong>Content Data:</strong> We store the articles, drafts, comments, and interactions you actively publish on the platform.</li>
                            </ul>
                        </section>
                        <!-- Section 2 -->
                        <section class="mb-5">
                            <h3 class="fw-bold text-dark mb-3">2. How We Use Your Information</h3>
                            <p class="text-secondary">Your data helps us power and personalize the Tots platform. We use it to:</p>
                            <ul class="text-secondary ps-3 mb-0">
                                <li class="mb-2">Deliver your blog posts to the community and manage your author page.</li>
                                <li class="mb-2">Suggest relevant articles, topics, and authors matching your reading habits.</li>
                                <li class="mb-2">Protect against fraudulent, abusive, or harmful activities on our servers.</li>
                            </ul>
                        </section>
                        <!-- Section 3 -->
                        <section class="mb-5">
                            <h3 class="fw-bold text-dark mb-3">3. Data Sharing & Public Visibility</h3>
                            <p class="text-secondary">
                                Tots is a social publishing community. By default, your profile name, public username, bio, and published stories are visible to anyone visiting the platform. Drafts remain completely private until you choose to hit publish. We do not sell or lease your personal contact information to third-party advertisers.
                            </p>
                        </section>
                        <!-- Section 4 -->
                        <section class="mb-5">
                            <h3 class="fw-bold text-dark mb-3">4. Cookies and Analytical Tools</h3>
                            <p class="text-secondary">
                                We utilize basic cookies and secure tracking technologies to keep you securely signed in across different sessions and to generate general analytics regarding visitor counts and page popularity. You can easily manage or reject cookies directly through your local web browser settings.
                            </p>
                        </section>
                        <!-- Section 5 -->
                        <section class="mb-0">
                            <h3 class="fw-bold text-dark mb-3">5. Contact Us</h3>
                            <p class="text-secondary mb-3">
                                If you have questions about how we handle your data or would like to request account and data deletion, please reach out to us:
                            </p>
                            <div class="contact-box p-3 rounded d-flex align-items-center gap-3">
                                <div class="contact-icon-wrapper">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Privacy Support Team</h6>
                                    <small class="text-brand">privacy@tots-blog.com</small>
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