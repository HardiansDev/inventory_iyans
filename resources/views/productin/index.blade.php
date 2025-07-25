@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Produk Masuk</title>
@endsection

@section('content')
    <!-- Content Header -->
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Data Produk Masuk</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Produk Masuk</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- Header -->
                    <div class="box-header d-flex flex-wrap align-items-center justify-content-start gap-2 mb-3">
                        <!-- Tombol Tambah Produk -->
                        <a href="{{ route('productin.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus-circle"></i> Tambah Produk
                        </a>

                        <!-- Tombol Hapus Terpilih -->
                        <button id="BtnDeleteSelected" class="btn btn-danger btn-sm" disabled>
                            <i class="fas fa-trash-alt"></i> Hapus Terpilih
                        </button>

                        <!-- Dropdown Filter -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter"></i> Filter Data
                            </button>
                            <div class="dropdown-menu p-4" style="min-width: 300px;">
                                <form action="{{ route('productin.index') }}" method="GET">
                                    <!-- Filter Kategori -->
                                    <div class="mb-2">
                                        <label>Kategori</label>
                                        <select name="category" class="form-control">
                                            <option value="">-- Semua Kategori --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter Status Produk -->
                                    <div class="mb-2">
                                        <label>Status Produk</label>
                                        <select name="status_produk" class="form-control">
                                            <option value="">-- Semua --</option>
                                            <option value="menunggu"
                                                {{ request('status_produk') == 'menunggu' ? 'selected' : '' }}>Menunggu
                                            </option>
                                            <option value="diterima"
                                                {{ request('status_produk') == 'diterima' ? 'selected' : '' }}>Diterima
                                            </option>
                                            <option value="ditolak"
                                                {{ request('status_produk') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Filter Status Penjualan -->
                                    <div class="mb-2">
                                        <label>Status Penjualan</label>
                                        <select name="status_penjualan" class="form-control">
                                            <option value="">-- Semua --</option>
                                            <option value="belum dijual"
                                                {{ request('status_penjualan') == 'belum dijual' ? 'selected' : '' }}>Belum
                                                Dijual</option>
                                            <option value="sedang dijual"
                                                {{ request('status_penjualan') == 'sedang dijual' ? 'selected' : '' }}>
                                                Sedang Dijual</option>
                                            <option value="stok tinggal dikit"
                                                {{ request('status_penjualan') == 'stok tinggal dikit' ? 'selected' : '' }}>
                                                Stok Tinggal Dikit</option>
                                            <option value="stok habis terjual"
                                                {{ request('status_penjualan') == 'stok habis terjual' ? 'selected' : '' }}>
                                                Stok Habis Terjual</option>
                                        </select>
                                    </div>

                                    <!-- Filter Harga -->
                                    <div class="mb-2">
                                        <label>Harga (Min - Max)</label>
                                        <div class="d-flex gap-1">
                                            <input type="number" name="min_price" class="form-control" placeholder="Min"
                                                value="{{ request('min_price') }}">
                                            <input type="number" name="max_price" class="form-control" placeholder="Max"
                                                value="{{ request('max_price') }}">
                                        </div>
                                    </div>

                                    <!-- Filter Qty -->
                                    <div class="mb-3">
                                        <label>Qty (Min - Max)</label>
                                        <div class="d-flex gap-1">
                                            <input type="number" name="min_qty" class="form-control" placeholder="Min"
                                                value="{{ request('min_qty') }}">
                                            <input type="number" name="max_qty" class="form-control" placeholder="Max"
                                                value="{{ request('max_qty') }}">
                                        </div>
                                    </div>

                                    <div class="text-end d-flex justify-content-between">
                                        <a href="{{ route('productin.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-undo"></i> Reset Filter
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search"></i> Terapkan Filter
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" />
                                        </th>
                                        {{-- <th>No</th> --}}
                                        <th>Nama Produk</th>
                                        <th>Kode Produk</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Gambar Produk</th>
                                        <th>Kategori Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Penerima</th>
                                        <th>Status</th>
                                        <th>Status Penjualan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productIns as $productIn)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="select-item" value="{{ $productIn->id }}"
                                                    data-entry-id="{{ $productIn->id }}" />
                                            </td>

                                            <td>{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}</td>
                                            <td>{{ optional($productIn->product)->code ?? '-' }}</td>
                                            <td>{{ $productIn->date }}</td>

                                            <td>
                                                @if (optional($productIn->product)->photo)
                                                    <img src="{{ asset('storage/fotoproduct/produk/' . $productIn->product->photo) }}"
                                                        alt="Image" width="50">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>

                                            <td>{{ optional(optional($productIn->product)->category)->name ?? '-' }}</td>

                                            <td>Rp
                                                {{ number_format(optional($productIn->product)->price ?? 0, 0, ',', '.') }}
                                            </td>

                                            <td>{{ $productIn->qty }}</td>
                                            <td>{{ $productIn->recipient }}</td>

                                            <td>
                                                @if ($productIn->status === 'menunggu')
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif ($productIn->status === 'diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @elseif ($productIn->status === 'ditolak')
                                                    <div class="d-flex flex-column align-items-start">
                                                        <span class="badge bg-danger">Ditolak</span>
                                                        @if ($productIn->catatan)
                                                            <div class="mt-1 ms-1 text-muted" style="font-size: 12px;">
                                                                <i class="fa fa-info-circle me-1 text-secondary"></i> Note
                                                                :
                                                                {{ $productIn->catatan }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $statusPenjualan = $productIn->status_penjualan;
                                                    $stokToko = $productIn->sales->sum('qty');
                                                @endphp

                                                @if ($statusPenjualan === 'sedang dijual')
                                                    <span class="badge bg-teal">Sedang Dijual</span>
                                                @elseif ($statusPenjualan === 'stok habis terjual')
                                                    <span class="badge bg-danger">Stok Habis</span>
                                                @elseif ($statusPenjualan === 'stok tinggal dikit')
                                                    <span class="badge bg-warning text-dark">Stok Tinggal Dikit</span>
                                                @elseif ($statusPenjualan === 'belum dijual')
                                                    <span class="badge bg-secondary">Belum Dijual</span>
                                                @else
                                                    <span class="badge bg-light text-muted">-</span>
                                                @endif

                                                @if ($statusPenjualan !== 'belum dijual')
                                                    <div style="font-size: 12px;" class="text-muted mt-1">
                                                        <i class="fas fa-box me-1"></i> Sisa Stok: {{ $stokToko }}
                                                    </div>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        Pilih Aksi
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if ($productIn->status === 'menunggu')
                                                            <li>
                                                                <form
                                                                    action="{{ route('productin.updateStatus', $productIn->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status"
                                                                        value="diterima">
                                                                    <button type="submit"
                                                                        class="dropdown-item text-success">Terima</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="dropdown-item text-danger btn-tolak-dengan-catatan"
                                                                    data-productin-id="{{ $productIn->id }}"
                                                                    data-product-name="{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}">
                                                                    Tolak dengan Catatan
                                                                </button>
                                                            </li>
                                                        @endif

                                                        @if ($productIn->status === 'diterima' || session('status') === 'produk diterima')
                                                            @if ($productIn->sales->isEmpty())
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-secondary open-sale-form"
                                                                        data-product-id="{{ $productIn->id }}"
                                                                        data-product-name="{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}">
                                                                        Jual di Toko
                                                                    </button>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-secondary btn-add-stock"
                                                                        data-productin-id="{{ $productIn->id }}"
                                                                        data-product-name="{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}"
                                                                        data-stock="{{ optional($productIn->product)->stock ?? 0 }}">
                                                                        Tambah Stok ke Gudang
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-secondary btn-add-stock-toko"
                                                                        data-productin-id="{{ $productIn->id }}"
                                                                        data-product-name="{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}"
                                                                        data-max-stok="{{ $productIn->qty }}">
                                                                        Tambah Stok ke Toko
                                                                    </button>
                                                                </li>
                                                            @endif
                                                        @endif

                                                        <li>
                                                            <button class="dropdown-item text-danger btn-delete-stock"
                                                                data-productin-id="{{ $productIn->id }}"
                                                                data-product-name="{{ optional($productIn->product)->name ?? 'Produk Dihapus' }}">
                                                                Hapus Produk Masuk
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="saleForm" action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="saleModalLabel">Jual Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="product_ins_id" id="product_ins_id">
                        <div class="mb-3">
                            <label for="qty" class="form-label">Jumlah (Qty)</label>
                            <input type="number" name="qty" id="qty" class="form-control" min="1"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Jual Ke Toko</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Stok ke Gudang -->
    <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="add-stock-form">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStockModalLabel">Tambah Stok ke Gudang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong id="modal-product-name"></strong></p>
                        <input type="number" class="form-control" name="tambah_qty" id="tambah_qty_input"
                            min="1" required placeholder="Jumlah yang ditambahkan">
                        <p class="text-muted" style="font-size: 14px;">
                            Stok saat ini di gudang: <strong id="modal-stock-now"></strong>
                        </p>
                    </div>


                    <div class="modal-footer">
                        <input type="hidden" id="modal-productin-id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Stok</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- Modal Tambah Stok Ke Toko --}}
    <div class="modal fade" id="addStockTokoModal" tabindex="-1" aria-labelledby="addStockTokoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addStockForm" action="#" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStockTokoModalLabel">Tambah Stok ke Toko</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="addStockProductId">
                        <div class="mb-3">
                            <label for="addStockQty" class="form-label">Jumlah Qty</label>
                            <input type="number" class="form-control" id="addStockQty" min="1" required>
                            <small id="stokMaxLabel" class="text-muted"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah ke Toko</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection


{{-- js tambah stok ke gudang --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('addStockModal'));
        const form = document.getElementById('add-stock-form');

        document.querySelectorAll('.btn-add-stock').forEach(btn => {
            btn.addEventListener('click', function() {
                const productInId = this.getAttribute('data-productin-id');
                const productName = this.getAttribute('data-product-name');
                const currentStock = this.dataset.stock;

                document.getElementById('modal-productin-id').value = productInId;
                document.getElementById('modal-product-name').innerText = productName;
                document.getElementById('modal-stock-now').innerText = currentStock;
                document.getElementById('tambah_qty_input').value = '';
                modal.show();
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('modal-productin-id').value;
            const qty = document.getElementById('tambah_qty_input').value;

            fetch(`/productin/add-stock/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tambah_qty: qty
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message || 'Stok berhasil ditambahkan!');
                        modal.hide();

                        // Optional: reload label stok secara dinamis
                        setTimeout(() => window.location.reload(), 800);
                    } else {
                        toastr.error(data.message || 'Gagal menambahkan stok.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Gagal terhubung ke server.');
                });
        });
    });
</script>


{{-- tambah stok ke toko --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('addStockTokoModal'));

        // Tombol buka modal
        document.querySelectorAll('.btn-add-stock-toko').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productinId;
                const productName = this.dataset.productName;
                const maxStok = this.dataset.maxStok;

                // Isi label modal
                document.getElementById('addStockTokoModalLabel').textContent =
                    `Tambah Stok ke Toko: ${productName}`;
                document.getElementById('stokMaxLabel').textContent =
                    `Stok tersedia di Gudang: ${maxStok}`;

                // Set input hidden dan max
                document.getElementById('addStockProductId').value = productId;
                document.getElementById('addStockQty').setAttribute('max', maxStok);
                document.getElementById('addStockQty').value = 1;

                modal.show();
            });
        });

        // Submit Form AJAX
        document.getElementById('addStockForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const productId = document.getElementById('addStockProductId').value;
            const qtyInput = document.getElementById('addStockQty');
            const qty = parseInt(qtyInput.value);
            const maxQty = parseInt(qtyInput.getAttribute('max'));

            if (!qty || qty < 1) {
                toastr.warning('Jumlah harus diisi minimal 1');
                return;
            }

            if (qty > maxQty) {
                toastr.warning(`Jumlah melebihi stok gudang. Maksimum ${maxQty}`);
                return;
            }

            fetch(`/productin/add-stock-toko/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        qty: qty
                    })
                })
                .then(async res => {
                    const contentType = res.headers.get("content-type") || "";
                    if (!res.ok || !contentType.includes("application/json")) {
                        const text = await res.text();
                        console.error('Server response (text):', text);
                        throw new Error('Terjadi kesalahan dari server.');
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                        modal.hide();

                        // Tetap di halaman productin
                        setTimeout(() => {
                            window.location.href = data.redirect_url || '/productin';
                        }, 800);
                    } else {
                        toastr.error(data.message || 'Gagal menambahkan stok ke toko.');
                    }
                })
                .catch(err => {
                    console.error('Catch error:', err);
                    toastr.error(err.message || 'Gagal terhubung ke server.');
                });

        });
    });
</script>


{{-- Catatan Penolakan Produk --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-tolak-dengan-catatan').forEach(button => {
            button.addEventListener('click', function() {
                const productInId = this.dataset.productinId;
                const productName = this.dataset.productName;

                Swal.fire({
                    title: `Tolak Produk: ${productName}`,
                    input: 'textarea',
                    inputLabel: 'Alasan Penolakan',
                    inputPlaceholder: 'Tulis alasan penolakan di sini...',
                    inputAttributes: {
                        'aria-label': 'Alasan penolakan'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Tolak Produk',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Catatan tidak boleh kosong!';
                        }
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        fetch(`/productin/update-status/${productInId}`, {
                                method: 'PUT',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    status: 'ditolak',
                                    catatan: result.value
                                })
                            })
                            .then(async res => {
                                const contentType = res.headers.get(
                                    "content-type");
                                if (!res.ok || !contentType.includes(
                                        "application/json")) {
                                    const text = await res.text();
                                    throw new Error(text ||
                                        'Terjadi kesalahan dari server.');
                                }
                                return res.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    toastr.success(data.message);
                                    setTimeout(() => window.location.reload(),
                                        1000);
                                } else {
                                    toastr.error(data.message ||
                                        'Gagal memperbarui status.');
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                toastr.error('Gagal menghubungi server.');
                            });
                    }
                });
            });
        });
    });
</script>



{{-- toltip pesan tolak --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

{{-- Selectall delete --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const selectItems = document.querySelectorAll('.select-item');
        const BtnDeleteSelected = document.getElementById('BtnDeleteSelected');

        let selectedIds = [];

        // Update selectedIds berdasarkan checkbox yang dicentang
        function updateSelectedIds() {
            selectedIds = [];
            selectItems.forEach(item => {
                if (item.checked && item.closest('tr').offsetParent !== null) {
                    selectedIds.push(item.value);
                }
            });
        }

        // Enable/Disable tombol
        function toggleActionButtons() {
            const hasSelected = selectedIds.length > 0;
            BtnDeleteSelected.disabled = !hasSelected;
            downloadBtn.disabled = !hasSelected;
        }

        // Toggle Select All
        selectAll.addEventListener('change', function() {
            selectItems.forEach(item => {
                if (item.closest('tr').offsetParent !== null) {
                    item.checked = this.checked;
                }
            });
            updateSelectedIds();
            toggleActionButtons();
        });

        // Checkbox per item
        selectItems.forEach(item => {
            item.addEventListener('change', function() {
                updateSelectedIds();

                // Uncheck Select All jika ada satu yang uncheck
                if (!this.checked) {
                    selectAll.checked = false;
                } else if ([...selectItems].every(cb => cb.checked || cb.closest('tr')
                        .offsetParent === null)) {
                    selectAll.checked = true;
                }

                toggleActionButtons();
            });
        });

        // Hapus data terpilih
        BtnDeleteSelected.addEventListener('click', function() {
            if (selectedIds.length === 0) return;

            Swal.fire({
                title: 'Hapus Produk Terpilih?',
                text: 'Data yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/productin/delete-selected', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                ids: selectedIds
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Berhasil', data.message, 'success');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                Swal.fire('Gagal', data.message, 'error');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                        });
                }
            });
        });

        updateSelectedIds();
        toggleActionButtons();
    });
</script>
