<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem POS & Inventory</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Lottie Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #000;
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 20px 10%;
            overflow: hidden;
        }

        /* Header Navbar */
        header {
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -1px;
        }

        .btn {
            background: linear-gradient(90deg, #00bfff, #6a11cb);
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn:hover {
            background: #6a11cb;
        }

        /* Main Content */
        main {
            width: 50%;
            text-align: left;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        p {
            font-size: 1.2rem;
            font-weight: 400;
            margin-bottom: 30px;
        }

        .btn-cta {
            background: linear-gradient(90deg, #00bfff, #6a11cb);
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s;
        }

        .btn-cta:hover {
            transform: translateY(-5px);
            box-shadow: 0px 5px 20px rgba(0, 191, 255, 0.5);
        }

        /* Animation Container */
        .animation-container {
            width: 45%;
            height: 70%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #lottie-animation {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <!-- Header Navbar -->
    <header>
        <div class="logo">HDTECH</div>
        <a href="/login" class="btn">Mari Bermitra </a>
    </header>

    <!-- Main Content -->
    <main>
        <h1>Point of Sales & Inventory Management Systems</h1>
        <p>Manage your sales and inventory effortlessly with our integrated system.</p>
        <br>
        <a href="/login" class="btn-cta">Mulai Kelola Bisnis Anda</a>
    </main>

    <!-- Animation Section -->
    <div class="animation-container">
        <div id="lottie-animation" style="width: 1000px; height: 1000px;"></div>
    </div>

    <!-- Lottie Animation Script -->
    <script>
        // Load Lottie Animation
        lottie.loadAnimation({
            container: document.getElementById('lottie-animation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '/anm.json' // Replace with your Lottie JSON URL
        });
    </script>
</body>

</html>
