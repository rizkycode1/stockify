
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Stockify</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #080d18;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .register-card {
            width: 100%;
            max-width: 470px;
            background: #111a2b;
            border: 1px solid #263650;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
        }

        .brand {
            color: #3b82f6;
            font-size: 30px;
            font-weight: 800;
        }

        .form-control {
            background: #0b1322;
            border: 1px solid #2a3b56;
            color: white;
            padding: 12px;
        }

        .form-control:focus {
            background: #0b1322;
            color: white;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,.15);
        }

        .form-control::placeholder {
            color: #8290a5;
        }

        .form-label {
            color: #cbd5e1;
            font-weight: 600;
        }

        .btn-register {
            background: #2563eb;
            color: white;
            padding: 13px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
        }

        .btn-register:hover {
            background: #1d4ed8;
            color: white;
        }

        .muted {
            color: #94a3b8;
        }
    </style>
</head>

<body>

<div class="register-card">

    <div class="text-center mb-4">
        <div class="brand">STOCKIFY</div>
        <h4 class="fw-bold mt-3">Buat Akun Baru</h4>
        <p class="muted">Mulai kelola inventaris perusahaanmu.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.process') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Perusahaan / Toko</label>
            <input type="text"
                   name="company_name"
                   class="form-control"
                   placeholder="Contoh: Toko Maju Jaya"
                   value="{{ old('company_name') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   placeholder="Masukkan nama kamu"
                   value="{{ old('name') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   placeholder="nama@email.com"
                   value="{{ old('email') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Minimal 8 karakter"
                   required>
        </div>

        <div class="mb-4">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Ulangi password"
                   required>
        </div>

        <button type="submit" class="btn btn-register w-100">
            Daftar Sekarang
        </button>
    </form>

    <div class="text-center mt-4 muted">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">
            Login
        </a>
    </div>

</div>

</body>
</html>
