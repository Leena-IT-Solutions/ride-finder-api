<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header" style="margin-bottom: 1.5rem;">
        <div>
            <h1 class="dashboard-title">Users</h1>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.25rem;">View and audit registered users in the RideFinder network</p>
        </div>
        <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); padding: 0.5rem 1rem; border-radius: 8px;">
            Showing {{ count($users) }} of {{ $totalMatches }} users
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
            <!-- Role filter selector -->
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500; white-space: nowrap;">Role Filter:</label>
                <select wire:model.live="roleFilter" class="form-control" style="width: 130px; margin-bottom: 0; background: var(--input-bg); border: 1px solid var(--input-border); color: var(--text-primary); cursor: pointer; padding: 0.5rem 0.75rem;">
                    <option value="" style="background: #0f172a; color: white;">All Roles</option>
                    <option value="admin" style="background: #0f172a; color: white;">Admin</option>
                    <option value="manager" style="background: #0f172a; color: white;">Manager</option>
                    <option value="driver" style="background: #0f172a; color: white;">Driver</option>
                    <option value="user" style="background: #0f172a; color: white;">User</option>
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
        @forelse ($users as $user)
            <div class="user-card" wire:key="user-{{ $user->id }}">
                <!-- User Left Profile section -->
                <div style="display: flex; align-items: center; gap: 1.25rem; flex: 1; min-width: 250px;">
                    @if($user->profile_photo)
                        @if(str_starts_with($user->profile_photo, 'http'))
                            <img src="{{ $user->profile_photo }}" style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-primary); flex-shrink: 0; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);" alt="Profile Photo" />
                        @else
                            <div style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary)); color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700; flex-shrink: 0; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);" title="Local Path: {{ $user->profile_photo }}">
                                <span>📱 Local</span>
                                <span style="font-size: 0.5rem; max-width: 48px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ basename($user->profile_photo) }}</span>
                            </div>
                        @endif
                    @else
                        <div style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25); flex-shrink: 0;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="min-width: 0;">
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.35rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $user->name }}
                        </h3>
                        <div style="display: flex; gap: 0.35rem; flex-wrap: wrap; align-items: center;">
                            @foreach ($user->roles ?? [] as $role)
                                <span class="badge badge-{{ strtolower($role) }}">{{ $role }}</span>
                            @endforeach
                        </div>
                        
                        <!-- Toggle Roles buttons -->
                        <div style="margin-top: 0.75rem; display: flex; align-items: center; gap: 0.35rem; flex-wrap: wrap;">
                            <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-right: 0.25rem;">Toggle Role:</span>
                            @foreach(['admin', 'manager', 'driver', 'user'] as $roleName)
                                @php
                                    $hasRole = in_array($roleName, $user->roles ?? []);
                                @endphp
                                <button 
                                    wire:click="toggleRole({{ $user->id }}, '{{ $roleName }}')" 
                                    class="badge" 
                                    style="cursor: pointer; transition: all 0.25s ease; font-size: 0.65rem; padding: 0.15rem 0.5rem; text-transform: capitalize;
                                           background: {{ $hasRole ? 'rgba(99, 102, 241, 0.22)' : 'rgba(255, 255, 255, 0.03)' }}; 
                                           color: {{ $hasRole ? '#c7d2fe' : 'var(--text-muted)' }}; 
                                           border: 1px solid {{ $hasRole ? 'rgba(99, 102, 241, 0.45)' : 'rgba(255, 255, 255, 0.08)' }};"
                                    onmouseover="this.style.background='{{ $hasRole ? 'rgba(239, 68, 68, 0.15)' : 'rgba(99, 102, 241, 0.15)' }}'; this.style.color='{{ $hasRole ? '#f87171' : '#c7d2fe' }}'; this.style.borderColor='{{ $hasRole ? 'rgba(239, 68, 68, 0.4)' : 'rgba(99, 102, 241, 0.5)' }}';"
                                    onmouseout="this.style.background='{{ $hasRole ? 'rgba(99, 102, 241, 0.22)' : 'rgba(255, 255, 255, 0.03)' }}'; this.style.color='{{ $hasRole ? '#c7d2fe' : 'var(--text-muted)' }}'; this.style.borderColor='{{ $hasRole ? 'rgba(99, 102, 241, 0.45)' : 'rgba(255, 255, 255, 0.08)' }}';"
                                    title="{{ $hasRole ? 'Click to revoke ' . $roleName : 'Click to assign ' . $roleName }}"
                                >
                                    {{ $hasRole ? '✓' : '+' }} {{ $roleName }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- User Details section -->
                <div style="display: flex; gap: 2.5rem; flex: 2; flex-wrap: wrap; justify-content: space-between; align-items: center;">
                    <!-- Contact details -->
                    <div style="display: flex; flex-direction: column; gap: 0.35rem; min-width: 180px;">
                        <div style="font-size: 0.95rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.4rem;">
                            <span style="color: var(--text-muted);">📞 Mobile:</span> <strong>{{ $user->mobile_number }}</strong>
                        </div>
                        <div style="font-size: 0.95rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.4rem;">
                            <span style="color: var(--text-muted);">📧 Email:</span> 
                            @if ($user->email)
                                <span>{{ $user->email }}</span>
                            @else
                                <span style="color: var(--text-muted); font-style: italic;">Not provided</span>
                            @endif
                        </div>
                    </div>

                    <!-- Driver Documents section -->
                    @if(in_array('driver', $user->roles ?? []) || $user->drivers_license_photo || $user->profile_photo)
                        <div style="display: flex; align-items: center; gap: 1rem; min-width: 220px; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--card-border); padding: 0.5rem 0.75rem; border-radius: 12px;">
                            <!-- Profile Photo Thumb -->
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                                <span style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Profile</span>
                                @if($user->profile_photo)
                                    @if(str_starts_with($user->profile_photo, 'http'))
                                        <button type="button" wire:click="openPhotoModal('{{ $user->profile_photo }}', 'Profile Photo of {{ addslashes($user->name) }}')" style="background: none; border: none; padding: 0; cursor: pointer; display: block;">
                                            <img src="{{ $user->profile_photo }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.1);" />
                                        </button>
                                    @else
                                        <div style="width: 48px; height: 48px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; cursor: help;" title="Local File: {{ $user->profile_photo }}">
                                            <span style="font-size: 1.25rem;">🖼️</span>
                                        </div>
                                    @endif
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 8px; background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                                        <span style="font-size: 0.7rem; color: var(--text-muted);">None</span>
                                    </div>
                                @endif
                            </div>

                            <!-- License Photo Thumb -->
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                                <span style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">License</span>
                                @if($user->drivers_license_photo)
                                    @if(str_starts_with($user->drivers_license_photo, 'http'))
                                        <button type="button" wire:click="openPhotoModal('{{ $user->drivers_license_photo }}', 'Driver\'s License of {{ addslashes($user->name) }}')" style="background: none; border: none; padding: 0; cursor: pointer; display: block;">
                                            <img src="{{ $user->drivers_license_photo }}" style="width: 76px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.1);" />
                                        </button>
                                    @else
                                        <div style="width: 76px; height: 48px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; cursor: help;" title="Local File: {{ $user->drivers_license_photo }}">
                                            <span style="font-size: 1.25rem;">🪪</span>
                                        </div>
                                    @endif
                                @else
                                    <div style="width: 76px; height: 48px; border-radius: 8px; background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                                        <span style="font-size: 0.7rem; color: var(--text-muted);">None</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Geo & Time details -->
                    <div style="display: flex; flex-direction: column; gap: 0.35rem; text-align: right; min-width: 180px;">
                        <div style="font-size: 0.9rem; color: var(--text-secondary); display: flex; flex-direction: column; align-items: flex-end; gap: 0.25rem;">
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <span style="color: var(--text-muted);">📍 Location:</span> 
                                @if ($user->current_location)
                                    <strong style="color: var(--text-primary);">{{ $user->current_location }}</strong>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">Not set</span>
                                @endif
                            </div>
                            @if ($user->latitude && $user->longitude)
                                <span style="font-family: monospace; color: var(--accent-primary); font-size: 0.8rem; font-weight: 600;">
                                    Coords: {{ number_format($user->latitude, 4) }}, {{ number_format($user->longitude, 4) }}
                                </span>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $user->latitude }},{{ $user->longitude }}" target="_blank" style="margin-top: 0.25rem; display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.8rem; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); color: #818cf8; padding: 0.25rem 0.6rem; border-radius: 6px; text-decoration: none; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(99, 102, 241, 0.25)'" onmouseout="this.style.background='rgba(99, 102, 241, 0.15)'">
                                    🗺️ View on Maps
                                </a>
                            @endif
                        </div>
                        <div style="font-size: 0.85rem; color: var(--text-muted);">
                            Joined: {{ $user->created_at->format('M d, Y h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 4rem 2rem; text-align: center; color: var(--text-secondary);">
                <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">🔍</span>
                <h3>No matching users found</h3>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">Try adjusting your search query or role filter settings.</p>
            </div>
        @endforelse
    </div>

    <!-- Load More Button -->
    @if ($hasMore)
        <div style="display: flex; justify-content: center; margin-top: 2.5rem; margin-bottom: 2rem;">
            <button wire:click="loadMore" class="btn-gradient" style="padding: 0.75rem 2.5rem; border-radius: 10px; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.1rem;">🔄</span> Load More Users
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
