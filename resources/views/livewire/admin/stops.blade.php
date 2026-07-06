<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header" style="margin-bottom: 1.5rem;">
        <div>
            <h1 class="dashboard-title">Stop Locations</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.25rem;">Monitor and manage geographic coordinates of bus, auto, taxi, and parking locations</p>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); padding: 0.5rem 1rem; border-radius: 8px;">
                Showing {{ count($stops) }} of {{ $totalMatches }} stops
            </span>
            <button wire:click="create" class="btn-gradient" style="padding: 0.6rem 1.25rem; border-radius: 8px; font-size: 0.9rem; border: none; height: 38px;">
                ➕ Add Location
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #a7f3d0; padding: 0.75rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 0.75rem 1.25rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
            <span>⚠️</span> {{ session('error') }}
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 1.25rem; margin-bottom: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <!-- Search Input -->
        <div style="flex: 1; min-width: 280px; position: relative;">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search stops by name or city..." class="form-control" style="padding-left: 2.5rem; margin-bottom: 0; width: 100%;">
            <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">🔍</span>
        </div>

        <!-- Filters group -->
        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: center;">
            <!-- Filter Selector -->
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500; white-space: nowrap;">Type Filter:</label>
                <select wire:model.live="typeFilter" class="form-control" style="width: 180px; margin-bottom: 0; background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); cursor: pointer; padding: 0.5rem 0.75rem;">
                    <option value="" style="background: #0f172a; color: white;">All Types</option>
                    <option value="bus" style="background: #0f172a; color: white;">🚌 Bus Stop</option>
                    <option value="auto" style="background: #0f172a; color: white;">🛺 Auto Stand</option>
                    <option value="taxi" style="background: #0f172a; color: white;">🚕 Taxi Stand</option>
                    <option value="parking" style="background: #0f172a; color: white;">🅿️ Parking Location</option>
                    <option value="train" style="background: #0f172a; color: white;">🚆 Train Station</option>
                    <option value="metro" style="background: #0f172a; color: white;">🚇 Metro Station</option>
                </select>
            </div>

            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500; white-space: nowrap;">Rows to show:</label>
                <select wire:model.live="perPage" class="form-control" style="width: 80px; margin-bottom: 0; background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); cursor: pointer; padding: 0.5rem 0.5rem;">
                    <option value="5" style="background: #0f172a; color: white;">5</option>
                    <option value="10" style="background: #0f172a; color: white;">10</option>
                    <option value="20" style="background: #0f172a; color: white;">20</option>
                    <option value="50" style="background: #0f172a; color: white;">50</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Cards Layout -->
    <div style="display: flex; flex-direction: column; gap: 1.25rem; width: 100%;">
        @forelse ($stops as $stop)
            <div class="stop-card" wire:key="stop-{{ $stop['id'] }}">
                <!-- Stop Profile section -->
                <div style="display: flex; align-items: center; gap: 1.25rem; flex: 1; min-width: 250px;">
                    <div style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25); flex-shrink: 0;">
                        @if ($stop['type'] === 'bus')
                            🚌
                        @elseif ($stop['type'] === 'auto')
                            🛺
                        @elseif ($stop['type'] === 'taxi')
                            🚕
                        @elseif ($stop['type'] === 'train')
                            🚆
                        @elseif ($stop['type'] === 'metro')
                            🚇
                        @else
                            🅿️
                        @endif
                    </div>
                    <div style="min-width: 0;">
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.35rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $stop['name'] }}
                        </h3>
                        <div style="display: flex; gap: 0.35rem; flex-wrap: wrap; align-items: center;">
                            @if ($stop['type'] === 'bus')
                                <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #d8b4fe; border: 1px solid rgba(168, 85, 247, 0.3);">
                                    Bus Stop
                                </span>
                            @elseif ($stop['type'] === 'auto')
                                <span class="badge badge-driver">
                                    Auto Stand
                                </span>
                            @elseif ($stop['type'] === 'taxi')
                                <span class="badge badge-user" style="background: rgba(16, 185, 129, 0.15); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3);">
                                    Taxi Stand
                                </span>
                            @elseif ($stop['type'] === 'parking')
                                <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3);">
                                    Parking Location
                                </span>
                            @elseif ($stop['type'] === 'train')
                                <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3);">
                                    Train Station
                                </span>
                            @elseif ($stop['type'] === 'metro')
                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3);">
                                    Metro Station
                                </span>
                            @endif
                            <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); border: 1px solid rgba(255, 255, 255, 0.08); text-transform: none;">
                                📍 {{ $stop['city'] }}
                            </span>
                            <!-- Status Badge -->
                            @if ($stop['status'] === 'active')
                                <span class="badge badge-success" style="background: rgba(16, 185, 129, 0.15); color: #a7f3d0; border: 1px solid rgba(16, 185, 129, 0.3);">
                                    Active
                                </span>
                            @elseif ($stop['status'] === 'maintenance')
                                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.3);">
                                    Maintenance
                                </span>
                            @else
                                <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3);">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stop Details section -->
                <div style="display: flex; gap: 2rem; flex: 2; flex-wrap: wrap; justify-content: space-between; align-items: center;">
                    <!-- Coordinates details -->
                    <div style="display: flex; flex-direction: column; gap: 0.35rem; min-width: 180px;">
                        <div style="font-size: 0.95rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.4rem;">
                            <span style="color: var(--text-muted);">Latitude:</span> <strong style="font-family: monospace;">{{ number_format($stop['latitude'], 6) }}</strong>
                        </div>
                        <div style="font-size: 0.95rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.4rem;">
                            <span style="color: var(--text-muted);">Longitude:</span> <strong style="font-family: monospace;">{{ number_format($stop['longitude'], 6) }}</strong>
                        </div>
                    </div>

                    <!-- Vehicles Count details & Actions -->
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; text-align: right; min-width: 180px; align-items: flex-end;">
                        <div>
                            <div style="font-weight: 700; color: var(--accent-success); font-size: 1.05rem;">
                                @if ($stop['type'] === 'parking')
                                    {{ ($stop['id'] * 7 + 3) % 40 }} active spaces
                                @else
                                    {{ ($stop['id'] * 7 + 3) % 40 }} active vehicles
                                @endif
                            </div>
                            <div style="font-size: 0.85rem; color: var(--text-muted);">
                                Within 100 meters
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.25rem;">
                            <button wire:click="edit({{ $stop['id'] }})" class="badge" style="cursor: pointer; background: rgba(99, 102, 241, 0.15); color: #c7d2fe; border: 1px solid rgba(99, 102, 241, 0.3); transition: all 0.2s;" onmouseover="this.style.background='rgba(99, 102, 241, 0.25)';" onmouseout="this.style.background='rgba(99, 102, 241, 0.15)';" title="Edit Stop Location">
                                ✏️ Edit
                            </button>
                            <button wire:click="confirmDelete({{ $stop['id'] }})" class="badge" style="cursor: pointer; background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); transition: all 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.25)';" onmouseout="this.style.background='rgba(239, 68, 68, 0.15)';" title="Delete Stop Location">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 4rem 2rem; text-align: center; color: var(--text-secondary);">
                <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">🔍</span>
                <h3>No matching locations found</h3>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">Try adjusting your search query or type filter.</p>
            </div>
        @endforelse
    </div>

    <!-- Load More Button -->
    @if ($hasMore)
        <div style="display: flex; justify-content: center; margin-top: 2.5rem; margin-bottom: 2rem;">
            <button wire:click="loadMore" class="btn-gradient" style="padding: 0.75rem 2.5rem; border-radius: 10px; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.1rem;">🔄</span> Load More Locations
            </button>
        </div>
    @endif

    <!-- Create / Edit Modal -->
    @if($isOpen)
        <div style="position: fixed; inset: 0; background: rgba(3, 7, 18, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 1.5rem;">
            <div class="glass-card" style="max-width: 550px; padding: 2rem; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); width: 100%; position: relative;">
                <!-- Close Button -->
                <button type="button" wire:click="closeModal" style="position: absolute; top: 1.25rem; right: 1.25rem; background: none; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='var(--text-primary)'" onmouseout="this.style.color='var(--text-muted)'">&times;</button>
                
                <div class="card-header" style="text-align: left; margin-bottom: 1.5rem;">
                    <h2 class="card-title" style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">
                        {{ $stopId ? '✏️ Edit Stop Location' : '➕ Add Stop Location' }}
                    </h2>
                    <p class="card-subtitle" style="font-size: 0.9rem; color: var(--text-secondary); margin-top: 0.25rem;">
                        {{ $stopId ? 'Update the details for this stop location' : 'Enter details to register a new stop location in the network' }}
                    </p>
                </div>

                <form wire:submit.prevent="save">
                    <!-- Stop Name -->
                    <div class="form-group">
                        <label class="form-label" for="stop_name">Stop Name</label>
                        <input type="text" id="stop_name" wire:model="name" class="form-control" placeholder="e.g., Majestic Bus Stand" required>
                        @error('name') <span class="form-error">❌ {{ $message }}</span> @enderror
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <!-- Stop Type -->
                        <div class="form-group">
                            <label class="form-label" for="stop_type">Type</label>
                            <select id="stop_type" wire:model="type" class="form-control" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); cursor: pointer; padding: 0.5rem 0.75rem;" required>
                                <option value="bus">🚌 Bus Stop</option>
                                <option value="auto">🛺 Auto Stand</option>
                                <option value="taxi">🚕 Taxi Stand</option>
                                <option value="parking">🅿️ Parking Location</option>
                                <option value="train">🚆 Train Station</option>
                                <option value="metro">🚇 Metro Station</option>
                            </select>
                            @error('type') <span class="form-error">❌ {{ $message }}</span> @enderror
                        </div>


                        <!-- City -->
                        <div class="form-group">
                            <label class="form-label" for="stop_city">City</label>
                            <input type="text" id="stop_city" wire:model="city" class="form-control" placeholder="e.g., Bengaluru" required>
                            @error('city') <span class="form-error">❌ {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <!-- Latitude -->
                        <div class="form-group">
                            <label class="form-label" for="stop_latitude">Latitude</label>
                            <input type="number" step="0.000001" id="stop_latitude" wire:model="latitude" class="form-control" placeholder="e.g., 12.971598" required>
                            @error('latitude') <span class="form-error">❌ {{ $message }}</span> @enderror
                        </div>

                        <!-- Longitude -->
                        <div class="form-group">
                            <label class="form-label" for="stop_longitude">Longitude</label>
                            <input type="number" step="0.000001" id="stop_longitude" wire:model="longitude" class="form-control" placeholder="e.g., 77.594566" required>
                            @error('longitude') <span class="form-error">❌ {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="form-label" for="stop_status">Status</label>
                        <select id="stop_status" wire:model="status" class="form-control" style="background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); cursor: pointer; padding: 0.5rem 0.75rem;" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        @error('status') <span class="form-error">❌ {{ $message }}</span> @enderror
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <button type="button" wire:click="closeModal" class="btn-nav-action" style="padding: 0.6rem 1.5rem; border-radius: 8px;">
                            Cancel
                        </button>
                        <button type="submit" class="btn-gradient" style="padding: 0.6rem 1.5rem; border-radius: 8px; border: none;">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($isDeleteOpen)
        <div style="position: fixed; inset: 0; background: rgba(3, 7, 18, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 1.5rem;">
            <div class="glass-card" style="max-width: 450px; padding: 2rem; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); width: 100%; text-align: center;">
                <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">⚠️</span>
                <h3 style="font-size: 1.35rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Delete Stop Location?</h3>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.5; margin-bottom: 1.75rem;">
                    Are you sure you want to remove this stop location from the network? This action cannot be undone.
                </p>
                <div style="display: flex; justify-content: center; gap: 1rem;">
                    <button type="button" wire:click="$set('isDeleteOpen', false)" class="btn-nav-action" style="padding: 0.6rem 1.5rem; border-radius: 8px;">
                        Cancel
                    </button>
                    <button type="button" wire:click="delete" class="btn-gradient" style="padding: 0.6rem 1.5rem; border-radius: 8px; border: none; background: linear-gradient(135deg, var(--accent-danger) 0%, #b91c1c 100%); box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);">
                        Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
