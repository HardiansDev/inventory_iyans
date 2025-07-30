<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sistem POS & Inventory</title>

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Google Font -->
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
            rel="stylesheet"
        />

        <!-- Lottie -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>

    <body class="flex min-h-screen flex-col justify-between bg-black text-white">
        <!-- Navbar -->
        <header
            class="absolute top-0 right-0 left-0 z-50 flex items-center justify-between px-10 py-6"
        >
            <div class="text-xl font-bold tracking-tight">HDTECH</div>
            <a
                href="/login"
                class="rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-5 py-2 text-sm font-semibold text-white shadow transition-all duration-300 hover:from-purple-600 hover:to-cyan-400"
            >
                Mari Bermitra
            </a>
        </header>

        <!-- Main Section -->
        <div
            class="flex flex-col-reverse items-center justify-between gap-10 px-10 pt-32 pb-10 lg:flex-row"
        >
            <!-- Text Content -->
            <main class="w-full lg:w-1/2">
                <h1 class="mb-4 text-4xl leading-tight font-bold lg:text-5xl">
                    Point of Sales & Inventory Management System
                </h1>
                <p class="mb-6 text-lg text-gray-300">
                    Kelola penjualan dan inventaris bisnis Anda dengan mudah melalui sistem yang
                    terintegrasi dan efisien.
                </p>
                <a
                    href="/login"
                    class="rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-6 py-3 text-lg font-semibold shadow transition-all duration-300 hover:from-purple-600 hover:to-cyan-400"
                >
                    Mulai Kelola Bisnis Anda
                </a>
            </main>

            <!-- Animation -->
            <div class="h-[300px] w-full sm:h-[400px] lg:h-[500px] lg:w-1/2">
                <div id="lottie-animation" class="h-full w-full"></div>
            </div>
        </div>

        <!-- Lottie Script -->
        <script>
            lottie.loadAnimation({
                container: document.getElementById('lottie-animation'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '/anm.json', // Ganti dengan file animasi kamu
            })
        </script>
    </body>
</html>
