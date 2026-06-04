<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Story Reports - Tots Moderation</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-2">
            <div class="container">
                <span class="navbar-brand fw-extrabold fs-3 text-brand" style="letter-spacing: -0.5px;">
                    tots<span class="text-accent">.</span><span class="fs-6 text-muted font-monospace bg-light border p-1 rounded-3 ms-1">admin</span>
                </span>
                
                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-custom btn-sm rounded-pill px-4 py-2">
                        <i class="bi bi-arrow-left"></i> Systems Overview
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5">
        <div class="container">

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Header Panel -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
                <div>
                    <h1 class="fw-extrabold text-dark tracking-tight mb-1">Story Violation Audit</h1>
                    <p class="text-secondary mb-0">Investigate user reports flagging plagiarism, copyright infringement, or harassment in stories.</p>
                </div>
                
                <!-- Status Switch Controls -->
                <div class="d-flex gap-2 bg-white p-1 border rounded-pill shadow-sm">
                    <a href="{{ route('admin.reports.stories', ['status' => 'pending']) }}" class="btn btn-sm rounded-pill px-3 py-1.5 small {{ $status === 'pending' ? 'btn-brand text-white' : 'text-muted bg-transparent border-0' }}">
                        Pending
                    </a>
                    <a href="{{ route('admin.reports.stories', ['status' => 'resolved']) }}" class="btn btn-sm rounded-pill px-3 py-1.5 small {{ $status === 'resolved' ? 'btn-brand text-white' : 'text-muted bg-transparent border-0' }}">
                        Resolved
                    </a>
                    <a href="{{ route('admin.reports.stories', ['status' => 'dismissed']) }}" class="btn btn-sm rounded-pill px-3 py-1.5 small {{ $status === 'dismissed' ? 'btn-brand text-white' : 'text-muted bg-transparent border-0' }}">
                        Dismissed
                    </a>
                    <a href="{{ route('admin.reports.stories', ['status' => 'all']) }}" class="btn btn-sm rounded-pill px-3 py-1.5 small {{ $status === 'all' ? 'btn-brand text-white' : 'text-muted bg-transparent border-0' }}">
                        All Flags
                    </a>
                </div>
            </div>

            <!-- Reports Moderation Registry Table -->
            <div class="admin-table-container shadow-sm">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Flagged Story Detail</th>
                                <th>Filed By</th>
                                <th>Category Violation</th>
                                <th>Context Details</th>
                                <th>Status</th>
                                <th class="text-end">Verification / Action Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>
                                        @if($report->post)
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $report->post->title }}</h6>
                                                <small class="text-muted">By: @ {{ $report->post->user->username }}</small>
                                            </div>
                                        @else
                                            <span class="text-danger small"><i class="bi bi-trash-fill"></i> Post already deleted</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark small">{{ $report->user->name }}</h6>
                                            <small class="text-muted">&#64;{{ $report->user->username }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1.5 small text-nowrap">
                                            <i class="bi bi-shield-fill-exclamation me-1"></i> {{ $report->reason }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small text-secondary" style="max-width: 250px;">
                                            {{ $report->details ?? 'No context notes provided.' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill px-2.5 py-1.5 small text-uppercase font-monospace 
                                            {{ $report->status === 'pending' ? 'badge-pending' : '' }}
                                            {{ $report->status === 'resolved' ? 'badge-resolved' : '' }}
                                            {{ $report->status === 'dismissed' ? 'badge-dismissed' : '' }}">
                                            {{ $report->status }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            @if($report->post)
                                                <!-- Dynamic verification link redirects to view post in new tab -->
                                                <a href="{{ route('posts.show', $report->post->slug) }}" target="_blank" class="btn btn-light border btn-sm rounded-pill px-3">
                                                    <i class="bi bi-eye"></i> Verify Story
                                                </a>
                                            @endif

                                            @if($report->status === 'pending')
                                                <!-- Action form to dismiss report -->
                                                <form action="{{ route('admin.reports.stories.update', $report->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="dismissed">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Dismiss</button>
                                                </form>

                                                @if($report->post)
                                                    <!-- Action form to delete violating story (and auto resolve associated reports) -->
                                                    <form action="{{ route('admin.reports.stories.destroy_story', $report->post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this story for violating community guidelines?')" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">Delete Post</button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-patch-check fs-1 mb-2 d-block opacity-40 text-success"></i>
                                        <p class="mb-0 text-dark fw-bold">Queue clear!</p>
                                        <p class="small">No story reports match the filtered status category.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $reports->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </main>
</body>
</html>