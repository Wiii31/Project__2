<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Wedding Planner</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat&display=swap');

        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: linear-gradient(135deg, #f9e2e7, #fff7f9);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(255, 192, 203, 0.3);
            width: 100%;
            max-width: 500px;
            position: relative;
        }

        h2 {
            font-family: 'Great Vibes', cursive;
            font-size: 3rem;
            margin-bottom: 10px;
            color: #d94f6b;
            text-align: center;
            text-shadow: 1px 1px 3px #f6c1c9;
        }

        p.subtitle {
            font-style: italic;
            color: #a35b6b;
            margin-bottom: 25px;
            font-size: 1rem;
            text-align: center;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            background-color: #ffe6e6;
            color: #b30000;
            border: 1px solid #ff4d4d;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0;
            border-radius: 10px;
            border: 1.8px solid #dcb0b3;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus,
        select:focus {
            border-color: #d94f6b;
            box-shadow: 0 0 8px #d94f6b88;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        select {
            cursor: pointer;
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
            margin-top: 15px;
        }

        button:hover {
            background: linear-gradient(45deg, #b84459, #9c3c4a);
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
        @media (max-width: 520px) {
            .register-container {
                padding: 25px 20px;
                max-width: 350px;
            }
            h2 {
                font-size: 2.4rem;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="floral-corner"></div>
    <h2>Wedding Planner</h2>
    <p class="subtitle">Isi data untuk membuat akun baru</p>

    @if($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ url('register') }}">
        @csrf
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="no_hp" placeholder="No HP" required>
        <textarea name="alamat" placeholder="Alamat" required></textarea>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>

        <select name="role" required>
            <option value="">-- Pilih Peran --</option>
            <option value="admin">Admin</option>
            <option value="vendor">Vendor</option>
            <option value="klien">Klien</option>
        </select>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
