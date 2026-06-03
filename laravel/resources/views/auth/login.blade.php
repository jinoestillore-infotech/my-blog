@extends('auth.layout')
@section('title', 'Join Tots')
@section('content')
        <div class="row justify-content-center">
            <div class="col-11 col-md-8 col-lg-5 mt-1">
                <!-- Registration Card -->
                <div class="card auth-card p-4 p-md-5 border-0 shadow-sm">
                    <div class="text-center mb-2 mt-0">
                        <h4 class="fw-bold text-dark mb-1">Login Account</h4>
                    </div>
                    <!-- Form starts here -->
                    <form method="POST" action="/login">
                        @csrf
                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold text-secondary">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 
                                    @error('email') text-danger border-danger @else text-muted @enderror">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email"
                                    class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="you@example.com"
                                    required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label small fw-bold text-secondary mb-0">Password</label>
                                <a href="{{ route('password.request') }}" class="text-brand text-decoration-none small fw-medium">Forgot password?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-muted border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" placeholder="Enter your password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="form-check mb-3 text-start">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label small text-muted" for="remember">
                                Keep me logged in
                            </label>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-brand w-100 py-2.5 rounded-pill fw-bold mb-3">Sign In</button>
                        <div class="mb-1 text-start">
                            <p class="small text-muted" for="terms">
                                You may read our <a href="{{ route('community-standards') }}" class="text-brand text-decoration-none fw-medium">Community Standards</a> before logging in.
                            </p>
                        </div>
                    </form>
                    <!-- Divider -->
                    <div class="position-relative text-center my-2">
                        <hr class="text-muted">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">New to Tots?</span>
                    </div>

                    <!-- Register Redirect Link -->
                    <div class="text-center mt-2">
                        <a href="{{ route('register') }}" class="btn btn-outline-custom w-100 rounded-pill py-2.5 small fw-bold text-decoration-none d-block">Create an account</a>
                    </div>
                </div>
            </div>
        </div>
@endsection