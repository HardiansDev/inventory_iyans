<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>KASIRIN.ID - Verif Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #9face6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .verify-box {
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .verify-box h3 {
            color: #4e73df;
            margin-bottom: 15px;
        }

        .verify-box p {
            font-size: 1rem;
            color: #555;
        }

        .btn-custom {
            background: linear-gradient(135deg, #4e73df, #6a89cc);
            color: #fff;
            border: none;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #3e5fbf, #5a7bbc);
        }
    </style>
</head>

<body>
    <div class="verify-box">
        <h3>Verifikasi Email Anda</h3>
        <p>Silakan cek email Anda dan klik link verifikasi untuk melanjutkan.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-custom btn-lg w-100">
                Kirim Ulang Email Verifikasi
            </button>
        </form>
    </div>
</body>

</html>
