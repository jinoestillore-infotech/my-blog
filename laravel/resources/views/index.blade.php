<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tots - A platform where bloggers connect, share stories, and grow together</title>
    <meta name="description" content="Write, publish, and grow on Tots. Connect with bloggers worldwide, share your ideas, and discover inspiring stories from every niche.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <!-- Google Fonts (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS for Premium Tots Theme Overrides -->
    <style>
        :root {
            --brand-primary: #6366f1;
            --brand-hover: #4f46e5;
            --brand-light: #f5f3ff;
            --brand-accent: #f59e0b;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-soft: #f8fafc;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            color: var(--text-dark);
        }

        /* Premium Brand Colors & Buttons */
        .text-brand {
            color: var(--brand-primary);
        }
        .text-accent {
            color: var(--brand-accent);
        }
        .bg-brand-light {
            background-color: var(--brand-light);
            color: var(--brand-primary);
        }
        .btn-brand {
            background-color: var(--brand-primary);
            color: #ffffff;
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.2);
        }
        .btn-brand:hover, .btn-brand:focus {
            background-color: var(--brand-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
        }
        .btn-outline-custom {
            background-color: #ffffff;
            color: var(--text-dark);
            border: 1px solid #e2e8f0;
            padding: 0.65rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover {
            background-color: #f1f5f9;
            color: var(--text-dark);
            transform: translateY(-2px);
        }

        /* Sticky Navigation Blur */
        .navbar-custom {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #f1f5f9;
        }

        /* Gradient Headings */
        .text-gradient {
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Smooth Floating Mockup Cards */
        .preview-card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            transition: all 0.3s ease;
            background: #ffffff;
        }
        .preview-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.1);
        }

        /* Avatar Background Gradients */
        .avatar-gradient-1 {
            background: linear-gradient(135deg, #e0e7ff 0%, #fef3c7 100%);
            color: #4338ca;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border-radius: 50%;
        }
        .avatar-gradient-2 {
            background: linear-gradient(135deg, #d1fae5 0%, #e0e7ff 100%);
            color: #065f46;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border-radius: 50%;
        }

        /* Feature Cards */
        .feature-box {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        .feature-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        }
        .feature-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background-color: var(--brand-light);
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .footer-link {
            transition: color 0.2s ease;
        }
        .footer-link:hover {
            color: #fff !important;
        }
        .hover-brand-link {
            transition: color 0.2s ease;
        }
        .hover-brand-link:hover {
            color: var(--brand-primary) !important;
        }

        .w-90 {
            width: 90%;
        }
        
        @media (max-width: 991px) {
            .w-90 {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-3">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-extrabold fs-3 text-brand" href="#" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span>
                </a>

                <!-- Responsive Menu Toggle -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#totsNavbar" aria-controls="totsNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation items -->
                <div class="collapse navbar-collapse" id="totsNavbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0 gap-md-3">
                        <li class="nav-item me-5">
                            <a class="nav-link text-secondary fw-semibold px-2" href="{{ route('community') }}">Our Community</a>
                        </li>
                    </ul>
                    <!-- Call To Action Buttons -->
                    <div class="d-flex align-items-center gap-3">
                        @auth
                        <a href="{{ route('pages.index') }}" class="text-decoration-none text-secondary fw-semibold px-3">Dashboard</a>
                        <a href="{{ route('tots-feed') }}" class="btn btn-brand px-4 text-nowrap">Enter Feed</a>
                        @else
                        <a href="{{ route('login') }}" class="text-decoration-none text-secondary fw-semibold border rounded-pill px-4 py-2">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-brand px-4 text-nowrap">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <main class="py-5 pt-3 overflow-hidden">
        <div class="container py-lg-4">
            <div class="row align-items-center g-5">
                
                <!-- Hero Left: Text Content -->
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="badge bg-brand-light rounded-pill px-3 py-2 fw-semibold mb-4 fs-7">
                        <span class="spinner-grow spinner-grow-sm me-1" style="width: 8px; height: 8px;" role="status" aria-hidden="true"></span>
                        Join active writers today
                    </span>
                    
                    <h1 class="display-4 fw-extrabold text-slate-900 mb-4 lh-sm">
                        Where bloggers <span class="text-gradient">connect</span>, share stories, and grow together.
                    </h1>
                    
                    <p class="lead text-secondary mb-5">
                        Tots is a collaborative social publishing platform built to bring voices from all over the world together. Write beautifully, discover fresh perspectives, and connect with minds that inspire you.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                        @auth
                        <a href="{{ route('pages.index') }}" class="btn btn-brand btn-lg px-4 fs-6">Start Your Masterpiece</a>
                        <a href="{{ route('tots-feed') }}" class="btn btn-outline-custom btn-lg px-4 fs-6">Explore Trending</a>
                        @else
                        <a href="{{ route('register') }}" class="btn btn-brand btn-lg px-4 fs-6">Start Your Journey</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-custom btn-lg px-4 fs-6">Sign In to Explore</a>
                        @endauth
                    </div>
                </div>

                <!-- Hero Right: Simulated / Real Blog Cards -->
                <div class="col-lg-6">
                    <div class="d-flex flex-column gap-4 position-relative">
                        @if(isset($recentPosts) && $recentPosts->isNotEmpty())
                            <!-- Dynamic Database Real Blog Cards -->
                            @foreach($recentPosts as $index => $post)
                                <div class="card preview-card p-4 {{ $index === 1 ? 'align-self-end w-90' : '' }}">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($post->user->avatar)
                                                <img src="{{ asset($post->user->avatar) }}" class="rounded-circle object-fit-cover" style="width: 42px; height: 42px;" alt="Avatar">
                                            @else
                                                <div class="{{ $index === 0 ? 'avatar-gradient-1' : 'avatar-gradient-2' }}">
                                                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $post->user->name }}</h6>
                                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-light text-brand rounded-pill px-2.5 py-1 small">
                                            <i class="bi bi-clock me-1"></i>{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min read
                                        </span>
                                    </div>
                                    <h5 class="fw-bold mb-2">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-brand-link">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <p class="text-secondary small mb-3">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 140) }}
                                    </p>
                                    <div class="d-flex align-items-center gap-3 pt-3 border-top border-light-subtle text-muted small">
                                        <span><i class="bi bi-heart-fill text-danger me-1"></i>{{ $post->likes()->count() }} likes</span>
                                        <span><i class="bi bi-eye-fill text-secondary me-1"></i>{{ $post->views }} reads</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback Simulated Premium Mock Blog Cards -->
                            <div class="card preview-card p-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-gradient-1">AM</div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Amara Miller</h6>
                                            <small class="text-muted">Technology &bull; Just now</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-light text-brand rounded-pill px-2.5 py-1 small">
                                        <i class="bi bi-clock me-1"></i>5 min read
                                    </span>
                                </div>
                                <h5 class="fw-bold mb-2">Designing for the future: Why simplicity is the ultimate sophistication</h5>
                                <p class="text-secondary small mb-3">The design landscape is rapidly shifting. In a world of increasing complexity, creating products that feel natural and straightforward is becoming a rare art...</p>
                                <div class="d-flex align-items-center gap-3 pt-3 border-top border-light-subtle text-muted small">
                                    <span><i class="bi bi-heart-fill text-danger me-1"></i>124 likes</span>
                                    <span><i class="bi bi-eye-fill text-secondary me-1"></i>2.4k reads</span>
                                </div>
                            </div>

                            <div class="card preview-card p-4 align-self-end w-90">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-gradient-2">KH</div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Kenji Haneda</h6>
                                            <small class="text-muted">Life &bull; 2 hours ago</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-light text-brand rounded-pill px-2.5 py-1 small">
                                        <i class="bi bi-clock me-1"></i>8 min read
                                    </span>
                                </div>
                                <h5 class="fw-bold mb-2">What living in rural Japan taught me about slow productivity</h5>
                                <p class="text-secondary small mb-3">After years in busy Tokyo agencies, stepping into the countryside reshuffled everything I knew about producing great, sustainable work...</p>
                                <div class="d-flex align-items-center gap-3 pt-3 border-top border-light-subtle text-muted small">
                                    <span><i class="bi bi-heart-fill text-danger me-1"></i>98 likes</span>
                                    <span><i class="bi bi-eye-fill text-secondary me-1"></i>1.8k reads</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Core Features Section -->
    <section class="py-5 bg-white border-top border-bottom border-light">
        <div class="container py-4">
            <div class="text-center max-w-3xl mx-auto mb-5">
                <h2 class="fw-extrabold text-slate-900 mb-3">
                    Why writers and readers love Tots
                </h2>
                <p class="lead text-secondary mx-auto" style="max-width: 700px;">
                    We designed a blogging space focused entirely on fostering rich connections, distraction-free writing, and community support.
                </p>
            </div>

            <div class="row g-4 mt-2">
                <!-- Feature 1 -->
                <div class="col-md-4">
                    <div class="feature-box p-4 h-100">
                        <div class="feature-icon-wrapper mb-4">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Connect Instantly</h5>
                        <p class="text-secondary small mb-0">Follow your favorite authors, comment on their insights, and start engaging threads across matching interest clusters.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-4">
                    <div class="feature-box p-4 h-100">
                        <div class="feature-icon-wrapper mb-4">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Share Stories</h5>
                        <p class="text-secondary small mb-0">Write with our clean, minimalist editor designed to let your words shine without distracting formatting hurdles.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-4">
                    <div class="feature-box p-4 h-100">
                        <div class="feature-icon-wrapper mb-4">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Grow Together</h5>
                        <p class="text-secondary small mb-0">Expand your reach through organic discovery features and shared collaborative publications.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-secondary py-5">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">

                <!-- Brand -->
                <span class="fs-4 fw-bold text-white">
                    tots<span class="text-warning">.</span>
                </span>

                <!-- Copyright -->
                <p class="small mb-0 text-center">
                    &copy; {{ date('Y') }} Tots. Built with passion for writers worldwide.
                </p>

                <!-- Links -->
                <div class="d-flex flex-wrap gap-3 small">
                    <a href="{{ route('privacy') }}" class="text-secondary text-decoration-none footer-link">
                        Privacy Policy
                    </a>
                    <a href="{{ route('terms') }}" class="text-secondary text-decoration-none footer-link">
                        Terms of Service
                    </a>
                    <a href="{{ route('community-standards') }}" class="text-secondary text-decoration-none footer-link">
                        Community Standards
                    </a>
                </div>

            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>