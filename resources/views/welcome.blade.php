<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HDTECH - POS & Inventory</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a2e0f1f6b1.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- icon -->
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            color: white;
        }

        .gradient-text {
            background: linear-gradient(90deg, #06b6d4, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <header class="fixed w-full bg-[#0f172a]/80 backdrop-blur z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

            <!-- Logo -->
            <div class="text-2xl font-bold gradient-text">HDTECH</div>

            <!-- Desktop Menu -->
            <nav id="navbar"
                class="hidden md:flex space-x-8 text-sm font-semibold absolute left-1/2 -translate-x-1/2">
                <a href="#home" class="nav-link hover:text-cyan-400 transition-colors">Home</a>
                <a href="#about" class="nav-link hover:text-cyan-400 transition-colors">Tentang Kami</a>
                <a href="#mitra" class="nav-link hover:text-cyan-400 transition-colors">Mitra</a>
                <a href="#testimoni" class="nav-link hover:text-cyan-400 transition-colors">Testimoni</a>
                <a href="#kontak" class="nav-link hover:text-cyan-400 transition-colors">Kontak</a>
            </nav>

            <!-- Tombol Demo di kanan (Desktop) -->
            <a href="/login"
                class="hidden md:inline-block rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-5 py-2 text-sm font-semibold text-white shadow transition-all duration-300 hover:from-purple-600 hover:to-cyan-400">
                Demo
            </a>

            <!-- Hamburger Button (Mobile) -->
            <button id="menu-btn" class="md:hidden text-white focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#0f172a] border-t border-gray-700">
            <nav class="flex flex-col p-4 space-y-4 text-sm font-semibold">
                <a href="#home" class="hover:text-cyan-400 transition-colors">Home</a>
                <a href="#about" class="hover:text-cyan-400 transition-colors">Tentang Kami</a>
                <a href="#mitra" class="hover:text-cyan-400 transition-colors">Mitra</a>
                <a href="#testimoni" class="hover:text-cyan-400 transition-colors">Testimoni</a>
                <a href="#kontak" class="hover:text-cyan-400 transition-colors">Kontak</a>
                <a href="/login"
                    class="rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 px-5 py-2 text-center text-sm font-semibold text-white shadow transition-all duration-300 hover:from-purple-600 hover:to-cyan-400">
                    Demo
                </a>
            </nav>
        </div>
    </header>


    <!-- Hero -->
    <section id="home"
        class="min-h-screen flex items-center justify-center text-center px-6 pt-20 bg-cover bg-center relative"
        style="background-image: url('https://images.unsplash.com/photo-1749738513460-e069e49ffdb6?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">

        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#0f172a]/80 to-[#1e293b]/80"></div>

        <!-- Content -->
        <div class="relative z-10" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 gradient-text">
                Point of Sales & Inventory Management
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto mb-8">
                Solusi digital untuk mengelola penjualan & stok bisnis Anda dengan mudah, cepat, dan efisien.
            </p>
            <a href="/login"
                class="bg-gradient-to-r from-cyan-400 to-purple-600 px-6 py-3 rounded-full font-semibold shadow-lg hover:from-purple-600 hover:to-cyan-400 transition">
                Mulai Kelola Bisnis
            </a>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section id="about" class="py-20 max-w-7xl mx-auto px-6">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-4 gradient-text">Tentang Kami</h2>
            <p class="text-gray-300 max-w-2xl mx-auto">
                HDTECH adalah perusahaan teknologi yang fokus mengembangkan sistem POS & Inventory modern, membantu UMKM
                hingga perusahaan besar dalam mengoptimalkan operasional mereka.
            </p>
        </div>

        <!-- Keunggulan -->
        <div class="grid md:grid-cols-3 gap-8">
            <!-- POS Modern -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg" data-aos="fade-up">
                <i class="fas fa-cash-register text-4xl text-cyan-400 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">POS Modern</h3>
                <p class="text-gray-400">Sistem kasir terintegrasi yang memudahkan proses transaksi dan pelaporan.</p>
            </div>

            <!-- Inventory Real-Time -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-boxes text-4xl text-purple-400 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Inventory Real-Time</h3>
                <p class="text-gray-400">Pantau stok barang secara akurat kapan saja dan di mana saja.</p>
            </div>

            <!-- Analisis Penjualan -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-chart-line text-4xl text-green-400 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Analisis Penjualan</h3>
                <p class="text-gray-400">Laporan dan analitik yang membantu mengambil keputusan bisnis yang tepat.</p>
            </div>

            <!-- Multi Device Support -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-laptop-code text-4xl text-yellow-400 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Multi Device Support</h3>
                <p class="text-gray-400">Akses sistem dari PC, tablet, atau smartphone tanpa batasan lokasi.</p>
            </div>

            <!-- Keamanan Data -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="400">
                <i class="fas fa-shield-alt text-4xl text-red-400 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Keamanan Data</h3>
                <p class="text-gray-400">Sistem dilengkapi enkripsi dan backup otomatis untuk melindungi data bisnis
                    Anda.</p>
            </div>

            <!-- Integrasi Mudah -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="500">
                <i class="fas fa-plug text-4xl text-blue-400 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Integrasi Mudah</h3>
                <p class="text-gray-400">Terhubung dengan berbagai sistem pembayaran dan aplikasi pihak ketiga.</p>
            </div>
        </div>
    </section>


    <!-- Mitra (Logo Slider) -->
    <section id="mitra" class="py-20 bg-gray-900">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-4 gradient-text">Mitra Kami</h2>
            <p class="text-gray-300">Dipercaya oleh berbagai brand & perusahaan ternama.</p>
        </div>
        <div class="swiper mySwiper" data-aos="fade-up">
            <div class="swiper-wrapper items-center">
                <div class="swiper-slide flex justify-center">
                    <img src="https://dummyimage.com/150x80/8b5cf6/ffffff&text=Mitra+1"
                        class="opacity-80 hover:opacity-100 transition">
                </div>
                <div class="swiper-slide flex justify-center">
                    <img src="https://dummyimage.com/150x80/f59e0b/ffffff&text=Mitra+2"
                        class="opacity-80 hover:opacity-100 transition">
                </div>
                <div class="swiper-slide flex justify-center">
                    <img src="https://dummyimage.com/150x80/10b981/ffffff&text=Mitra+3"
                        class="opacity-80 hover:opacity-100 transition">
                </div>
                <div class="swiper-slide flex justify-center">
                    <img src="https://dummyimage.com/150x80/ef4444/ffffff&text=Mitra+4"
                        class="opacity-80 hover:opacity-100 transition">
                </div>
                <div class="swiper-slide flex justify-center">
                    <img src="https://dummyimage.com/150x80/f472b6/ffffff&text=Mitra+5"
                        class="opacity-80 hover:opacity-100 transition">
                </div>

            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section id="testimoni" class="py-20 max-w-7xl mx-auto px-6">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-4 gradient-text">Testimoni</h2>
            <p class="text-gray-300">Apa kata mereka yang sudah menggunakan sistem kami.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg" data-aos="fade-up">
                <p class="text-gray-300 mb-4">"Sistem POS dari HDTECH mempermudah proses penjualan kami."</p>
                <h4 class="font-bold">Andi</h4>
                <span class="text-sm text-gray-400">Pemilik Toko</span>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <p class="text-gray-300 mb-4">"Inventory real-time membuat kami tidak pernah kehabisan stok."</p>
                <h4 class="font-bold">Siti</h4>
                <span class="text-sm text-gray-400">Manager Gudang</span>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <p class="text-gray-300 mb-4">"Analitik penjualan membantu meningkatkan profit bisnis."</p>
                <h4 class="font-bold">Budi</h4>
                <span class="text-sm text-gray-400">CEO Startup</span>
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section id="kontak" class="py-20 bg-gray-900">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-4 gradient-text">Kontak Kami</h2>
            <p class="text-gray-300">Hubungi kami untuk konsultasi atau informasi lebih lanjut.</p>
        </div>
        <div class="max-w-3xl mx-auto px-6" data-aos="fade-up">
            <form class="grid gap-6">
                <input type="text" placeholder="Nama"
                    class="p-4 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-cyan-400">
                <input type="email" placeholder="Email"
                    class="p-4 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-cyan-400">
                <textarea placeholder="Pesan" rows="4"
                    class="p-4 rounded-lg bg-gray-800 border border-gray-700 focus:outline-none focus:border-cyan-400"></textarea>
                <button
                    class="bg-gradient-to-r from-cyan-400 to-purple-600 py-3 rounded-lg font-semibold hover:from-purple-600 hover:to-cyan-400 transition">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-500 text-sm bg-[#0f172a]">
        © 2025 HDTECH. All rights reserved.
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2000
            },
            breakpoints: {
                640: {
                    slidesPerView: 3
                },
                320: {
                    slidesPerView: 2
                }
            }
        });
    </script>

    <script>
        const navLinks = document.querySelectorAll(".nav-link");

        window.addEventListener("scroll", () => {
            let current = "";
            document.querySelectorAll("section[id]").forEach(section => {
                const sectionTop = section.offsetTop - 90; // offset biar pas
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach(link => {
                link.classList.remove("text-cyan-400", "border-b-2", "border-cyan-400");
                if (link.getAttribute("href") === `#${current}`) {
                    link.classList.add("text-cyan-400", "border-b-2", "border-cyan-400");
                }
            });
        });
    </script>

    <script>
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
