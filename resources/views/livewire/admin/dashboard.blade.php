<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <div>
            <h1 class="dashboard-title">Dashboard Overview</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.25rem;">Real-time overview of RideFinder system users and locations</p>
        </div>
        <div style="color: var(--text-secondary); font-size: 0.9rem;">
            Last updated: <strong style="color: var(--text-primary);">{{ now()->format('Y-m-d H:i:s') }}</strong>
        </div>
    </div>

    <!-- Section 1: System Accounts -->
    <div style="margin-bottom: 2.5rem;">
        <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.5rem;">
            👤 System Accounts
        </h2>
        <div class="dashboard-stats-grid">
            <!-- Admins Stats -->
            <div class="stat-card">
                <div class="stat-icon stat-icon-purple">
                    <span>🔑</span>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['total_admins'] }}</span>
                    <span class="stat-label">System Admins</span>
                </div>
            </div>

            <!-- Managers Stats -->
            <div class="stat-card">
                <div class="stat-icon stat-icon-orange" style="background: rgba(249, 115, 22, 0.12); color: #fb923c;">
                    <span>💼</span>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['total_managers'] }}</span>
                    <span class="stat-label">Managers</span>
                </div>
            </div>

            <!-- Drivers Stats -->
            <div class="stat-card">
                <div class="stat-icon stat-icon-blue">
                    <span>🚗</span>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['total_drivers'] }}</span>
                    <span class="stat-label">Drivers</span>
                </div>
            </div>

            <!-- Users Stats -->
            <div class="stat-card">
                <div class="stat-icon stat-icon-green">
                    <span>👤</span>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['total_users'] }}</span>
                    <span class="stat-label">Regular Users</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Transit & Parking Locations -->
    <div style="margin-bottom: 2.5rem;">
        <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.5rem;">
            📍 Transit & Parking Locations
        </h2>
        <div class="dashboard-stats-grid">
            <!-- Bus Stops Stats -->
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(168, 85, 247, 0.2); color: #d8b4fe; border: 1px solid rgba(168, 85, 247, 0.3);">
                    <span>🚌</span>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['bus_stops'] }}</span>
                    <span class="stat-label">Bus Stops</span>
                </div>
            </div>

            <!-- Auto Stops Stats -->
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(99, 102, 241, 0.2); color: #c7d2fe; border: 1px solid rgba(99, 102, 241, 0.3);">
                    <span>🛺</span>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['auto_stops'] }}</span>
                    <span class="stat-label">Auto Stands</span>
                </div>
            </div>

            <!-- Taxi Stands Stats -->
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.2); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3);">
                    <span>🚕</span>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['taxi_stands'] }}</span>
                    <span class="stat-label">Taxi Stands</span>
                </div>
            </div>

            <!-- Parkings Stats -->
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3);">
                    <span>🅿️</span>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['parkings'] }}</span>
                    <span class="stat-label">Parkings</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: System Update -->
    <div>
        <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.5rem;">
            🔄 System Actions & Updates
        </h2>
        
        <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <span style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary);">Git Repository Deployment</span>
                    <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 0.25rem; max-width: 600px;">
                        Pull the latest updates from the remote GitHub branch, automatically execute database migrations, and clear cache bundles.
                    </p>
                </div>
                <div style="font-size: 0.82rem; color: var(--text-secondary); background: rgba(255, 255, 255, 0.02); padding: 0.75rem 1.25rem; border-radius: 12px; border: 1px solid var(--card-border); font-family: monospace; display: flex; flex-direction: column; gap: 0.35rem; min-width: 320px; box-shadow: inset 0 2px 5px rgba(0,0,0,0.2);">
                    <div>
                        <strong style="color: var(--text-muted); font-size: 0.72rem; text-transform: uppercase; display: inline-block; width: 130px;">Current Version:</strong> 
                        <span style="color: var(--accent-primary); font-weight: 600;">{{ $currentBranch }}</span>
                    </div>
                    <div>
                        <strong style="color: var(--text-muted); font-size: 0.72rem; text-transform: uppercase; display: inline-block; width: 130px;">Commit:</strong> 
                        <span style="color: var(--text-primary);">"{{ $currentCommitMessage }}"</span>
                    </div>
                    <div>
                        <strong style="color: var(--text-muted); font-size: 0.72rem; text-transform: uppercase; display: inline-block; width: 130px;">Timestamp:</strong> 
                        <span style="color: var(--accent-success);">{{ $currentCommitTime }}</span>
                    </div>
                </div>
            </div>

            @if (session()->has('update_message'))
                <div style="background: rgba(16, 185, 129, 0.15); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.75rem 1.25rem; border-radius: 10px; font-size: 0.9rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>✅</span> {{ session('update_message') }}
                </div>
            @endif

            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div>
                    <button 
                        wire:click="updateSite" 
                        wire:loading.attr="disabled"
                        class="btn-gradient" 
                        style="padding: 0.65rem 1.5rem; font-size: 0.85rem; border-radius: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; display: inline-flex; align-items: center; gap: 0.5rem;"
                    >
                        <svg wire:loading.remove wire:target="updateSite" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H18" />
                        </svg>
                        <span wire:loading.inline-block wire:target="updateSite" class="spinner-icon" style="width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-top-color: white; border-radius: 50%; animation: spin 1s linear infinite;"></span>
                        <span wire:loading.remove wire:target="updateSite">Update from GitHub</span>
                        <span wire:loading wire:target="updateSite">Updating Site...</span>
                    </button>
                </div>

                @if ($updateOutput)
                    <div style="margin-top: 0.5rem;">
                        <label style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary); margin-bottom: 0.5rem; display: block;">Console Log Output:</label>
                        <pre style="background-color: #090c19; color: #a7f3d0; padding: 1.25rem; border-radius: 12px; font-family: monospace; font-size: 0.85rem; overflow-x: auto; max-height: 250px; overflow-y: auto; white-space: pre-wrap; border: 1px solid var(--card-border); line-height: 1.4; box-shadow: inset 0 2px 8px rgba(0,0,0,0.5);">{{ $updateOutput }}</pre>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
