<div class="dashboard-container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Portal Settings</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.25rem;">Adjust global variables, configuration constants, and ride fare structures</p>
        </div>
    </div>

    <div class="glass-card" style="max-width: 100%; padding: 2rem; border-radius: 16px;">
        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text-primary); border-bottom: 1px solid var(--card-border); padding-bottom: 0.75rem;">
            ⚙️ App Configurations
        </h3>

        @if (session()->has('settings_saved'))
            <div style="background: rgba(16, 185, 129, 0.15); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.75rem 1.25rem; border-radius: 10px; font-size: 0.9rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>✅</span> {{ session('settings_saved') }}
            </div>
        @endif
        
        <form wire:submit.prevent="save">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <!-- App Name -->
                <div class="form-group">
                    <label class="form-label" for="setting_appname">System App Name</label>
                    <input type="text" id="setting_appname" wire:model="appName" class="form-control" required>
                </div>

                <!-- Support Contact -->
                <div class="form-group">
                    <label class="form-label" for="setting_phone">Support Helpline Number</label>
                    <input type="text" id="setting_phone" wire:model="supportPhone" class="form-control" required>
                </div>

                <!-- Base Fare -->
                <div class="form-group">
                    <label class="form-label" for="setting_base_fare">Base Auto Fare (₹)</label>
                    <input type="number" id="setting_base_fare" wire:model="baseFare" class="form-control" required>
                </div>

                <!-- Per KM Fare -->
                <div class="form-group">
                    <label class="form-label" for="setting_per_km">Per Kilometer Charge (₹)</label>
                    <input type="number" id="setting_per_km" wire:model="perKmFare" class="form-control" required>
                </div>

                <!-- Search Radius -->
                <div class="form-group">
                    <label class="form-label" for="setting_radius">Stops Search Radius (KM)</label>
                    <input type="number" id="setting_radius" wire:model="searchRadius" class="form-control" required>
                </div>

                <!-- Maps Platform Selector -->
                <div class="form-group">
                    <label class="form-label" for="maps_platform">Default Maps Platform</label>
                    <select id="maps_platform" wire:model.live="mapsPlatform" class="form-control" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); cursor: pointer; padding: 0.5rem 0.75rem;">
                        <option value="leaflet" style="background: #0f172a; color: white;">Leaflet Maps (OpenSource)</option>
                        <option value="google" style="background: #0f172a; color: white;">Google Maps Platform</option>
                    </select>
                </div>

                <!-- Google Maps API Key -->
                <div class="form-group">
                    <label class="form-label" for="google_maps_api_key">Google Maps API Key</label>
                    <input type="text" id="google_maps_api_key" wire:model="googleMapsApiKey" class="form-control" placeholder="AIzaSy..." @if($mapsPlatform !== 'google') disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                </div>

                <!-- Maintenance Mode -->
                <div class="form-group" style="display: flex; flex-direction: column; justify-content: center;">
                    <label class="form-label">System Maintenance Mode</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                        <input type="checkbox" id="m_mode" wire:model="maintenanceMode" style="width: 20px; height: 20px; cursor: pointer; accent-color: var(--accent-primary);">
                        <label for="m_mode" style="color: var(--text-secondary); cursor: pointer; font-size: 0.95rem;">Enable Maintenance Hold</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-gradient" style="padding: 0.75rem 2rem; border-radius: 8px;">
                Save Configuration
            </button>
        </form>
    </div>
</div>
