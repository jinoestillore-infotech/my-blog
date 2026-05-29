<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Our Community - Tots</title>

    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom Separated CSS -->
    <link rel="stylesheet" href="{{ asset('css/community.css') }}">
</head>
<body>
    <!-- Navigation Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-3">
            <div class="container">
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="/" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#totsNavbar" aria-controls="totsNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="totsNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0 gap-md-3">
                        <li class="nav-item me-5">
                            <a class="nav-link text-brand fw-bold px-2" href="/community">Our Community</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <a href="#" class="text-decoration-none text-secondary fw-semibold border rounded-pill px-4 py-2">Log in</a>
                        <a href="#" class="btn btn-brand px-4 text-nowrap">Get Started</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main Section -->
    <main class="py-5">
        <div class="container">
            <!-- Community Hero Section -->
            <div class="text-center max-w-2xl mx-auto mb-5">
                <span class="badge bg-brand-light rounded-pill px-3 py-2 fw-semibold mb-3">Tots Directory</span>
                <h1 class="display-5 fw-extrabold text-dark mb-3">Meet the Makers of Tots</h1>
                <p class="lead text-secondary mx-auto" style="max-width: 650px;">
                    Discover amazing storytellers, professional builders, creative artists, and thought leaders pushing the limits of collaborative blogging.
                </p>
                <!-- Search bar -->
                <div class="row justify-content-center mt-4">
                    <div class="col-md-8 col-lg-7">
                        <div class="search-box p-1 bg-white rounded-pill shadow-sm border d-flex align-items-center">
                            <i class="bi bi-search text-muted ms-3 me-2"></i>
                            <input type="text" class="form-control border-0 bg-transparent py-2 shadow-none" placeholder="Search creators, bios, or topics...">
                            <button class="btn btn-brand rounded-pill px-4 me-1 d-none d-sm-inline-block">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Community Stats Panel -->
            <div class="row g-3 mb-5 justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="stat-card p-4 text-center rounded-4">
                        <h2 class="fw-extrabold text-brand mb-1">10k+</h2>
                        <span class="text-secondary small fw-medium">Active Bloggers</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card p-4 text-center rounded-4">
                        <h2 class="fw-extrabold text-brand mb-1">45k+</h2>
                        <span class="text-secondary small fw-medium">Stories Shared</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card p-4 text-center rounded-4">
                        <h2 class="fw-extrabold text-brand mb-1">150k+</h2>
                        <span class="text-secondary small fw-medium">Monthly Reads</span>
                    </div>
                </div>
            </div>
            <!-- Filter Categories (Tag Cloud) -->
            <div class="text-center mb-5">
                <p class="text-muted small fw-bold text-uppercase tracking-wider mb-3">Browse communities by topic</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <button class="btn btn-tag active rounded-pill px-3 py-1.5">All Creators</button>
                    <button class="btn btn-tag rounded-pill px-3 py-1.5">Technology</button>
                    <button class="btn btn-tag rounded-pill px-3 py-1.5">Lifestyle</button>
                    <button class="btn btn-tag rounded-pill px-3 py-1.5">Design</button>
                    <button class="btn btn-tag rounded-pill px-3 py-1.5">Finance</button>
                    <button class="btn btn-tag rounded-pill px-3 py-1.5">Travel</button>
                </div>
            </div>
            <!-- Creators Grid -->
            <div class="row g-4 mb-5">
                <!-- Creator Card 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card creator-card h-100 p-4 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="creator-avatar avatar-blue">AM</div>
                            <span class="badge bg-brand-light text-brand rounded-pill px-2.5 py-1 small">Pro Writer</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Amara Miller</h5>
                        <p class="text-brand small mb-3">@amaramiller</p>
                        <p class="text-secondary small mb-4 flex-grow-1">
                            UX Researcher & tech enthusiast. Writing detailed perspectives on product design, modern aesthetics, and the future of interaction.
                        </p>
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                            <span class="text-muted small"><strong class="text-dark">1.2k</strong> Followers</span>
                            <button class="btn btn-outline-brand btn-sm px-3 rounded-pill">Follow</button>
                        </div>
                    </div>
                </div>
                <!-- Creator Card 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card creator-card h-100 p-4 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="creator-avatar avatar-green">KH</div>
                            <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1 small">Staff Writer</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Kenji Haneda</h5>
                        <p class="text-brand small mb-3">@kenjih</p>
                        <p class="text-secondary small mb-4 flex-grow-1">
                            Living in rural Japan, detailing slow productivity, mindful working frameworks, and maintaining focus in a noisy digital economy.
                        </p>
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                            <span class="text-muted small"><strong class="text-dark">890</strong> Followers</span>
                            <button class="btn btn-outline-brand btn-sm px-3 rounded-pill">Follow</button>
                        </div>
                    </div>
                </div>
                <!-- Creator Card 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card creator-card h-100 p-4 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="creator-avatar avatar-orange">SS</div>
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2.5 py-1 small">Rising Star</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Sarah Stone</h5>
                        <p class="text-brand small mb-3">@sarahstone</p>
                        <p class="text-secondary small mb-4 flex-grow-1">
                            Digital nomad exploring remote work cultures globally. I post weekly travel logs, budget hacks, and guides for aspiring remote developers.
                        </p>
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                            <span class="text-muted small"><strong class="text-dark">2.4k</strong> Followers</span>
                            <button class="btn btn-outline-brand btn-sm px-3 rounded-pill">Follow</button>
                        </div>
                    </div>
                </div>
                <!-- Creator Card 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card creator-card h-100 p-4 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="creator-avatar avatar-indigo">LC</div>
                            <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1 small">Contributor</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Lucas Carter</h5>
                        <p class="text-brand small mb-3">@lucascarter</p>
                        <p class="text-secondary small mb-4 flex-grow-1">
                            Software engineer writing simplified, visual walkthroughs of PHP frameworks, database optimization models, and server infrastructure.
                        </p>
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                            <span class="text-muted small"><strong class="text-dark">540</strong> Followers</span>
                            <button class="btn btn-outline-brand btn-sm px-3 rounded-pill">Follow</button>
                        </div>
                    </div>
                </div>
                <!-- Creator Card 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card creator-card h-100 p-4 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="creator-avatar avatar-pink">EP</div>
                            <span class="badge bg-brand-light text-brand rounded-pill px-2.5 py-1 small">Pro Writer</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Elena Rostova</h5>
                        <p class="text-brand small mb-3">@elena_r</p>
                        <p class="text-secondary small mb-4 flex-grow-1">
                            A food enthusiast turning kitchen adventures into storytelling gems. Exploring culture and memory through global recipes and sensory essays.
                        </p>
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                            <span class="text-muted small"><strong class="text-dark">3.1k</strong> Followers</span>
                            <button class="btn btn-outline-brand btn-sm px-3 rounded-pill">Follow</button>
                        </div>
                    </div>
                </div>
                <!-- Creator Card 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card creator-card h-100 p-4 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="creator-avatar avatar-teal">DB</div>
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2.5 py-1 small">Rising Star</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Derrick Boyd</h5>
                        <p class="text-brand small mb-3">@derrickboyd</p>
                        <p class="text-secondary small mb-4 flex-grow-1">
                            An independent podcaster compiling deep-dive written records of historical curiosities, modern sociology, and human behaviors.
                        </p>
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                            <span class="text-muted small"><strong class="text-dark">1.5k</strong> Followers</span>
                            <button class="btn btn-outline-brand btn-sm px-3 rounded-pill">Follow</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Call To Action (Join Community) -->
            <div class="card cta-card p-4 p-md-5 text-center text-white border-0 mt-5">
                <div class="max-w-2xl mx-auto py-3">
                    <h2 class="fw-extrabold mb-3">Share your story. Meet your crowd.</h2>
                    <p class="text-white-50 mb-4">Starting a blog shouldn't mean writing in a vacuum. Join our directory of thousands of amazing creators and start collaborating.</p>
                    <a href="#" class="btn btn-light text-brand fw-bold rounded-pill px-4 py-2.5">Join the Directory</a>
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