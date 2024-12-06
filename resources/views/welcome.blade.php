<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Inventory</title>
    <style>
        /* Global styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            text-align: center;
            padding: 100px 20px;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            overflow: hidden;
        }

        h1 {
            font-size: 4em;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            font-weight: bold;
            animation: fadeIn 2s ease-in-out;
        }

        h2 {
            font-size: 2.2em;
            margin-top: 20px;
            animation: fadeIn 2s ease-in-out 0.5s;
        }

        p {
            font-size: 1.2em;
            margin-top: 10px;
            animation: fadeIn 2s ease-in-out 1s;
        }

        /* Button styles */
        .btn {
            background-color: #2575fc;
            color: white;
            padding: 15px 35px;
            border: none;
            border-radius: 30px;
            font-size: 1.5em;
            cursor: pointer;
            margin-top: 40px;
            transition: transform 0.3s, background-color 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background-color: #6a11cb;
            transform: scale(1.05);
        }

        .btn:focus {
            outline: none;
        }

        /* Audio player styles */
        .audio-player {
            margin-top: 50px;
        }

        audio {
            width: 100%;
            max-width: 600px;
            background-color: transparent;
            border-radius: 10px;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Box Shadow effect for content */
        .content {
            padding: 40px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            animation: fadeIn 2s ease-in-out 1.5s;
        }

        /* Styling for a subtle gradient background */
        .gradient-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7));
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="gradient-background"></div>
    <div class="content">
        <h1>Sistem Manajemen Inventory Sederhana powered by hardiansdev - HDTECH</h1>
        <h2>Selamat datang! Nikmati pengalaman menggunakan sistem kami</h2>
        <p>Putar lagu favorit Anda sambil menjelajahi aplikasi.</p>

        <!-- Audio player -->
        <div class="audio-player">
            <audio controls>
                <source src="https://example.com/path/to/lagu-tulus.mp3" type="audio/mp3">
                Your browser does not support the audio element.
            </audio>
        </div>

        <!-- Button for login -->
        <button class="btn" onclick="window.location.href='/login'">Silahkan Masuk</button>
    </div>
</body>

</html>
