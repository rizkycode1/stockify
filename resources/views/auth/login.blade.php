
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | STOCKIFY Enterprise</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #080d18;
            color: #edf3ff;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            overflow-x: hidden;
        }

        .background-glow {
            position: fixed;
            width: 450px;
            height: 450px;
            background: #176bdb;
            filter: blur(180px);
            opacity: .17;
            top: -180px;
            right: -100px;
            pointer-events: none;
        }

        .background-glow.second {
            background: #1747a5;
            top: auto;
            right: auto;
            bottom: -220px;
            left: -100px;
        }

        .login-container {
            width: 100%;
            max-width: 1000px;
            min-height: 590px;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            background: #0e182a;
            border: 1px solid #263750;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 30px 100px #0008;
            position: relative;
            z-index: 1;
        }

        /* LEFT PANEL */
        .login-brand {
            padding: 48px;
            background: linear-gradient(145deg, #102d59, #0d1d36 65%, #101b2e);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-content {
            position: relative;
            z-index: 2;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 65px;
        }

        .brand-logo-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #4b94ff, #1760d0);
            border-radius: 12px;
            color: white;
            font-size: 20px;
            box-shadow: 0 8px 25px #3984ff50;
        }

        .brand-logo strong {
            font-size: 20px;
            font-weight: 900;
            letter-spacing: 2px;
        }

        .brand-logo small {
            display: block;
            color: #9dbce7;
            font-size: 8px;
            letter-spacing: 2px;
            margin-top: 3px;
        }

        .brand-label {
            color: #80b5ff;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 17px;
        }

        .brand-content h1 {
            font-size: 35px;
            line-height: 1.3;
            font-weight: 900;
            margin-bottom: 17px;
        }

        .brand-content h1 span {
            color: #72aaff;
        }

        .brand-content p {
            color: #b0c4df;
            font-size: 12px;
            line-height: 1.9;
            max-width: 360px;
        }

        .brand-illustration {
            height: 115px;
            display: flex;
            align-items: center;
            gap: 13px;
            position: relative;
            z-index: 2;
        }

        .illustration-box {
            width: 75px;
            height: 75px;
            border: 1px solid #ffffff28;
            background: #ffffff0b;
            border-radius: 15px;
            display: grid;
            place-items: center;
            color: #82b7ff;
            font-size: 28px;
        }

        .illustration-box:nth-child(2) {
            transform: translateY(-20px);
            background: #3984ff20;
        }

        .illustration-box:nth-child(3) {
            transform: translateY(10px);
        }

        .brand-footer {
            position: relative;
            z-index: 2;
            color: #8ca8cb;
            font-size: 9px;
            letter-spacing: .7px;
        }

        .brand-circle {
            position: absolute;
            width: 330px;
            height: 330px;
            border: 1px solid #ffffff0c;
            border-radius: 50%;
            right: -180px;
            bottom: -110px;
        }

        .brand-circle.two {
            width: 230px;
            height: 230px;
            right: -130px;
            bottom: -60px;
        }

        /* RIGHT PANEL */
        .login-form-panel {
            padding: 55px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-heading {
            margin-bottom: 32px;
        }

        .form-heading .welcome {
            color: #65a3ff;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.8px;
        }

        .form-heading h2 {
            font-size: 27px;
            font-weight: 900;
            margin: 12px 0 8px;
        }

        .form-heading p {
            color: #8b9bb5;
            font-size: 11px;
        }

        .form-label {
            color: #cbd8ec;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 22px;
        }

        .input-group-custom > i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7188a8;
            z-index: 2;
            font-size: 13px;
        }

        .form-control {
            height: 49px;
            background: #091323;
            border: 1px solid #293b57;
            border-radius: 9px !important;
            color: white;
            font-size: 12px;
            padding-left: 42px;
            padding-right: 42px;
        }

        .form-control:focus {
            background: #091323;
            color: white;
            border-color: #3984ff;
            box-shadow: 0 0 0 3px #3984ff20;
        }

        .form-control::placeholder {
            color: #64758f;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #7188a8;
            z-index: 3;
            cursor: pointer;
        }

        .login-button {
            width: 100%;
            height: 49px;
            border: none;
            border-radius: 9px;
            background: linear-gradient(100deg, #2874ed, #398eff);
            color: white;
            font-size: 12px;
            font-weight: 800;
            transition: .2s;
            box-shadow: 0 8px 25px #3984ff30;
            margin-top: 5px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px #3984ff45;
        }

        .login-button i {
            margin-left: 8px;
        }

        .security-note {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #22c58b0d;
            border: 1px solid #22c58b25;
            border-radius: 9px;
            padding: 13px;
            margin-top: 25px;
        }

        .security-note i {
            color: #35d6a0;
            font-size: 17px;
        }

        .security-note strong {
            display: block;
            font-size: 10px;
        }

        .security-note small {
            display: block;
            color: #8b9bb5;
            font-size: 9px;
            margin-top: 3px;
        }

        .login-bottom {
            text-align: center;
            color: #64758f;
            font-size: 9px;
            margin-top: 30px;
        }

        .alert {
            font-size: 11px;
            border-radius: 9px;
        }

        @media(max-width: 750px) {
            .login-container {
                max-width: 470px;
                grid-template-columns: 1fr;
            }

            .login-brand {
                padding: 28px;
                min-height: 250px;
            }

            .brand-logo {
                margin-bottom: 30px;
            }

            .brand-content h1 {
                font-size: 25px;
            }

            .brand-illustration {
                display: none;
            }

            .brand-footer {
                margin-top: 25px;
            }

            .login-form-panel {
                padding: 35px 28px;
            }
        }

        @media(max-width: 400px) {
            body { padding: 12px; }
            .login-form-panel { padding: 30px 20px; }
            .login-brand { padding: 25px 20px; }
        }
    </style>
</head>

<body>

<div class="background-glow"></div>
<div class="background-glow second"></div>

<div class="login-container">

    {{-- BRAND PANEL --}}
    <div class="login-brand">

        <div class="brand-content">

            <div class="brand-logo">
                <div class="brand-logo-icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <div>
                    <strong>STOCKIFY</strong>
                    <small>ENTERPRISE INVENTORY SYSTEM</small>
                </div>
            </div>

            <div class="brand-label">
                INVENTORY MANAGEMENT PLATFORM
            </div>

            <h1>
                Smarter Inventory.<br>
                <span>Better Decisions.</span>
            </h1>

            <p>
                Kelola seluruh inventaris perusahaan dalam satu platform
                terintegrasi. Pantau stok, transaksi, supplier, dan laporan
                dengan lebih mudah.
            </p>

            <div class="brand-illustration">
                <div class="illustration-box">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div class="illustration-box">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="illustration-box">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>

        </div>

        <div class="brand-footer">
            <i class="fas fa-shield-halved"></i>
            STOCKIFY BUSINESS MANAGEMENT SOLUTION
        </div>

        <div class="brand-circle"></div>
        <div class="brand-circle two"></div>

    </div>

    {{-- LOGIN FORM --}}
    <div class="login-form-panel">

        <div class="form-heading">
            <span class="welcome">WELCOME BACK</span>
            <h2>Sign In</h2>
            <p>Masuk untuk mengakses dashboard inventaris Anda.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <label class="form-label">Email Address</label>
            <div class="input-group-custom">
                <i class="fas fa-envelope"></i>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="nama@email.com"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                    autofocus
                >
            </div>

            <label class="form-label">Password</label>
            <div class="input-group-custom">
                <i class="fas fa-lock"></i>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    onclick="togglePassword()"
                    aria-label="Tampilkan password"
                >
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            <button type="submit" class="login-button">
                Sign In to Dashboard
                <i class="fas fa-arrow-right"></i>
            </button>

        </form>

        <div class="security-note">
            <i class="fas fa-shield-halved"></i>
            <div>
                <strong>Secure Authentication</strong>
                <small>Akses sistem dilindungi autentikasi pengguna.</small>
            </div>
        </div>

        <div class="login-bottom">
            © {{ date('Y') }} STOCKIFY · INVENTORY MANAGEMENT SYSTEM
        </div>

    </div>

</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

</body>
</html>
