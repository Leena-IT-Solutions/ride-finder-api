<div class="glass-card">
    <div class="card-header">
        <h2 class="card-title">Create Account</h2>
        <p class="card-subtitle">Join RideFinder as an Admin, Driver, or User</p>
    </div>

    <!-- Session Feedback -->
    @if (session()->has('error'))
        <div class="alert alert-error">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="register">
        <!-- Name -->
        <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input type="text" id="name" wire:model="name" class="form-control" placeholder="John Doe" required>
            @error('name') 
                <span class="form-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Mobile Number -->
        <div class="form-group">
            <label class="form-label" for="mobile_number">Mobile Number</label>
            <input type="text" id="mobile_number" wire:model="mobile_number" class="form-control" placeholder="9876543210" required>
            @error('mobile_number') 
                <span class="form-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Email (Optional) -->
        <div class="form-group">
            <label class="form-label" for="email">Email Address <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: normal;">(Optional)</span></label>
            <input type="email" id="email" wire:model="email" class="form-control" placeholder="john@example.com">
            @error('email') 
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

        <!-- Password Confirmation -->
        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-gradient btn-block" wire:loading.attr="disabled">
            <span wire:loading.remove>Create Account</span>
            <span wire:loading>Processing...</span>
        </button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="{{ route('login') }}" class="auth-link">Log In</a>
    </div>
</div>
