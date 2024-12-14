<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('title')
    @yield('styles')
    <link rel="icon" href="{{ asset('temp/dist/img/favicon.ico') }}">
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

<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">
        <!-- Header -->
        <header class="main-header">
            <a href="/" class="logo">
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
    <!-- Include jsPDF dan html2pdf library -->
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
                    "emptyTable": "Data produk tidak ditemukan." // Pesan jika tabel kosong
                }
            });

            // Filter berdasarkan kategori
            $('#filtername').on('change', function() {
                var selectedValue = $(this).val();
                // Filter berdasarkan kategori di kolom ke-4 (kategori produk)
                table.columns(5).search(selectedValue).draw(); // Kolom ke-5 adalah kolom kategori
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

            // Toggle all checkboxes
            selectAll.addEventListener('change', function() {
                selectedIds = [];
                selectItems.forEach(item => {
                    item.checked = this.checked;
                    if (this.checked) {
                        selectedIds.push(item.value);
                    }
                });
                toggleDeleteAllBtn();
            });

            // Handle individual checkboxes
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

    
</body>

</html>
