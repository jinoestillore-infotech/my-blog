<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Community Standards - Tots</title>
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
    <link rel="stylesheet" href="{{ asset('css/community_standards.css') }}">
</head>
<body data-bs-spy="scroll" data-bs-target="#standards-sidebar" data-bs-offset="100" tabindex="0">

    <!-- Simple Navigation Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-3">
            <div class="container">
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="/" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <div class="ms-auto d-flex gap-2">
                    <a href="/" class="btn btn-outline-custom btn-sm px-4 d-none d-sm-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Back to Home
                    </a>
                    @auth
                        <a href="{{ route('tots-feed') }}" class="btn btn-brand btn-sm px-4">Enter Feed</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-brand btn-sm px-4">Log In</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Header Jumbotron -->
    <section class="standards-hero py-5 text-center text-white">
        <div class="container py-3">
            <span class="badge bg-white-transparent rounded-pill px-3 py-1.5 fw-bold text-uppercase tracking-wider mb-3">Our Code of Conduct</span>
            <h1 class="display-4 fw-extrabold mb-3">Tots Community Standards</h1>
            <p class="lead mx-auto mb-0" style="max-width: 650px;">
                Fostering a healthy, respectful, and highly collaborative environment for storytellers and readers worldwide.
            </p>
        </div>
    </section>

    <!-- Main Content Grid -->
    <main class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Left Sticky Sidebar Navigation -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div id="standards-sidebar" class="list-group sticky-sidebar shadow-sm rounded-4 border-0">
                        <a class="list-group-item list-group-item-action active py-3" href="#introduction">
                            <i class="bi bi-bookmark-star-fill me-2"></i> Introduction
                        </a>
                        <a class="list-group-item list-group-item-action py-3" href="#core-values">
                            <i class="bi bi-heart-pulse-fill me-2"></i> Core Values
                        </a>
                        <a class="list-group-item list-group-item-action py-3" href="#unacceptable-behavior">
                            <i class="bi bi-slash-circle-fill me-2"></i> Prohibited Conduct
                        </a>
                        <a class="list-group-item list-group-item-action py-3" href="#reporting-framework">
                            <i class="bi bi-flag-fill me-2"></i> Reporting Framework
                        </a>
                        <a class="list-group-item list-group-item-action py-3" href="#valid-vs-abusive">
                            <i class="bi bi-shield-check me-2"></i> Valid vs. Abusive Flags
                        </a>
                        <a class="list-group-item list-group-item-action py-3" href="#enforcement">
                            <i class="bi bi-gavel me-2"></i> Enforcement Actions
                        </a>
                    </div>
                </div>

                <!-- Right Detailed Standards Prose -->
                <div class="col-12 col-lg-9">
                    <div class="card standards-card p-4 p-md-5 border-0 shadow-sm rounded-4">
                        
                        <!-- Introduction Section -->
                        <section id="introduction" class="mb-5 pt-3">
                            <h2 class="fw-extrabold text-dark mb-3">Introduction</h2>
                            <p class="text-secondary lh-lg">
                                Welcome to Tots! We believe that digital self-expression should be empowering, collaborative, and entirely transparent. Tots is a social publishing community designed to bring diverse voices together to write, connect, and grow.
                            </p>
                            <p class="text-secondary lh-lg">
                                To protect our creators and ensure our space remains safe and inspiring, we have developed these **Community Standards**. By registering an account and publishing content on Tots, you commit to upholding these core parameters and guidelines.
                            </p>
                        </section>

                        <hr class="my-5 opacity-10">

                        <!-- Core Values Section -->
                        <section id="core-values" class="mb-5 pt-3">
                            <h2 class="fw-extrabold text-dark mb-4">Core Values</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 rounded-4 value-box h-100">
                                        <h5 class="fw-bold text-brand mb-2"><i class="bi bi-shield-shaded me-1"></i> Respect</h5>
                                        <p class="text-secondary small mb-0">We value healthy debates and differences of opinion, but we do not tolerate actions intended to intimidate, silence, or degrade others.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-4 value-box h-100">
                                        <h5 class="fw-bold text-brand mb-2"><i class="bi bi-journal-check me-1"></i> Authenticity</h5>
                                        <p class="text-secondary small mb-0">Original perspectives drive value. We believe writing shines brightest when it reflects genuine experiences and honest ownership.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <hr class="my-5 opacity-10">

                        <!-- Unacceptable Behavior Section (Matches DB Reason Categorization) -->
                        <section id="unacceptable-behavior" class="mb-5 pt-3">
                            <h2 class="fw-extrabold text-dark mb-3">Prohibited Conduct</h2>
                            <p class="text-secondary mb-4">
                                Our reporting parameters map directly to these categories. Engaging in the behaviors outlined below will result in immediate content review and moderator investigation.
                            </p>

                            <!-- Accordion detailing exact categories of violations -->
                            <div class="accordion border-0" id="behaviorAccordion">
                                <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> Harassment, Hate Speech & Bullying
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#behaviorAccordion">
                                        <div class="accordion-body text-secondary small lh-lg">
                                            We do not allow hate speech, slurs, or systemic dehumanization based on race, ethnicity, religion, gender identity, sexual orientation, disability, or nationality. Bullying or targeted personal harassment of any author on Tots is strictly prohibited.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="bi bi-shield-slash-fill text-danger me-2"></i> Plagiarism & Copyright Violations
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#behaviorAccordion">
                                        <div class="accordion-body text-secondary small lh-lg">
                                            Our system operates on a zero-tolerance policy for plagiarism. Copying entire articles, passing other authors' intellectual property off as your own, or using copyrighted cover imagery without correct licensing breaks community standards and legal terms. Always reference your inspirations.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <i class="bi bi-link-45deg text-danger me-2"></i> Systemic Spam & Deceptive Links
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#behaviorAccordion">
                                        <div class="accordion-body text-secondary small lh-lg">
                                            Tots is a reading and publishing portal, not a billboard. Avoid publishing low-value link-baiting, identical repetitive articles across tags, cryptocurrency scheme links, or manipulative SEO redirect links designed to drive traffic elsewhere.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <i class="bi bi-person-bounding-box text-danger me-2"></i> Impersonation or Identity Theft
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#behaviorAccordion">
                                        <div class="accordion-body text-secondary small lh-lg">
                                            Represent yourself authentically. Creating deceptive writer profiles pretending to be existing public figures, journalists, other platform members, or registered organizational brands with the intent to mislead or scam readers is a severe violation.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <hr class="my-5 opacity-10">

                        <!-- Reporting Framework Section -->
                        <section id="reporting-framework" class="mb-5 pt-3">
                            <h2 class="fw-extrabold text-dark mb-3">The Reporting Framework</h2>
                            <p class="text-secondary lh-lg mb-4">
                                Any logged-in community member can securely report offensive stories or abusive profiles directly via our async interface. Here is how reports travel through our backend lifecycle pipeline:
                            </p>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card p-3 rounded-4 text-center border h-100 bg-light">
                                        <div class="badge bg-warning text-dark mx-auto mb-2 px-2.5 py-1 rounded-pill">1. Pending</div>
                                        <h6 class="fw-bold text-dark mt-1">Submitted & Logged</h6>
                                        <p class="text-secondary small mb-0">The report is recorded in our secure SQL database tables. It is immediately queued for admin review.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 rounded-4 text-center border h-100 bg-light">
                                        <div class="badge bg-info text-white mx-auto mb-2 px-2.5 py-1 rounded-pill">2. Under Review</div>
                                        <h6 class="fw-bold text-dark mt-1">Moderator Audit</h6>
                                        <p class="text-secondary small mb-0">Our platform administrators evaluate the context description, reported user history, and content parameters.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 rounded-4 text-center border h-100 bg-light">
                                        <div class="badge bg-success text-white mx-auto mb-2 px-2.5 py-1 rounded-pill">3. Resolved</div>
                                        <h6 class="fw-bold text-dark mt-1">Enforced Action</h6>
                                        <p class="text-secondary small mb-0">Violating content is pruned, warnings are applied, or the report is safely dismissed if found compliant.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <hr class="my-5 opacity-10">

                        <!-- Valid vs Abusive Reports Section -->
                        <section id="valid-vs-abusive" class="mb-5 pt-3">
                            <h2 class="fw-extrabold text-dark mb-3">Valid vs. Abusive Reporting</h2>
                            <p class="text-secondary lh-lg mb-4">
                                Similar to Facebook’s policy frameworks, we protect our writers from **weaponized reporting**—where tools are used to silence or harass authors of differing opinions.
                            </p>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-4 rounded-4 bg-success-subtle h-100 border border-success-subtle">
                                        <h5 class="fw-bold text-success-emphasis mb-3">
                                            <i class="bi bi-patch-check-fill me-1"></i> What makes a report VALID
                                        </h5>
                                        <ul class="text-success-emphasis ps-3 small lh-lg">
                                            <li class="mb-2"><strong>Direct Evidence:</strong> The flagged content clearly contains hate speech, direct threats, or uncredited copy-pasted text.</li>
                                            <li class="mb-2"><strong>Context Provided:</strong> Optional notes explain where or how the violation is occurring (e.g., links to original plagiarized sources).</li>
                                            <li class="mb-2"><strong>Good Faith:</strong> The report was made with the honest intent of protecting community guidelines, not personal disputes.</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-4 rounded-4 bg-danger-subtle h-100 border border-danger-subtle">
                                        <h5 class="fw-bold text-danger-emphasis mb-3">
                                            <i class="bi bi-patch-exclamation-fill me-1"></i> What makes a report ABUSIVE
                                        </h5>
                                        <ul class="text-danger-emphasis ps-3 small lh-lg">
                                            <li class="mb-2"><strong>Disagreement Flags:</strong> Reporting a story simply because you disagree with the author's arguments, design patterns, or opinions.</li>
                                            <li class="mb-2"><strong>System Spamming:</strong> Repeatedly filing reports on different stories of the same creator to force system suspensions.</li>
                                            <li class="mb-2"><strong>False Content Claims:</strong> Deliberately fabricating plagiarism claims or using fake accounts to flood review channels.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 p-3 rounded-4 bg-light text-muted small border-start border-3 border-brand">
                                <i class="bi bi-info-circle-fill text-brand me-1"></i> 
                                <strong>Anti-Abuse Rule:</strong> Users who repeatedly submit false, weaponized, or abusive reports will have their reporting privileges revoked, and their accounts may face restriction.
                            </div>
                        </section>

                        <hr class="my-5 opacity-10">

                        <!-- Enforcement Actions Section -->
                        <section id="enforcement" class="pt-3">
                            <h2 class="fw-extrabold text-dark mb-3">Enforcement Actions</h2>
                            <p class="text-secondary lh-lg mb-4">
                                To protect the community, our administration team has several tiers of response when content is confirmed to be in violation of standards:
                            </p>

                            <div class="list-group border-0">
                                <div class="list-group-item border-0 p-0 mb-3 text-secondary">
                                    <h6 class="fw-bold text-dark"><i class="bi bi-exclamation-circle text-warning me-1"></i> 1. Informal Warning</h6>
                                    <p class="small mb-0 ms-4">For minor or first-time policy errors, the author receives a dynamic warning explaining the violation and guiding them to update their post content.</p>
                                </div>
                                <div class="list-group-item border-0 p-0 mb-3 text-secondary">
                                    <h6 class="fw-bold text-dark"><i class="bi bi-eraser-fill text-brand me-1"></i> 2. Content Pruning & De-listing</h6>
                                    <p class="small mb-0 ms-4">The offending story is permanently removed or set back into a private "Draft" status so the public feed remains compliant.</p>
                                </div>
                                <div class="list-group-item border-0 p-0 text-secondary">
                                    <h6 class="fw-bold text-dark"><i class="bi bi-person-x-fill text-danger me-1"></i> 3. Account Suspension or Termination</h6>
                                    <p class="small mb-0 ms-4">Systemic rule-breaking, persistent spam, hate speech, or severe impersonation will result in temporary suspension or a permanent platform-wide ban.</p>
                                </div>
                            </div>
                        </section>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Global Layout Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container text-center">
            <span class="fw-extrabold fs-4 text-white">tots<span class="text-accent">.</span></span>
            <p class="text-light opacity-50 small mt-2 mb-0">&copy; {{ date('Y') }} Tots. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>