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
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-login" style="background: var(--primary); color: white !important;">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ef4444; font-weight: 600; text-decoration: none; margin-left: 15px;">Logout</a>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
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

    <!-- About Section -->
    <section id="about" style="padding: 100px 4rem; background: #050505; position: relative;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 4rem; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 2rem; color: var(--accent);">Our Mission</h2>
                <p style="font-size: 1.1rem; line-height: 1.8; color: rgba(255,255,255,0.8); margin-bottom: 1.5rem;">
                    The Textile Ministry E-Portal is a dedicated initiative to digitalize India's rich textile heritage. We empower local weavers and artisans by providing them with a global stage to showcase their craftsmanship.
                </p>
                <p style="font-size: 1.1rem; line-height: 1.8; color: rgba(255,255,255,0.8);">
                    By bridging the gap between traditional techniques and modern commerce, we ensure that the heart of our culture continues to beat in the digital age.
                </p>
            </div>
            <div style="flex: 1; min-width: 300px; position: relative;">
                <div style="width: 100%; height: 400px; background: linear-gradient(45deg, #1a2a6c, #b21f1f); border-radius: 30px; position: relative; z-index: 1; overflow: hidden;">
                    <img src="{{ asset('images/about_textile_craft.png') }}" alt="Textile Craft" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.7;">
                </div>
                <div style="position: absolute; top: -20px; left: -20px; width: 100%; height: 100%; border: 2px solid var(--accent); border-radius: 30px; z-index: 0;"></div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" style="padding: 100px 4rem; background: #0a0a0a;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 1rem;">Our Digital Services</h2>
            <p style="color: rgba(255,255,255,0.6);">A comprehensive suite of tools designed for the textile industry.</p>
        </div>
        <div class="roles-grid">
            <div class="role-card" style="text-align: left; padding: 2.5rem;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🌐</div>
                <h4 style="margin-bottom: 1rem; color: var(--accent);">Global Marketplace</h4>
                <p style="font-size: 0.9rem;">A secure platform for sellers to list products and for buyers to discover authentic textiles from every corner of India.</p>
            </div>
            <div class="role-card" style="text-align: left; padding: 2.5rem;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">📜</div>
                <h4 style="margin-bottom: 1rem; color: var(--accent);">Scheme Awareness</h4>
                <p style="font-size: 0.9rem;">Real-time updates on government schemes, subsidies, and benefits tailored specifically for artisans and textile businesses.</p>
            </div>
            <div class="role-card" style="text-align: left; padding: 2.5rem;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">⚡</div>
                <h4 style="margin-bottom: 1rem; color: var(--accent);">Direct Connectivity</h4>
                <p style="font-size: 0.9rem;">Eliminate middlemen. Our inquiry and order system allows direct communication between the creator and the consumer.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" style="padding: 100px 4rem; background: #050505;">
        <div class="role-card" style="max-width: 900px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 3rem; text-align: left; background: rgba(255,255,255,0.02); padding: 4rem;">
            <div style="flex: 1; min-width: 250px;">
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 1.5rem; color: var(--accent);">Get In Touch</h2>
                <p style="color: rgba(255,255,255,0.6); margin-bottom: 2rem;">Have questions about the portal? Our team is here to help you every step of the way.</p>
                
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span style="color: var(--accent); font-size: 1.2rem;">📍</span>
                        <span>Ministry of Textiles, Udyog Bhawan, New Delhi</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span style="color: var(--accent); font-size: 1.2rem;">📧</span>
                        <span>support@textile-portal.gov.in</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span style="color: var(--accent); font-size: 1.2rem;">📞</span>
                        <span>+91 11 2306 1234</span>
                    </div>
                </div>
            </div>
            <div style="flex: 1.5; min-width: 250px;">
                <form action="#" style="display: flex; flex-direction: column; gap: 1rem;">
                    <input type="text" placeholder="Your Name" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 10px; color: white; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    <input type="email" placeholder="Your Email" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 10px; color: white; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    <textarea placeholder="Message" rows="4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 1rem; border-radius: 10px; color: white; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'"></textarea>
                    <button type="button" class="btn-primary" style="border: none; cursor: pointer;">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <footer style="padding: 40px; text-align: center; background: #000; border-top: 1px solid rgba(255,255,255,0.05);">
        <p style="color: rgba(255,255,255,0.4); font-size: 0.9rem;">&copy; 2026 Textile Ministry E-Portal. All Rights Reserved.</p>
    </footer>

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

        document.querySelectorAll('.role-card, #about div, #services h2, #contact h2').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1)';
            observer.observe(el);
        });
    </script>
</body>
</html>
