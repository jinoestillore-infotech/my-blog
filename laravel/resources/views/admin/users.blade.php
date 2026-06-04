<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Registry - Tots Administration</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/tots.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
</head>
<body>

    <header class="sticky-top">
        <nav class="navbar navbar-expand-md navbar-custom py-2">
            <div class="container-fluid">
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
        <div class="container-fluid">
            <!-- Header Controls -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
                <div>
                    <h1 class="fw-extrabold text-dark tracking-tight mb-1">User Registry Panel</h1>
                    <p class="text-secondary mb-0">Modify user roles, view detailed profile contexts, or safely prune accounts.</p>
                </div>
                
                <!-- Search Box -->
                <div style="max-width: 320px; width: 100%;">
                    <form action="{{ route('admin.users.index') }}" method="GET">
                        <div class="input-group bg-white border rounded-pill overflow-hidden p-1">
                            <span class="input-group-text bg-white border-0 text-muted ps-3"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ $search }}" class="form-control border-0 bg-transparent py-1.5 shadow-none small" placeholder="Search account details...">
                            <button class="btn btn-brand rounded-pill btn-sm px-3" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Registry Database Table Container -->
            <div class="admin-table-container shadow-sm">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Account Details</th>
                                <th>Role Status</th>
                                <th>Stories</th>
                                <th>Activity Signature</th>
                                <th class="text-end">Verification Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($user->avatar)
                                                <img src="{{ asset($user->avatar) }}" class="rounded-circle object-fit-cover" style="width: 40px; height: 40px; border: 1px solid #e2e8f0;" alt="Avatar">
                                            @else
                                                <div class="rounded-circle bg-brand-light text-brand d-flex align-items-center justify-content-center fw-bold text-uppercase small" style="width: 40px; height: 40px;">
                                                    {{ substr($user->name, 0, 2) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $user->name }}</h6>
                                                <small class="text-muted">&#64;{{ $user->username }} &bull; {{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Inline Role Selector Update Form -->
                                        @if($user->id === Auth::id())
                                            <span class="badge bg-primary rounded-pill px-3 py-1.5">Owner (Master)</span>
                                        @else
                                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                                    <option value="reader" {{ $user->role === 'reader' ? 'selected' : '' }}>Reader</option>
                                                    <option value="writer" {{ $user->role === 'writer' ? 'selected' : '' }}>Writer</option>
                                                    <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>Moderator</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary rounded-pill border px-2.5 py-1.5 small">
                                            <i class="bi bi-journal-text me-1 text-brand"></i> {{ $user->posts_count }} published
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->last_activity_at && $user->last_activity_at->diffInMinutes(now()) <= 5)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1.5">
                                                <span class="spinner-grow spinner-grow-sm me-1" style="width: 6px; height: 6px;"></span> Active
                                            </span>
                                        @else
                                            <span class="text-secondary small">{{ $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Never Active' }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <!-- Verification link redirects to public profile -->
                                            <a href="{{ route('profile.show', $user->username) }}" target="_blank" class="btn btn-light border btn-sm rounded-pill px-3">
                                                <i class="bi bi-eye"></i> Verify profile
                                            </a>

                                            @if($user->id !== Auth::id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('WARNING: Are you absolutely certain you want to purge this profile database record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">Purge</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-search fs-1 mb-2 d-block opacity-40"></i>
                                        <p class="mb-0">No active writer records corresponded to your search terms.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::simple-bootstrap-5') }}
            </div>

        </div>
    </main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
</body>
</html>