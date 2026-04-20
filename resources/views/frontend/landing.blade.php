<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Urge Care | Your Health, Our Priority</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0047AB;
            --brand-teal: #4ca6a6;
            --brand-red: #ff0000;
            --text-color: #1a1a1a;
            --bg-glass: rgba(255, 255, 255, 0.85);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            background: #000 url('{{ asset('assets/images/landing_bg.png') }}') no-repeat center center/cover;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 71, 171, 0.4) 0%, rgba(0, 0, 0, 0.7) 100%);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            width: 100%;
            padding: 0 20px;
            text-align: center;
        }

        .header {
            margin-bottom: 60px;
            color: #fff;
            animation: fadeInDown 1s ease-out;
        }

        .logo-text {
            font-weight: 700;
            font-size: 3.5rem;
            letter-spacing: -2px;
            margin-bottom: 10px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
            color: var(--brand-teal);
        }

        .logo-text span {
            color: var(--brand-red);
        }

        .tagline {
            font-size: 1.25rem;
            font-weight: 300;
            opacity: 0.9;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            perspective: 2000px;
        }

        .option-card {
            background: #ffffff;
            border-radius: 32px;
            padding: 50px 40px;
            text-decoration: none;
            color: var(--text-color);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: fadeInUp 1s ease-out backwards;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .option-card:hover {
            transform: translateY(-20px);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.2);
            border-color: var(--brand-teal);
        }

        .icon-box {
            width: 100px;
            height: 100px;
            background: rgba(0, 0, 0, 0.03);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 2;
        }

        .option-card:hover .icon-box {
            transform: scale(1.1);
            background: linear-gradient(135deg, var(--brand-teal), var(--brand-red));
            border-color: transparent;
        }

        .icon-box svg {
            width: 50px;
            height: 50px;
            fill: var(--brand-teal);
            transition: var(--transition);
        }

        .option-card:hover .icon-box svg {
            fill: #fff;
        }

        .option-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
            color: #1a1a1a;
        }

        .option-desc {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
            font-weight: 400;
            text-align: center;
        }

        .option-card:hover .option-desc {
            color: #333;
        }

        .card-accent {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--brand-teal), var(--brand-red));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .option-card:hover .card-accent {
            transform: scaleX(1);
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1200px) {
            .options-grid {
                gap: 20px;
                padding: 0 10px;
            }
            .option-card {
                padding: 40px 20px;
            }
        }

        @media (max-width: 992px) {
            .options-grid {
                grid-template-columns: repeat(2, 1fr);
                max-width: 800px;
                margin: 0 auto;
            }
            .logo-text { font-size: 2.8rem; }
        }

        @media (max-width: 768px) {
            .options-grid {
                grid-template-columns: 1fr;
                max-width: 450px;
            }
            .header {
                margin-bottom: 40px;
            }
            .logo-text { font-size: 2.2rem; }
            .tagline { font-size: 1.1rem; }
            .option-card {
                padding: 30px 20px;
            }
            .icon-box {
                width: 80px;
                height: 80px;
                margin-bottom: 20px;
            }
            .icon-box svg {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <div class="header">
            <h1 class="logo-text">Urge<span>Care</span></h1>
            <p class="tagline">Seamless Healthcare Connectivity at Your Fingertips</p>
        </div>

        <div class="options-grid">
            <!-- Admin Login -->
            <a href="{{ route('login') }}" class="option-card" style="animation-delay: 0.2s;">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.5 1.1 2.5 2.5S13.4 12 12 12s-2.5-1.1-2.5-2.5S10.6 7 12 7zm0 10c-2.33 0-4.31-1.46-5.11-3.5 1-.6 2.5-1 5.11-1s4.11.4 5.11 1c-.8 2.04-2.78 3.5-5.11 3.5z"/>
                    </svg>
                </div>
                <h3 class="option-title">Admin Login</h3>
                <p class="option-desc">Manage hospitals, partners, and overall system configuration with high-level access.</p>
                <div class="card-accent"></div>
            </a>

            <!-- Hospital Login -->
            <a href="{{ route('hospital.login') }}" class="option-card" style="animation-delay: 0.4s;">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-1.99.9-1.99 2L3 19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 11h-4v4h-4v-4H6v-4h4V6h4v4h4v4z"/>
                    </svg>
                </div>
                <h3 class="option-title">Hospital Login</h3>
                <p class="option-desc">Access your hospital portal to manage enquiries, update profile, and track patient interactions.</p>
                <div class="card-accent"></div>
            </a>

            <!-- Public Access -->
            <a href="{{ route('home') }}" class="option-card" style="animation-delay: 0.6s;">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </div>
                <h3 class="option-title">Continue as Guest</h3>
                <p class="option-desc">Browse various hospitals, search for locations nearby, and request emergency assistance immediately.</p>
                <div class="card-accent"></div>
            </a>
        </div>
    </div>
</body>
</html>
