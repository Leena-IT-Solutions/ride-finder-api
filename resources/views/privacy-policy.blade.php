<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - Ride Finder</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #070913;
            --card-bg: #0f1225;
            --text-color: #e2e8f0;
            --text-muted: #94a3b8;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --border-color: #1e293b;
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
            padding: 2rem 1rem;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            padding: 3rem 2.5rem;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(0,0,0,0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        header {
            margin-bottom: 2.5rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .last-updated {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #fff;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 1.2rem;
            font-size: 1.05rem;
        }

        ul {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        li {
            color: var(--text-muted);
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.8rem;
            font-size: 1.05rem;
        }

        li::before {
            content: "✦";
            color: var(--primary);
            position: absolute;
            left: 0;
            top: 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary);
            color: #fff;
            padding: 0.8rem 1.8rem;
            border-radius: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
            margin-top: 2rem;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            margin-right: 1rem;
        }

        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: var(--text-muted);
        }

        @media (max-width: 640px) {
            .container {
                padding: 2rem 1.5rem;
            }
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <header>
                <h1>Privacy Policy</h1>
                <div class="last-updated">Last Updated: July 2026</div>
            </header>

            <section>
                <p>Welcome to <strong>Ride Finder</strong>. Your privacy is of paramount importance to us. This Privacy Policy details how we collect, use, protect, and disclose information from our users (drivers, commuters, and system administrators) when using our platform.</p>

                <h2>1. Information We Collect</h2>
                <p>To provide seamless city transit and live tracking services, we collect the following categories of information:</p>
                <ul>
                    <li><strong>Real-Time Location Data:</strong> When drivers are set to live status, we collect and process precise GPS location coordinates periodically (as configured by the system, e.g., every 20 seconds). This data is necessary to display real-time vehicle mapping coordinates to commuters.</li>
                    <li><strong>Personal Profiles:</strong> Name, email address, phone number, and profile photography.</li>
                    <li><strong>Vehicle Verification:</strong> License plate number, registration credentials, insurance files, and vehicle capacity specifications.</li>
                    <li><strong>Driver's License & Credentials:</strong> Photos of your government-issued Driver's License and administrative documentation for safety verification.</li>
                    <li><strong>Device Permissions:</strong> Access to Camera and Photo Library to capture or select profile images and license documentation.</li>
                </ul>

                <h2>2. How We Use Your Information</h2>
                <p>We process collected information to fulfill the core operations of the Ride Finder application:</p>
                <ul>
                    <li>To authenticate accounts and enable secure dashboard logins.</li>
                    <li>To verify drivers' credentials and vehicles to ensure commuter safety before authorizing live operations.</li>
                    <li>To display live driver coordinates and update markers on transit map interfaces.</li>
                    <li>To log recent driver-commuter connection queries and inquiries securely.</li>
                </ul>

                <h2>3. Information Sharing and Disclosure</h2>
                <p>We do not sell your personal data. Location coordinates, vehicle models, and driver names are shared with commuters requesting transit routes solely to facilitate matching. Internal administrators hold access to driver documentation strictly for safety audit and verification purposes.</p>

                <h2>4. Data Security</h2>
                <p>We enforce industry-standard security safeguards to protect your personal details, including encrypted passwords, secure HTTPS API communication, and isolated document storage. Keystore configurations are maintained securely under git protection.</p>

                <h2>5. Contact Us</h2>
                <p>If you have any questions regarding this Privacy Policy or data deletion requests, you may contact support at leenaitsolutions@gmail.com.</p>

                <div class="actions">
                    <a href="{{ url('/') }}" class="btn btn-outline">Back to Landing</a>
                    <a href="{{ route('login') }}" class="btn">Admin Portal</a>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
