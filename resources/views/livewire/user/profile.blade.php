<div class="dashboard-container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">My Profile</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.25rem;">
                Manage your personal information, update security settings, or delete your account.
            </p>
        </div>
    </div>

    <!-- Session messages -->
    @if (session()->has('error'))
        <div style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.75rem 1.25rem; border-radius: 10px; font-size: 0.9rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <span>❌</span> {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
        
        <!-- Profile Info Card -->
        <div class="glass-card" style="padding: 2rem; border-radius: 16px;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text-primary); border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">
                👤 Account Information
            </h3>

            @if (session()->has('profile_success'))
                <div style="background: rgba(16, 185, 129, 0.15); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.75rem 1.25rem; border-radius: 10px; font-size: 0.9rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>✅</span> {{ session('profile_success') }}
                </div>
            @endif

            <form wire:submit.prevent="updateProfile">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label" for="profile_name">Full Name</label>
                        <input type="text" id="profile_name" wire:model="name" class="form-control" required>
                        @error('name') <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="profile_email">Email Address</label>
                        <input type="email" id="profile_email" wire:model="email" class="form-control" required>
                        @error('email') <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="profile_mobile">Mobile Number</label>
                        <input type="text" id="profile_mobile" wire:model="mobile_number" class="form-control" required>
                        @error('mobile_number') <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="btn-gradient" style="padding: 0.7rem 1.8rem; border-radius: 8px;">
                    Update Profile
                </button>
            </form>
        </div>

        <!-- Security / Password Card -->
        <div class="glass-card" style="padding: 2rem; border-radius: 16px;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text-primary); border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">
                🔑 Update Password
            </h3>

            @if (session()->has('password_success'))
                <div style="background: rgba(16, 185, 129, 0.15); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.75rem 1.25rem; border-radius: 10px; font-size: 0.9rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>✅</span> {{ session('password_success') }}
                </div>
            @endif

            <form wire:submit.prevent="updatePassword">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label" for="current_pw">Current Password</label>
                        <input type="password" id="current_pw" wire:model="current_password" class="form-control" required>
                        @error('current_password') <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="new_pw">New Password</label>
                        <input type="password" id="new_pw" wire:model="new_password" class="form-control" required>
                        @error('new_password') <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="confirm_pw">Confirm New Password</label>
                        <input type="password" id="confirm_pw" wire:model="new_password_confirmation" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn-gradient" style="padding: 0.7rem 1.8rem; border-radius: 8px;">
                    Change Password
                </button>
            </form>
        </div>

        <!-- Danger Zone Card -->
        <div class="glass-card" style="padding: 2rem; border-radius: 16px; border: 1px solid rgba(239, 68, 68, 0.25); background: linear-gradient(135deg, rgba(15, 18, 37, 0.7) 0%, rgba(239, 68, 68, 0.02) 100%);">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #f87171; border-bottom: 1px solid rgba(239, 68, 68, 0.15); padding-bottom: 0.75rem;">
                ⚠️ Danger Zone
            </h3>
            
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 1.5rem;">
                Once you delete your account, there is no going back. All of your saved vehicles, tracking logs, and profile details will be permanently removed.
            </p>

            <form wire:submit.prevent="deleteAccount" onsubmit="return confirm('Are you absolutely sure you want to permanently delete your Ride Finder account? This action cannot be undone.');">
                <div class="form-group" style="max-width: 400px; margin-bottom: 1.5rem;">
                    <label class="form-label" for="delete_pw" style="color: #fca5a5;">Confirm Password to Delete Account</label>
                    <input type="password" id="delete_pw" wire:model="confirm_delete_password" class="form-control" placeholder="Enter your password" required style="border-color: rgba(239, 68, 68, 0.25);">
                    @error('confirm_delete_password') <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span> @enderror
                </div>

                <button type="submit" style="padding: 0.75rem 2rem; border-radius: 8px; border: none; background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color: white; font-weight: 600; cursor: pointer; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);">
                    Permanently Delete Account
                </button>
            </form>
        </div>

    </div>
</div>
