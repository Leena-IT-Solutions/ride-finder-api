<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header" style="margin-bottom: 1.5rem;">
        <div>
            <h1 class="dashboard-title">Vehicles</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.25rem;">View and audit registered driver vehicles in the RideFinder network</p>
        </div>
        <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); padding: 0.5rem 1rem; border-radius: 8px;">
            Showing {{ count($vehicles) }} of {{ $totalMatches }} vehicles
        </span>
    </div>

    <!-- Filters & Search Bar -->
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 1.25rem; margin-bottom: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <!-- Search Input -->
        <div style="flex: 1; min-width: 280px; position: relative;">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by make, model, plate or owner name..." class="form-control" style="padding-left: 2.5rem; margin-bottom: 0; width: 100%;">
            <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">🔍</span>
        </div>

        <!-- Filters group -->
        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: center;">
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

    <!-- Vehicles Cards Layout -->
    <div style="display: flex; flex-direction: column; gap: 1.25rem; width: 100%;">
        @forelse ($vehicles as $vehicle)
            <div class="user-card" wire:key="vehicle-{{ $vehicle->id }}">
                <!-- Left Vehicle Section -->
                <div style="display: flex; align-items: center; gap: 1.25rem; flex: 1; min-width: 250px;">
                    <div style="width: 52px; height: 52px; border-radius: 50%; background: rgba(99, 102, 241, 0.12); color: var(--accent-primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1); flex-shrink: 0;">
                        🚗
                    </div>
                    <div style="min-width: 0;">
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.35rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $vehicle->make }} {{ $vehicle->model }}
                        </h3>
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
                            <span class="badge" style="background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.2); font-weight: 600; text-transform: uppercase;">💳 {{ $vehicle->number_plate }}</span>
                            <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); font-weight: 600;">👥 {{ $vehicle->capacity }} Seats</span>
                        </div>
                    </div>
                </div>

                <!-- Right Owner Section -->
                <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; min-width: 250px; justify-content: flex-end;">
                    <div style="text-align: right;">
                        <span style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 0.25rem;">Owner / Driver</span>
                        @if($vehicle->user)
                            <span style="font-size: 0.95rem; font-weight: 600; color: var(--text-primary); display: block;">{{ $vehicle->user->name }}</span>
                            <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">📞 {{ $vehicle->user->mobile_number }}</span>
                        @else
                            <span style="font-size: 0.9rem; color: var(--text-muted); font-style: italic;">Unknown Owner</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 3rem; text-align: center;">
                <span style="font-size: 2.5rem; display: block; margin-bottom: 1rem;">📭</span>
                <h3 style="color: var(--text-primary); font-size: 1.25rem; font-weight: 600;">No Vehicles Found</h3>
                <p style="color: var(--text-secondary); margin-top: 0.25rem;">Try adjusting your search query.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination/Load More -->
    @if ($hasMore)
        <div style="text-align: center; margin-top: 2rem;">
            <button wire:click="loadMore" class="btn btn-secondary" style="padding: 0.75rem 2rem; border-radius: 12px; font-weight: 600; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--text-primary); cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.03)'" onmouseout="this.style.background='var(--card-bg)'">
                Load More Vehicles
            </button>
        </div>
    @endif
</div>
