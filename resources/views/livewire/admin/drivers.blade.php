<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header" style="margin-bottom: 1.5rem;">
        <div>
            <h1 class="dashboard-title">Drivers Verification</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.25rem;">Verify and audit registered driver licenses and documents in the RideFinder network</p>
        </div>
        <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); padding: 0.5rem 1rem; border-radius: 8px;">
            Showing {{ count($drivers) }} of {{ $totalMatches }} drivers
        </span>
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

    <!-- Filters & Search Bar -->
    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 1.25rem; margin-bottom: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <!-- Search Input -->
        <div style="flex: 1; min-width: 280px; position: relative;">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name, email or mobile..." class="form-control" style="padding-left: 2.5rem; margin-bottom: 0; width: 100%;">
            <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">🔍</span>
        </div>

        <!-- Filters group -->
        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: center;">
            <!-- Status filter selector -->
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500; white-space: nowrap;">Status Filter:</label>
                <select wire:model.live="statusFilter" class="form-control" style="width: 150px; margin-bottom: 0; background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); cursor: pointer; padding: 0.5rem 0.75rem;">
                    <option value="" style="background: #0f172a; color: white;">All Statuses</option>
                    <option value="pending" style="background: #0f172a; color: white;">Pending</option>
                    <option value="verified" style="background: #0f172a; color: white;">Verified</option>
                    <option value="rejected" style="background: #0f172a; color: white;">Rejected</option>
                    <option value="unsubmitted" style="background: #0f172a; color: white;">Unsubmitted</option>
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

    <!-- Drivers Cards Layout -->
    <div style="display: flex; flex-direction: column; gap: 1.25rem; width: 100%;">
        @forelse ($drivers as $driver)
            <div class="user-card" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; width: 100%; align-items: center; padding: 1.75rem;" wire:key="driver-{{ $driver->id }}">
                
                <!-- Col 1: Driver Profile Info -->
                <div style="display: flex; align-items: center; gap: 1.25rem; min-width: 0;">
                    @if($driver->profile_photo)
                        @if(str_starts_with($driver->profile_photo, 'http'))
                            <img src="{{ $driver->profile_photo }}" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2.5px solid var(--accent-primary); flex-shrink: 0; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);" alt="Profile Photo" />
                        @else
                            <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary)); color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);">
                                <span>📱 Local</span>
                            </div>
                        @endif
                    @else
                        <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.5rem; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); flex-shrink: 0;">
                            {{ strtoupper(substr($driver->name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="min-width: 0;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.4rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $driver->name }}
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 0.3rem; font-size: 0.9rem; color: var(--text-secondary);">
                            <span style="display: flex; align-items: center; gap: 0.4rem;">
                                <span style="color: var(--accent-primary);">📞</span> {{ $driver->mobile_number }}
                            </span>
                            <span style="display: flex; align-items: center; gap: 0.4rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <span style="color: var(--accent-primary);">✉️</span> {{ $driver->email ?? 'No email provided' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Driver Documents Preview -->
                <div style="display: flex; align-items: center; gap: 1.5rem; justify-content: center; background: rgba(0, 0, 0, 0.15); border: 1px solid var(--card-border); padding: 0.75rem 1.25rem; border-radius: 14px; width: fit-content; margin: 0 auto; min-width: 220px;">
                    <!-- Profile Photo Preview -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.35rem;">
                        <span style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Profile Photo</span>
                        @if($driver->profile_photo)
                            <button type="button" wire:click="openPhotoModal('{{ $driver->profile_photo }}', 'Profile Photo of {{ addslashes($driver->name) }}')" style="background: none; border: none; padding: 0; cursor: pointer; display: inline-block; transition: all 0.2s ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                                <img src="{{ $driver->profile_photo }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 10px rgba(0,0,0,0.3);" />
                            </button>
                        @else
                            <span style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Not uploaded</span>
                        @endif
                    </div>

                    <!-- Divider -->
                    <div style="width: 1px; height: 40px; background: var(--card-border);"></div>

                    <!-- Drivers License Preview -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.35rem;">
                        <span style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Driver's License</span>
                        @if($driver->drivers_license_photo)
                            <button type="button" wire:click="openPhotoModal('{{ $driver->drivers_license_photo }}', 'Driver\'s License of {{ addslashes($driver->name) }}')" style="background: none; border: none; padding: 0; cursor: pointer; display: inline-block; transition: all 0.2s ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                                <img src="{{ $driver->drivers_license_photo }}" style="width: 76px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 10px rgba(0,0,0,0.3);" />
                            </button>
                        @else
                            <span style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Not uploaded</span>
                        @endif
                    </div>
                </div>

                <!-- Col 3: Status & Action Buttons -->
                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.75rem; justify-content: center; min-width: 200px;">
                    <!-- Verification Status Badge -->
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Status:</span>
                        @if($driver->driver_verification_status === 'verified')
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 700; padding: 0.35rem 0.75rem; font-size: 0.75rem;">Verified</span>
                        @elseif($driver->driver_verification_status === 'pending')
                            <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); font-weight: 700; padding: 0.35rem 0.75rem; font-size: 0.75rem; animation: pulse 2s infinite;">Pending Review</span>
                        @elseif($driver->driver_verification_status === 'rejected')
                            <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); font-weight: 700; padding: 0.35rem 0.75rem; font-size: 0.75rem;">Rejected</span>
                        @else
                            <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-muted); border: 1px solid var(--card-border); font-weight: 700; padding: 0.35rem 0.75rem; font-size: 0.75rem;">Unsubmitted</span>
                        @endif
                    </div>

                    <!-- Approve/Reject Actions -->
                    <div style="display: flex; gap: 0.5rem; align-items: center; width: 100%; justify-content: flex-end;">
                        @if($driver->driver_verification_status !== 'verified')
                            <button 
                                wire:click="verifyDriver({{ $driver->id }})" 
                                class="btn-gradient" 
                                style="padding: 0.5rem 1.25rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); border: none;"
                                onmouseover="this.style.filter='brightness(1.1)'"
                                onmouseout="this.style.filter='brightness(1)'">
                                Approve
                            </button>
                        @endif

                        @if($driver->driver_verification_status !== 'rejected')
                            <button 
                                wire:click="rejectDriver({{ $driver->id }})" 
                                class="btn-nav-action" 
                                style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); color: #fca5a5; padding: 0.5rem 1.25rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.background='rgba(239, 68, 68, 0.18)'"
                                onmouseout="this.style.background='rgba(239, 68, 68, 0.08)'">
                                Reject
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 3rem; text-align: center;">
                <span style="font-size: 2.5rem; display: block; margin-bottom: 1rem;">📭</span>
                <h3 style="color: var(--text-primary); font-size: 1.25rem; font-weight: 600;">No Drivers Found</h3>
                <p style="color: var(--text-secondary); margin-top: 0.25rem;">Try adjusting your filters or search keywords.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination/Load More -->
    @if ($hasMore)
        <div style="text-align: center; margin-top: 2rem;">
            <button wire:click="loadMore" class="btn btn-secondary" style="padding: 0.75rem 2rem; border-radius: 12px; font-weight: 600; border: 1px solid var(--card-border); background: var(--card-bg); color: var(--text-primary); cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.03)'" onmouseout="this.style.background='var(--card-bg)'">
                Load More Drivers
            </button>
        </div>
    @endif

    <!-- Photo Modal -->
    @if($isPhotoModalOpen)
        <div style="position: fixed; inset: 0; background: rgba(3, 7, 18, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 1.5rem;" wire:click.self="closePhotoModal">
            <div class="glass-card" style="max-width: 700px; padding: 2rem; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); width: 100%; position: relative; text-align: center;">
                <!-- Close Button -->
                <button type="button" wire:click="closePhotoModal" style="position: absolute; top: 1.25rem; right: 1.25rem; background: none; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='var(--text-primary)'" onmouseout="this.style.color='var(--text-muted)'">&times;</button>
                
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1.5rem; text-align: left;">
                    {{ $activeModalTitle }}
                </h3>

                <div style="background: rgba(0, 0, 0, 0.2); border-radius: 12px; padding: 0.5rem; display: inline-block; max-width: 100%; box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.5);">
                    <img src="{{ $activeModalPhoto }}" style="max-width: 100%; max-height: 70vh; border-radius: 8px; object-fit: contain; display: block;" />
                </div>
            </div>
        </div>
    @endif
</div>
