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
    <div>
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
</div>
