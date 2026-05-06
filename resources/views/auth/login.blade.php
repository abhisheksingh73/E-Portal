<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Textile Ministry E-Portal</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1a2a6c;
            --accent: #fdbb2d;
            --text-light: #ffffff;
            --glass: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            height: 100vh;
            background: radial-gradient(circle at center, #1a2a6c 0%, #050505 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-light);
            overflow: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background: var(--glass);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header p {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
        }

        .form-group input:focus {
            border-color: var(--accent);
            background: rgba(255,255,255,0.08);
            box-shadow: 0 0 15px rgba(253, 187, 45, 0.1);
        }

        .btn {
            width: 100%;
            padding: 16px;
            background: var(--accent);
            border: none;
            border-radius: 12px;
            color: #1a1a1a;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(253, 187, 45, 0.3);
            filter: brightness(1.1);
        }

        .btn:active {
            transform: translateY(0);
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
        }

        .footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .error-msg {
            color: #ff4d4d;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }

        /* Decorative Background */
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: var(--accent);
            filter: blur(150px);
            opacity: 0.05;
            z-index: -1;
            border-radius: 50%;
        }

        .blob-1 { top: -10%; left: -10%; }
        .blob-2 { bottom: -10%; right: -10%; }

    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-container">
        <div class="header">
            <h2>Welcome Back</h2>
            <p>Access your Textile Portal account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" required autofocus>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn">Sign In</button>

            <div class="footer">
                <p>Don't have an account?<a href="{{ route('register') }}">Register now</a></p>
            </div>
        </form>
    </div>

</body>
</html>