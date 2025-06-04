<!DOCTYPE html> 
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Wedding Planner</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat&display=swap');

        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: linear-gradient(135deg, #f9e2e7, #fff7f9);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(255, 192, 203, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        h2 {
            font-family: 'Great Vibes', cursive;
            font-size: 3rem;
            margin-bottom: 10px;
            color: #d94f6b;
            text-shadow: 1px 1px 3px #f6c1c9;
        }

        p.subtitle {
            font-style: italic;
            color: #a35b6b;
            margin-bottom: 25px;
            font-size: 1rem;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .alert-success {
            background-color: #e6ffed;
            color: #2b6a28;
            border: 1px solid #5ad14b;
        }

        .alert-error {
            background-color: #ffe6e6;
            color: #b30000;
            border: 1px solid #ff4d4d;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1.8px solid #dcb0b3;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #d94f6b;
            box-shadow: 0 0 8px #d94f6b88;
        }

        button {
            background: linear-gradient(45deg, #d94f6b, #b84459);
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px #d94f6baa;
            transition: background 0.3s ease;
            margin-top: 12px;
        }

        button:hover {
            background: linear-gradient(45deg, #b84459, #9c3c4a);
        }

        a {
            display: block;
            margin-top: 18px;
            color: #d94f6b;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            text-decoration: underline;
            color: #b84459;
        }

        /* Decorative floral corner */
        .floral-corner {
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            background: url('https://i.ibb.co/mzD7gGt/floral-corner.png') no-repeat center/contain;
            opacity: 0.35;
            pointer-events: none;
        }

        /* Responsive */
        @media (max-width: 440px) {
            .login-container {
                padding: 25px 20px;
                max-width: 320px;
            }
            h2 {
                font-size: 2.4rem;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="floral-corner"></div>
    <h2>Wedding Planner</h2>
    <p class="subtitle">Silakan login untuk melanjutkan</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ url('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <a href="{{ route('register') }}">Belum punya akun? Daftar</a>
    </form>
</div>

</body>
</html>
