@extends('auth.layout')
@section('title', 'Create Account - Tots')
@section('content')
        <div class="row justify-content-center">
            <div class="col-11 col-md-8 col-lg-5 mt-1">
                <!-- Registration Card -->
                <div class="card auth-card p-4 p-md-5 border-0 shadow-sm">
                    <div class="text-center mb-2 mt-0">
                        <h4 class="fw-bold text-dark mb-1">Create your account</h4>
                    </div>
                    <!-- Form starts here -->
                    <form method="POST" action="/register">
                        @csrf
                        <!-- Full Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-bold text-secondary">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-person"></i></span>
                                <input type="text" id="name" name="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Username Field -->
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-bold text-secondary">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-at"></i></span>
                                <input type="text" id="username" name="username" class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="johndoe" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold text-secondary">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="you@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" placeholder="Create a strong password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Confirm Password Field -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small fw-bold text-secondary">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-shield-check"></i></span>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="Repeat your password" required>
                            </div>
                        </div>
                        <!-- Terms and Conditions Checkbox -->
                        <div class="form-check mb-4 text-start">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label small text-muted" for="terms">
                                I agree to the <a href="/terms-of-service" class="text-brand text-decoration-none fw-medium">Terms of Service</a> and <a href="/privacy-policy" class="text-brand text-decoration-none fw-medium">Privacy Policy</a>
                            </label>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-brand w-100 py-2.5 rounded-pill fw-bold mb-3">Create Account</button>
                    </form>
                    <!-- Divider -->
                    <div class="position-relative text-center my-3">
                        <hr class="text-muted">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">Already have an account?</span>
                    </div>
                    <!-- Login Redirect Link -->
                    <div class="text-center mt-2">
                        <a href="/login" class="btn btn-outline-custom w-100 rounded-pill py-2.5 small fw-bold text-decoration-none d-block">Log In</a>
                    </div>
                </div>
            </div>
        </div>
@endsection