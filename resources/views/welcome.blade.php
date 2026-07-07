<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ride Finder - Smart City Transit & Driver Tracking</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #070913;
            --card-bg: rgba(15, 18, 37, 0.7);
            --text-color: #e2e8f0;
            --text-muted: #94a3b8;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --border-color: rgba(30, 41, 59, 0.8);
            --glow: rgba(99, 102, 241, 0.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Glowing background blobs */
        body::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, rgba(0,0,0,0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, rgba(0,0,0,0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            z-index: 10;
            position: relative;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-dot {
            width: 10px;
            height: 10px;
            background-color: var(--primary);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 10px var(--primary);
            animation: pulse 2s infinite;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease-in-out;
            font-size: 1rem;
        }

        .nav-link:hover {
            color: #fff;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary);
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            box-shadow: none;
        }

        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: var(--text-muted);
        }

        .main-hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 4rem 1.5rem;
            text-align: center;
            z-index: 1;
            position: relative;
        }

        .hero-badge {
            background-color: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            color: #818cf8;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff 30%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .hero-desc {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 700px;
            margin-bottom: 3rem;
        }

        .hero-ctas {
            display: flex;
            gap: 1rem;
            margin-bottom: 5rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            width: 100%;
            margin-top: 2rem;
        }

        .feature-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1.25rem;
            padding: 2.5rem 2rem;
            text-align: left;
            transition: all 0.3s ease-in-out;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(99, 102, 241, 0.4);
            box-shadow: 0 12px 30px -10px rgba(99, 102, 241, 0.15);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background-color: rgba(99, 102, 241, 0.1);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.75rem;
        }

        .feature-desc {
            color: var(--text-muted);
            font-size: 0.975rem;
        }

        footer {
            border-top: 1px solid var(--border-color);
            padding: 2rem 1.5rem;
            margin-top: auto;
            z-index: 10;
            position: relative;
            background-color: rgba(7, 9, 19, 0.8);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-link {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }

        .footer-link:hover {
            color: #fff;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
                box-shadow: 0 0 10px var(--primary);
            }
            50% {
                transform: scale(1.2);
                opacity: 0.7;
                box-shadow: 0 0 20px var(--primary);
            }
        }

        .download-section {
            margin-top: 6rem;
            margin-bottom: 2rem;
            max-width: 800px;
            width: 100%;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(99, 102, 241, 0.02) 100%);
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            padding: 3rem 2rem;
            text-align: center;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .download-title {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.5rem;
        }

        .download-desc {
            color: var(--text-muted);
            font-size: 1.05rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .store-buttons {
            display: flex;
            justify-content: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .store-btn {
            display: inline-flex;
            align-items: center;
            background-color: #0c0f1d;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.6rem 1.4rem;
            text-decoration: none;
            color: #fff;
            text-align: left;
            transition: all 0.2s ease-in-out;
            min-width: 180px;
            gap: 0.75rem;
        }

        .store-btn:hover {
            border-color: var(--primary);
            background-color: rgba(99, 102, 241, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.2);
        }

        .store-svg {
            color: var(--primary);
            width: 28px;
            height: 28px;
            transition: color 0.2s ease-in-out;
        }

        .store-btn:hover .store-svg {
            color: #fff;
        }

        .store-text {
            display: flex;
            flex-direction: column;
        }

        .store-sub {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }

        .store-main {
            font-size: 1.1rem;
            font-weight: 700;
        }

        @media (max-width: 1024px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.75rem;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
            .hero-ctas {
                flex-direction: column;
                width: 100%;
                max-width: 320px;
            }
            .footer-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" class="logo">
            <span class="logo-dot"></span>Ride Finder
        </a>
        <div class="nav-links">
            <a href="{{ url('/privacy-policy') }}" class="nav-link">Privacy Policy</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn">Admin Portal</a>
            @endauth
        </div>
    </nav>

    <main class="main-hero">
        <div class="hero-badge">
            <span>✦</span> Smart Transit Infrastructure
        </div>
        <h1 class="hero-title">Live Tracking & City Transit Management</h1>
        <p class="hero-desc">
            An advanced platform designed to monitor driver location tracking updates, verify vehicle capacities, and coordinate optimal stop configurations for city transit.
        </p>

        <div class="hero-ctas">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn">Access Admin Portal</a>
                <a href="{{ url('/privacy-policy') }}" class="btn btn-outline">Read Privacy Policy</a>
            @endauth
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🛰️</div>
                <h3 class="feature-title">Live Tracking Updates</h3>
                <p class="feature-desc">Drivers report location coordinates periodically based on custom interval configurations set by site administrators.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3 class="feature-title">Verified Operators</h3>
                <p class="feature-desc">Drivers undergo strict document verification for profiling and license uploads before going online.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📍</div>
                <h3 class="feature-title">Route Stop Optimization</h3>
                <p class="feature-desc">Define passenger stops and allocate vehicles to route networks seamlessly in our administrative center.</p>
            </div>
        </div>

        <div class="download-section">
            <h2 class="download-title">Download Ride Finder</h2>
            <p class="download-desc">Get the mobile application on your device to coordinate city trips, track driver coordinates, and manage vehicle checklists in real-time.</p>
            <div class="store-buttons">
                <!-- App Store -->
                <a href="#" class="store-btn">
                    <svg class="store-svg" viewBox="0 0 384 512" fill="currentColor">
                        <path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-48.7-22.7-77.9-22.1-38.6 .6-74.1 22.7-93.7 56.6-40.1 69-10.4 171.9 28.6 228.6 19.1 27.8 41.5 58.7 71.9 57.5 29.2-1.2 40.2-18.8 75.5-18.8 35.1 0 45.3 18.8 75.5 18.1 30.8-.6 50.4-28.1 69.4-56.1 21.8-32 30.8-63 31.2-64.6-.7-.3-60-23-60.3-91.8zM245.9 76.1c16-20.2 26.6-47.8 23.6-76.1-24.1 1-53.7 16.2-71.1 36.8-15.4 18.1-29 46.1-25.2 73.9 26.9 2.1 55-12.8 72.7-34.6z"/>
                    </svg>
                    <div class="store-text">
                        <span class="store-sub">Download on the</span>
                        <span class="store-main">App Store</span>
                    </div>
                </a>

                <!-- Play Store -->
                <a href="#" class="store-btn">
                    <svg class="store-svg" viewBox="0 0 512 512" fill="currentColor">
                        <path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58 33.2-60.1-60.1 118.1 26.9zM104.6 499l220.7-220.7 60.1 60.1L104.6 499z"/>
                    </svg>
                    <div class="store-text">
                        <span class="store-sub">Get it on</span>
                        <span class="store-main">Google Play</span>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div>
                &copy; 2026 Ride Finder. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="{{ url('/privacy-policy') }}" class="footer-link">Privacy Policy</a>
                <a href="{{ route('login') }}" class="footer-link">Admin Login</a>
            </div>
        </div>
    </footer>
</body>
</html>
