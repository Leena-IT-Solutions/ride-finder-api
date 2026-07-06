<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header" style="margin-bottom: 1.5rem;">
        <div>
            <h1 class="dashboard-title">Stop Locations</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.25rem;">Monitor and manage geographic coordinates of bus, auto, taxi, and parking locations</p>
        </div>
        <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); padding: 0.5rem 1rem; border-radius: 8px;">
            Showing {{ count($stops) }} of {{ $totalMatches }} stops
        </span>
    </div>

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
                </select>
            </div>

            <!-- Page Row size selector -->
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
                            @else
                                <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3);">
                                    Parking Location
                                </span>
                            @endif

                            <!-- City Badge -->
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
                    <div style="display: flex; flex-direction: column; gap: 0.35rem; min-width: 200px;">
                        <div style="font-size: 0.95rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.4rem;">
                            <span style="color: var(--text-muted);">Latitude:</span> <strong style="font-family: monospace;">{{ number_format($stop['latitude'], 6) }}</strong>
                        </div>
                        <div style="font-size: 0.95rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.4rem;">
                            <span style="color: var(--text-muted);">Longitude:</span> <strong style="font-family: monospace;">{{ number_format($stop['longitude'], 6) }}</strong>
                        </div>
                    </div>

                    <!-- Vehicles Count details -->
                    <div style="display: flex; flex-direction: column; gap: 0.35rem; text-align: right; min-width: 180px;">
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
</div>
