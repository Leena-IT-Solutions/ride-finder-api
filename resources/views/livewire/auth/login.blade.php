<div class="glass-card">
    <div class="card-header">
        <h2 class="card-title">Welcome Back</h2>
        <p class="card-subtitle">Sign in to your RideFinder account</p>
    </div>

    <!-- Session Feedback -->
    @if (session()->has('error'))
        <div class="alert alert-error">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 11 3 3 7-7"/><path d="M21 12a9 9 0 1 1-9-9"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="login">
        <!-- Login Input (Email or Mobile) -->
        <div class="form-group">
            <label class="form-label" for="login_input">Mobile Number or Email</label>
            <input type="text" id="login_input" wire:model="login_input" class="form-control" placeholder="9876543210 or admin@example.com" required autofocus>
            @error('login_input') 
                <span class="form-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" wire:model="password" class="form-control" placeholder="••••••••" required>
            @error('password') 
                <span class="form-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem;">
            <input type="checkbox" id="remember" wire:model="remember" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--accent-primary);">
            <label for="remember" style="color: var(--text-secondary); font-size: 0.9rem; cursor: pointer; user-select: none;">Remember me</label>
        </div>

        <button type="submit" class="btn-gradient btn-block" wire:loading.attr="disabled">
            <span wire:loading.remove>Log In</span>
            <span wire:loading>Authenticating...</span>
        </button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}" class="auth-link">Register Here</a>
    </div>
</div>
