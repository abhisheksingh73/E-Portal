<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Textile Ministry E-Portal | Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1a2a6c;
            --secondary: #b21f1f;
            --accent: #fdbb2d;
            --text-light: #ffffff;
            --text-dark: #1a1a1a;
            --glass: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #050505;
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url('/images/hero.png');
            background-size: cover;
            background-position: center;
            z-index: -1;
            transform: scale(1.1);
            animation: slowZoom 20s infinite alternate ease-in-out;
        }

        @keyframes slowZoom {
            from { transform: scale(1); }
            to { transform: scale(1.15); }
        }

        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background: transparent;
            backdrop-filter: blur(0px);
            transition: all 0.3s ease;
        }

        nav.scrolled {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 1rem 4rem;
            border-bottom: 1px solid var(--glass-border);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(45deg, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-light);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .btn-login {
            background: var(--accent);
            color: var(--text-dark) !important;
            padding: 0.6rem 1.8rem;
            border-radius: 50px;
            font-weight: 600 !important;
            transition: transform 0.3s, box-shadow 0.3s !important;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(253, 187, 45, 0.3);
        }

        /* Content */
        .hero-content {
            text-align: center;
            max-width: 900px;
            padding: 2rem;
            z-index: 1;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 8vw, 5.5rem);
            line-height: 1.1;
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards 0.5s;
        }

        p.subtitle {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: rgba(255,255,255,0.8);
            margin-bottom: 2.5rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards 0.8s;
        }

        .cta-group {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards 1.1s;
        }

        .btn-primary {
            padding: 1rem 2.5rem;
            background: var(--accent);
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 5px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            border: 2px solid var(--accent);
        }

        .btn-primary:hover {
            background: transparent;
            color: var(--accent);
        }

        .btn-secondary {
            padding: 1rem 2.5rem;
            background: transparent;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 5px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: var(--text-dark);
        }

        /* Role Cards Section */
        .roles-section {
            padding: 100px 4rem;
            background: #0a0a0a;
            position: relative;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .role-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(253, 187, 45, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .role-card:hover::before {
            transform: translateX(100%);
        }

        .role-card:hover {
            transform: translateY(-15px);
            background: rgba(255, 255, 255, 0.07);
            border-color: var(--accent);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .role-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: var(--accent);
        }

        .role-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-family: 'Playfair Display', serif;
        }

        .role-card p {
            color: rgba(255,255,255,0.6);
            line-height: 1.6;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating Animation */
        .float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Decorative Elements */
        .decoration {
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--accent);
            filter: blur(150px);
            opacity: 0.1;
            z-index: 0;
            border-radius: 50%;
        }

        .dec-1 { top: 10%; left: -5%; }
        .dec-2 { bottom: 10%; right: -5%; }

        @media (max-width: 768px) {
            nav { padding: 1.5rem 2rem; }
            .nav-links { display: none; }
            .roles-section { padding: 60px 2rem; }
        }
    </style>
</head>
<body>

    <nav id="navbar">
        <div class="logo">Textile E-Portal</div>
        <div class="nav-links">
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="#contact">Contact</a>
            @if (Route::has('login'))
                @guest
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @else
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ef4444; font-weight: 600; text-decoration: none;">Logout</a>
                    </form>
                @endguest
            @endif
        </div>
    </nav>

    <section class="hero">
        <div class="hero-bg"></div>
        <div class="decoration dec-1"></div>
        <div class="hero-content">
            <h1>Weaving the Future of <span style="color: var(--accent);">Textiles</span></h1>
            <p class="subtitle">A unified platform for Administrators, Sellers, and Buyers to empower the textile industry with modern digital solutions.</p>
            <div class="cta-group">
                @auth
                    @php
                        $dashboardRoute = auth()->user()->role . '.dashboard';
                    @endphp
                    <a href="{{ route($dashboardRoute) }}" class="btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">Join the Portal</a>
                @endauth
                <a href="#roles" class="btn-secondary">Explore Roles</a>
            </div>
        </div>
        <div class="decoration dec-2"></div>
    </section>

    <section class="roles-section" id="roles">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 1rem;">Platform Ecosystem</h2>
            <p style="color: rgba(255,255,255,0.6); max-width: 600px; margin: 0 auto;">Connecting every stakeholder in the Indian textile value chain through a specialized digital portal.</p>
        </div>
        <div class="roles-grid">
            <div class="role-card">
                <div class="role-icon float">🛡️</div>
                <h3>Administrator</h3>
                <p>Manage the entire ecosystem, oversee transactions, and ensure platform integrity with powerful administrative tools.</p>
            </div>
            <div class="role-card">
                <div class="role-icon float" style="animation-delay: 1s;">🏬</div>
                <h3>Seller</h3>
                <p>Showcase your finest fabrics, reach a global audience, and manage your inventory with ease and efficiency.</p>
            </div>
            <div class="role-card">
                <div class="role-icon float" style="animation-delay: 2s;">🛒</div>
                <h3>Buyer</h3>
                <p>Discover high-quality textiles, connect directly with sellers, and enjoy a seamless purchasing experience.</p>
            </div>
        </div>
    </section>

    <!-- Featured Textiles Section -->
    @if($featuredProducts->count() > 0)
    <section style="padding: 100px 4rem; background: #050505;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
            <div>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--accent);">Featured Masterpieces</h2>
                <p style="color: rgba(255,255,255,0.6); margin-top: 10px;">Handpicked treasures from our finest regional artisans.</p>
            </div>
            <a href="{{ route('buyer.marketplace') }}" style="color: white; text-decoration: none; font-weight: 600; border-bottom: 2px solid var(--accent); padding-bottom: 5px;">View Marketplace</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
            @foreach($featuredProducts as $product)
            <div class="role-card" style="padding: 0; text-align: left; overflow: hidden;">
                <div style="height: 300px; background: #1a1a1a; overflow: hidden; position: relative;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #333;">
                            <i class="fas fa-image" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <div style="position: absolute; top: 15px; left: 15px; background: var(--accent); color: var(--text-dark); padding: 5px 12px; border-radius: 5px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase;">Featured</div>
                </div>
                <div style="padding: 25px;">
                    <span style="color: var(--accent); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">{{ $product->category }}</span>
                    <h4 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; margin: 8px 0;">{{ $product->name }}</h4>
                    <p style="font-size: 0.9rem; color: rgba(255,255,255,0.5); margin-bottom: 20px;">{{ Str::limit($product->description, 60) }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 1.2rem; font-weight: 700;">₹{{ number_format($product->price) }}</span>
                        <a href="{{ route('buyer.marketplace') }}" style="background: rgba(255,255,255,0.1); color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Ministry Highlights (Articles) -->
    @if($latestArticles->count() > 0)
    <section style="padding: 100px 4rem; background: #0a0a0a;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem;">Ministry Chronicles</h2>
            <p style="color: rgba(255,255,255,0.6); margin-top: 10px;">Stories of heritage, innovation, and artisan empowerment.</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; max-width: 1400px; margin: 0 auto;">
            @foreach($latestArticles as $article)
            <div style="display: flex; flex-direction: column; gap: 20px; group">
                <div style="height: 250px; border-radius: 20px; overflow: hidden; position: relative;">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: #1a1a1a; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-newspaper" style="font-size: 3rem; color: #333;"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <span style="color: var(--accent); font-weight: 700; font-size: 0.8rem; text-transform: uppercase;">{{ $article->category }}</span>
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; margin: 10px 0; line-height: 1.3;">{{ $article->title }}</h3>
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.95rem; line-height: 1.6;">{{ Str::limit($article->content, 120) }}</p>
                    <a href="{{ route('buyer.articles') }}" style="display: inline-block; margin-top: 15px; color: white; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Read Full Story <i class="fas fa-arrow-right" style="margin-left: 8px; font-size: 0.8rem;"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Government Schemes Brief -->
    <section style="padding: 100px 4rem; text-align: center; background: linear-gradient(to bottom, #0a0a0a, #050505);">
        <div style="max-width: 800px; margin: 0 auto; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 60px; border-radius: 30px;">
            <i class="fas fa-file-invoice" style="font-size: 3rem; color: var(--accent); margin-bottom: 25px;"></i>
            <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 20px;">Government Support & Schemes</h2>
            <p style="color: rgba(255,255,255,0.7); line-height: 1.8; margin-bottom: 30px;">The Ministry of Textiles offers various schemes to support weavers, artisans, and MSMEs. From financial assistance to technology upgrades, explore how the government is empowering the industry.</p>
            <a href="{{ route('buyer.schemes') }}" class="btn-primary">Explore All Schemes</a>
        </div>
    </section>

    <script>
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Intersection Observer for animations on scroll
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.role-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            card.style.transition = 'all 0.8s ease-out';
            observer.observe(card);
        });
    </script>
</body>
</html>
