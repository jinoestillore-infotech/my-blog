@foreach($posts as $post)
@php $isLiked = $likedPostIds->has($post->id); @endphp
    <article class="card feed-post-card border-0 shadow-sm rounded-4 overflow-hidden">
        <!-- Post Author Metadata Header -->
        <div class="p-4 pb-3 d-flex align-items-center gap-3">
            <!-- Author Profile Pic Link -->
            <a href="{{ route('profile.show', $post->user->username) }}" class="text-decoration-none">
                @if($post->user->avatar)
                    <img src="{{ asset($post->user->avatar) }}" class="feed-author-img object-fit-cover rounded-circle" alt="{{ $post->user->name }}'s Avatar">
                @else
                    <div class="feed-author-placeholder rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-bold">
                        {{ strtoupper(substr($post->user->name, 0, 2)) }}
                    </div>
                @endif
            </a>
            <!-- User details -->
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2">
                    <h6 class="mb-0 fw-bold text-dark">
                        <a href="{{ route('profile.show', $post->user->username) }}" class="text-decoration-none text-dark hover-brand-link">
                            {{ $post->user->name }}
                        </a>
                    </h6>
                    @if(isset($alreadyFollowingLookup[$post->user->id]))
                        <span class="badge text-info border rounded-pill px-2 py-1 d-flex align-items-center gap-1">
                            <i class="bi bi-check-circle-fill"></i>
                            Following
                        </span>
                    @endif
                </div>
                <small class="text-muted" style="font-size: .75rem;">&#64;{{ $post->user->username }} &bull; {{ $post->created_at->diffForHumans() }}</small>
            </div>
            <span class="badge bg-light text-brand rounded-pill px-1.5 py-1 d-none d-lg-block" style="font-size: .75rem;">
            <i class="bi bi-clock me-1"></i>{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min read
            </span>
        </div>
        <!-- Post Content Details -->
        <div class="px-4 pb-3">
            <!-- Title -->
            <h3 class="h5 fw-extrabold text-dark mb-2 feed-post-title">
                <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark hover-brand-link">
                    {{ $post->title }}
                </a>
                <span class="badge bg-light text-brand rounded-pill px-1.5 py-1 d-md-none d-sm-block" style="font-size: .75rem;">
                <i class="bi bi-clock me-1"></i>{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} min read
                </span>
            </h3>
            <!-- Excerpt -->
            <p class="text-secondary small mb-0 lh-base">
                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 180) }}
            </p>
        </div>
        <!-- Post Cover Image -->
        @if($post->featured_image)
            <div class="feed-image-container position-relative">
                <a href="{{ route('posts.show', $post->slug) }}">
                    <img src="{{ asset($post->featured_image) }}" class="w-100 img-fluid feed-cover-img" alt="Cover">
                </a>
            </div>
        @endif
        <!-- Interactive Reactions Footer Panel -->
        <div class="px-4 py-3 bg-light border-top border-light-subtle d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <!-- Persistent Database Like Toggle Button -->
                <button type="button" 
                        class="btn btn-reaction btn-sm rounded-pill d-flex align-items-center gap-1.5 px-3 py-1.5 {{ $likedPostIds->has($post->id) ? 'liked-active' : '' }}" 
                        onclick="toggleLike(this, {{ $post->id }})">
                    <i class="bi {{ $isLiked ? 'bi-heart-fill' : 'bi-heart' }} text-danger me-1"></i>
                    <span class="small fw-semibold reaction-count">{{ $post->likes_count }}</span>
                </button>
                <!-- Total Unique Reads Indicator -->
                <span class="text-secondary small d-flex align-items-center gap-1">
                    <i class="bi bi-eye"></i>
                    {{ $post->views }} reads
                </span>
            </div>
            <!-- Direct Link to Post Details -->
            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-custom btn-sm rounded-pill px-3 py-1.5 fw-semibold d-flex align-items-center gap-1">
                Read More <i class="bi bi-arrow-right-short fs-5"></i>
            </a>
        </div>
    </article>
@endforeach