<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    @yield('styles')
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /* PDF Styling */
        .pdf-container {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .pdf-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .pdf-header h1 {
            font-size: 24px;
            margin: 0;
        }

        .pdf-details {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .pdf-details p {
            margin: 10px 0;
        }

        .pdf-details .label {
            font-weight: bold;
            color: #555;
        }

        .pdf-image {
            text-align: center;
            margin-top: 20px;
        }

        .pdf-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>


    <style>
        a {
            text-decoration: none !important;
        }

        a:hover {
            text-decoration: none !important;
        }
    </style>

    <style>
        .dataTables_filter {
            margin-bottom: 10px;
            /* Memberikan jarak ke bawah */
        }
    </style>

    <!-- CSS Eksternal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- AdminLTE dan Tema -->
    <link href="{{ asset('temp/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('temp/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet">
    <link href="{{ asset('temp/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"
        rel="stylesheet">
</head>

<body class="hold-transition skin-green sidebar-mini fixed">
    <div class="wrapper">
        <!-- Header -->
        <header class="main-header">
            <a href="#" class="logo">
                <span class="logo-mini"><b>G</b>I</span>
                <span class="logo-lg"><b>Gudang</b>Iyan</span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </nav>
        </header>

        <!-- Sidebar -->
        @include('layouts.module.sidebar')

        <!-- Konten -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts.module.footer')
    </div>

    <!-- JavaScript Eksternal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('temp/dist/js/adminlte.min.js') }}"></script>

    <!-- Script Tambahan -->
    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                "language": {
                    "emptyTable": "Data produk tidak ditemukan.", // Pesan jika tabel kosong
                    "zeroRecords": "Data tidak ditemukan",
                    "lengthMenu": [10, 25, 50, 100], // Dropdown "Show Entries"
                    "pageLength": 10, // Default tampil 10 baris
                    "paging": true,
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    },
                    "search": "Cari:",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data tersedia",
                },

            });

            // Filter berdasarkan kategori
            $('#filtername').on('change', function() {
                var selectedValue = $(this).val();
                // Filter berdasarkan kategori di kolom ke-4 (kategori produk)
                table.columns(4).search(selectedValue).draw(); // Kolom ke-5 adalah kolom kategori
            });

            // Fungsi umum untuk menghapus dengan SweetAlert
            function setupDeleteConfirmation(selector, entityName, idAttribute, nameAttribute) {
                document.querySelectorAll(selector).forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault(); // Mencegah pengiriman form langsung (default)
                        const entityId = this.dataset[idAttribute];
                        const entityNameValue = this.dataset[nameAttribute];

                        // Tampilkan SweetAlert
                        Swal.fire({
                            title: `Konfirmasi Hapus ${entityName}`,
                            text: `Apakah Anda yakin ingin menghapus ${entityName.toLowerCase()} "${entityNameValue}"?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Cari form terkait tombol ini dan submit
                                const form = this.closest(
                                    'form'); // Form yang terdekat dengan tombol
                                form.submit();
                            }
                        });
                    });
                });
            }

            // Inisialisasi fitur hapus untuk setiap entitas
            setupDeleteConfirmation('.delete-prod', 'Produk', 'idprod', 'namaprod');
            setupDeleteConfirmation('.delete-supp', 'Supplier', 'idsupp', 'namasupp');
            setupDeleteConfirmation('.delete-cate', 'Kategori', 'idcate', 'namacate');

        });
    </script>

    <script>
        document.getElementById('print-btn').addEventListener('click', function() {
            const element = document.querySelector('.product-details-container');

            if (element) {
                const options = {
                    margin: 10,
                    filename: 'Detail_Produk.pdf',
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    },
                };

                html2pdf().set(options).from(element).toPdf().output('datauristring').then(function(pdfDataUri) {
                    // Buka PDF di tab baru
                    const pdfWindow = window.open('');
                    pdfWindow.document.write('<iframe src="' + pdfDataUri +
                        '" frameborder="0" style="width:100%;height:100%;"></iframe>');
                });
            } else {
                console.error('Element not found for PDF generation');
            }
        });
    </script>

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const selectItems = document.querySelectorAll('.select-item');
            const deleteAllBtn = document.getElementById('deleteAllBtn');
            let selectedIds = [];

            // Toggle all checkboxes for visible entries
            selectAll.addEventListener('change', function() {
                selectedIds = [];
                selectItems.forEach(item => {
                    if (item.closest('tr').offsetParent !== null) { // Only visible rows
                        item.checked = this.checked;
                        if (this.checked) {
                            selectedIds.push(item.value);
                        }
                    }
                });
                toggleDeleteAllBtn();
            });

            // Handle individual checkbox changes
            selectItems.forEach(item => {
                item.addEventListener('change', function() {
                    if (this.checked) {
                        selectedIds.push(this.value);
                    } else {
                        selectedIds = selectedIds.filter(id => id !== this.value);
                        selectAll.checked = false;
                    }
                    toggleDeleteAllBtn();
                });
            });

            // Enable/Disable Delete All button
            function toggleDeleteAllBtn() {
                deleteAllBtn.disabled = selectedIds.length === 0;
            }

            // Handle Delete All button click
            deleteAllBtn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus semua produk terpilih?')) {
                    fetch('{{ route('product.deleteAll') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ids: selectedIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                window.location.reload();
                            } else {
                                alert('Terjadi kesalahan.');
                            }
                        });
                }
            });
        });
    </script>

    {{-- unduh pdf by showing data entries --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadPdfBtn = document.getElementById('downloadPdfBtn');
            const visibleItems = document.querySelectorAll('.select-item');

            downloadPdfBtn.addEventListener('click', function() {
                const displayedIds = Array.from(visibleItems)
                    .filter(item => item.closest('tr').offsetParent !== null) // Hanya baris yang terlihat
                    .map(item => item.dataset.entryId);

                if (displayedIds.length === 0) {
                    alert('Tidak ada data yang dapat diunduh.');
                    return;
                }

                // Kirim data ke server untuk menghasilkan PDF
                fetch('{{ route('product.downloadPdf') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: displayedIds
                        })
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        // Buat link download untuk file PDF
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = 'Produk_Terpilih.pdf';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan:', error);
                        alert('Gagal mengunduh PDF.');
                    });
            });
        });
    </script>

    {{-- unduh excel by showing data entries --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadExcelBtn = document.getElementById('downloadExcelBtn');
            const visibleItems = document.querySelectorAll('.select-item');

            downloadExcelBtn.addEventListener('click', function() {
                const displayedIds = Array.from(visibleItems)
                    .filter(item => item.closest('tr').offsetParent !== null) // Hanya baris yang terlihat
                    .map(item => item.dataset.entryId);

                if (displayedIds.length === 0) {
                    alert('Tidak ada data yang dapat diunduh.');
                    return;
                }

                // Kirim data ke server untuk menghasilkan Excel
                fetch('{{ route('product.downloadExcel') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: displayedIds
                        })
                    })
                    .then(response => response.blob())
                    .then(blob => {
                        // Buat link download untuk file Excel
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = 'Produk_Terpilih.xlsx';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan:', error);
                        alert('Gagal mengunduh Excel.');
                    });
            });
        });
    </script>


    {{-- nominal otomatis --}}
    <script>
        function formatPriceDisplay(input) {
            // Ambil nilai asli (tanpa pemisah ribuan)
            let rawValue = input.value.replace(/,/g, ''); // Hapus koma
            if (!/^\d*$/.test(rawValue)) {
                rawValue = rawValue.replace(/[^\d]/g, ''); // Hapus karakter non-digit
            }

            // Update elemen hidden dengan nilai asli (tanpa koma)
            document.getElementById('priceHidden').value = rawValue;

            // Format nilai dengan pemisah ribuan untuk ditampilkan
            const formattedValue = new Intl.NumberFormat('en-US').format(rawValue);
            input.value = formattedValue;
        }

        // Pastikan hidden input memiliki nilai asli saat form dikirim
        document.querySelector('form').addEventListener('submit', function() {
            const displayInput = document.getElementById('productPrice');
            const rawValue = displayInput.value.replace(/,/g, ''); // Hapus semua koma
            document.getElementById('priceHidden').value = rawValue; // Set nilai asli ke hidden input
        });
    </script>

    {{-- tabel wishlist --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let wishlist = [];
            const cartBadge = document.getElementById('cart-badge');
            const cartIcon = document.getElementById('cart-icon');

            // Function untuk memperbarui tabel wishlist dan badge cart
            function updateWishlist() {
                let tableBody = document.getElementById('wishlist-table-body');
                tableBody.innerHTML = '';
                let totalPrice = 0;

                wishlist.forEach((item, index) => {
                    let row = document.createElement('tr');
                    row.innerHTML = `
                <td>${item.name}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-secondary btn-sm adjust-qty-wishlist" data-index="${index}" data-adjust="-1">-</button>
                        <span class="mx-2" id="wishlist-qty-${index}">${item.qty}</span>
                        <button class="btn btn-secondary btn-sm adjust-qty-wishlist" data-index="${index}" data-adjust="1">+</button>
                    </div>
                </td>
                <td>Rp ${item.price.toLocaleString()}</td>
                <td><button class="btn btn-danger remove-from-wishlist" data-index="${index}">X</button></td>
            `;
                    tableBody.appendChild(row);
                    totalPrice += item.price * item.qty;
                });

                document.getElementById('total-price').textContent = `Rp ${totalPrice.toLocaleString()}`;
                cartBadge.textContent = wishlist.length;
                cartBadge.style.display = wishlist.length > 0 ? 'inline-block' : 'none';

                const checkoutButton = document.getElementById('checkout-button');
                checkoutButton.style.display = wishlist.length > 0 ? 'block' : 'none';
            }

            // Event listener untuk tombol 'Pesan' pada produk
            document.querySelectorAll('.add-to-wishlist').forEach(button => {
                button.addEventListener('click', function() {
                    let id = parseInt(this.getAttribute('data-product-id')); // Ambil ID
                    let name = this.getAttribute('data-product-name');
                    let price = parseInt(this.getAttribute('data-price'));
                    let qtyInput = this.closest('.card-body').querySelector('.qty-input');
                    let qty = parseInt(qtyInput.value);

                    let existingItemIndex = wishlist.findIndex(item => item.id === id);

                    if (existingItemIndex !== -1) {
                        wishlist[existingItemIndex].qty += qty;
                    } else {
                        wishlist.push({
                            id: id, // Ini krusial!
                            name: name,
                            price: price,
                            qty: qty
                        });
                    }
                    updateWishlist();
                    qtyInput.value = 1;
                });
            });

            // Event listener untuk tabel wishlist (adjust qty dan remove)
            document.getElementById('wishlist-table-body').addEventListener('click', function(e) {
                if (e.target.classList.contains('adjust-qty-wishlist')) {
                    let index = parseInt(e.target.getAttribute('data-index'));
                    let adjust = parseInt(e.target.getAttribute('data-adjust'));
                    wishlist[index].qty += adjust;
                    if (wishlist[index].qty < 1) wishlist[index].qty = 1;
                    updateWishlist();
                } else if (e.target.classList.contains('remove-from-wishlist')) {
                    let index = parseInt(e.target.getAttribute('data-index'));
                    wishlist.splice(index, 1);
                    updateWishlist();
                }
            });

            // Event listener untuk tombol checkout
            document.getElementById('checkout-button').addEventListener('click', function() {
                if (wishlist.length > 0) {
                    // Kirim data wishlist ke server menggunakan AJAX
                    fetch('/set-wishlist', { // Route untuk menyimpan wishlist ke session
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content') // Penting untuk proteksi CSRF
                            },
                            body: JSON.stringify(wishlist)
                        })
                        .then(response => {
                            if (response.ok) {
                                window.location.href =
                                    '/detail-cekout'; // Redirect setelah data disimpan
                            } else {
                                console.error("Gagal menyimpan wishlist ke session.");
                                alert("Terjadi kesalahan, coba lagi nanti.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Terjadi kesalahan, coba lagi nanti.");
                        });
                } else {
                    alert('Wishlist kosong!');
                }
            });

            // Event listener untuk ikon cart
            cartIcon.addEventListener('click', function() {
                const wishlistModal = new bootstrap.Modal(document.getElementById('wishlistModal'));
                wishlistModal.show();
            });

            // Event listener untuk tombol adjust (+/-) pada produk
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('adjust-qty')) {
                    let qtyInput = e.target.closest('.d-flex').querySelector('.qty-input');
                    let currentQty = parseInt(qtyInput.value);
                    let adjust = parseInt(e.target.getAttribute('data-adjust'));
                    let newQty = currentQty + adjust;
                    if (newQty < 1) newQty = 1;
                    qtyInput.value = newQty;
                }
            });

            // Event listener untuk input qty langsung
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value < 1) {
                        this.value = 1;
                    }
                });
            });
        });
    </script>

    {{-- modal masukiin produk ke toko --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua tombol 'Jual di Toko'
            const saleButtons = document.querySelectorAll('.open-sale-form');

            // Tambahkan event listener untuk setiap tombol
            saleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');

                    // Set value ke input hidden
                    document.getElementById('product_ins_id').value = productId;

                    // Bisa juga menampilkan nama produk di modal jika diperlukan
                    document.getElementById('saleModalLabel').textContent =
                        `Jual Produk: ${productName}`;

                    // Tampilkan modal
                    var myModal = new bootstrap.Modal(document.getElementById('saleModal'));
                    myModal.show();
                });
            });
        });
    </script>

</body>

</html>
