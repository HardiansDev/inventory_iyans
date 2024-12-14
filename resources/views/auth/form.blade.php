<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventory Iyan | Masuk & Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #6e8efb;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-primary {
            border-radius: 20px;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a78d6, #906bd2);
        }

        .switch-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .switch-link a {
            color: #6e8efb;
            text-decoration: none;
            font-weight: bold;
        }

        .switch-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="form-container" id="form-login">
        <!-- Login Form -->
        <h3 class="form-title">Masuk</h3>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email"
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Kata sandi</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Masukkan Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
        <p class="switch-link">
            Belum punya akun? <a href="#" id="to-register">Daftar Yuk</a>
        </p>
    </div>

    <div class="form-container d-none" id="form-register">
        <!-- Register Form -->
        <h3 class="form-title">Daftar</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name"
                    placeholder="Masukkan Nama Lengkap" required>
            </div>
            <div class="mb-3">
                <label for="email-register" class="form-label">Email</label>
                <input type="email" class="form-control" id="email-register" name="email"
                    placeholder="Masukkan Email" required>
            </div>
            <div class="mb-3">
                <label for="role-register" class="form-label">Peran</label>
                <select class="form-select" id="role-register" name="role" required>
                    <option value="" selected disabled>Pilih Peran</option>
                    <option value="superadmin">Super Admin</option>
                    <option value="admin_gudang">Admin Gudang</option>
                    <option value="kasir">Kasir</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password-register" class="form-label">Kata sandi</label>
                <input type="password" class="form-control" id="password-register" name="password"
                    placeholder="Masukkan Password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata sandi</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Masukkan Konfirmasi Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Silahkan Daftar</button>
        </form>
        <p class="switch-link">
            Sudah punya akun? <a href="#" id="to-login">Masuk yuk</a>
        </p>
    </div>

    <script>
        // Script to toggle between Login and Register forms
        const loginForm = document.getElementById("form-login");
        const registerForm = document.getElementById("form-register");

        document.getElementById("to-register").addEventListener("click", (e) => {
            e.preventDefault();
            loginForm.classList.add("d-none");
            registerForm.classList.remove("d-none");
        });

        document.getElementById("to-login").addEventListener("click", (e) => {
            e.preventDefault();
            registerForm.classList.add("d-none");
            loginForm.classList.remove("d-none");
        });
    </script>
</body>

</html>
