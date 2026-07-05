<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'RideFinder Admin' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Assets Management (SCSS & JS via Vite) -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>

    @auth
        <!-- Authenticated Admin Layout with Left Sidebar -->
        <div class="admin-layout">
            
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <a href="/" class="sidebar-brand">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent-primary)"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>
                        Ride<span class="text-accent" style="-webkit-text-fill-color: initial;">Finder</span>
                    </a>
                    <button class="sidebar-close" onclick="toggleSidebar()">×</button>
                </div>
                
                <nav class="sidebar-menu">
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="menu-item-icon">📊</span> Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}" class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <span class="menu-item-icon">👤</span> Users
                    </a>
                    <a href="{{ route('admin.stops') }}" class="menu-item {{ request()->routeIs('admin.stops') ? 'active' : '' }}">
                        <span class="menu-item-icon">📍</span> Stop Locations
                    </a>
                    <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <span class="menu-item-icon">⚙️</span> Settings
                    </a>
                </nav>

                <div class="sidebar-footer" style="padding: 1.25rem 1rem; border-top: 1px solid var(--card-border); background: rgba(0, 0, 0, 0.1);">
                    <div class="user-profile-widget" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--card-border); border-radius: 12px; padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; width: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                        <div style="display: flex; align-items: center; gap: 0.75rem; min-width: 0; flex: 1;">
                            <div class="profile-avatar" style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.95rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.25);">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div style="min-width: 0; display: flex; flex-direction: column;">
                                <span class="profile-name" style="font-size: 0.88rem; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.2;">{{ auth()->user()->name }}</span>
                                <span style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; margin-top: 0.2rem; font-weight: 700; letter-spacing: 0.05em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ implode(' • ', auth()->user()->roles ?? []) }}
                                </span>
                            </div>
                        </div>
                        <livewire:auth.logout />
                    </div>
                </div>
            </aside>

            <!-- Main Area -->
            <div class="main-wrapper">
                <!-- Top Header Bar -->
                <header class="topbar">
                    <button class="menu-toggle-btn" onclick="toggleSidebar()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div class="topbar-title">
                        @if(request()->routeIs('admin.dashboard')) Dashboard
                        @elseif(request()->routeIs('admin.users')) Users
                        @elseif(request()->routeIs('admin.stops')) Stop Locations
                        @elseif(request()->routeIs('admin.settings')) Portal Settings
                        @else Portal
                        @endif
                    </div>
                    <div style="font-size: 0.9rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.5rem;">
                        <span style="display:inline-block; width:8px; height:8px; background:var(--accent-success); border-radius:50%;"></span>
                        Live Session
                    </div>
                </header>

                <!-- Page Content Slot -->
                <main class="admin-content">
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        <!-- Toggle Sidebar Script -->
        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('open');
            }
        </script>

    @else
        <!-- Guest Centered Layout -->
        <div class="guest-layout">
            <header class="guest-navbar">
                <a href="/" class="guest-navbar-brand">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent-primary)"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>
                    Ride<span class="text-accent" style="-webkit-text-fill-color: initial;">Finder</span>
                </a>
                <div class="guest-navbar-nav" style="display: flex; gap: 1.5rem;">
                    <a href="{{ route('login') }}" class="nav-link" style="color: var(--text-secondary); text-decoration: none; font-weight: 500;">Login</a>
                    <a href="{{ route('register') }}" class="nav-link" style="color: var(--text-secondary); text-decoration: none; font-weight: 500;">Register</a>
                </div>
            </header>

            <main class="guest-content">
                {{ $slot }}
            </main>

            <footer class="guest-footer">
                <p>&copy; {{ date('Y') }} RideFinder. All rights reserved.</p>
            </footer>
        </div>
    @endauth

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
