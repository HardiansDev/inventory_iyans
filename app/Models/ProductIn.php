<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class ProductIn extends Model
{
    use HasFactory;

    protected $table = 'product_ins';

    protected $fillable = [
        'product_id',     // ID produk yang dimasukkan
        'supplier_id',    // ID supplier
        'category_id',    // ID kategori
        'date',           // Tanggal masuk
        'recipient',      // Nama penerima
        'qty',            // Jumlah produk yang masuk
        'status',         // Status produk
    ];

    /**
     * Relasi dengan model Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Event boot model untuk menangani perubahan status.
     */
    public static function boot()
    {
        parent::boot();

        static::updated(function ($productIn) {
            $previousStatus = $productIn->getOriginal('status');
            $currentStatus = $productIn->status;

            if ($currentStatus === 'diterima' && $previousStatus !== 'diterima') {
                // Status berubah menjadi diterima
                static::handleAcceptedStatus($productIn);
            } elseif ($currentStatus === 'ditolak' && $previousStatus !== 'ditolak') {
                // Status berubah menjadi ditolak
                static::handleRejectedStatus($productIn);
            }
        });
    }

    /**
     * Handle status diterima: Kurangi stok produk.
     */
    private static function handleAcceptedStatus($productIn)
    {
        $product = $productIn->product;

        if ($product) {
            // Menghitung stok baru setelah dikurangi dengan qty yang diterima
            $newStock = $product->stock - $productIn->qty;

            if ($newStock >= 0) {
                // Jika stok mencukupi, lakukan pengurangan stok
                $product->update(['stock' => $newStock]);
            } else {
                // Jika stok tidak mencukupi, catat error log
                Log::error(
                    "Stok tidak cukup untuk produk {$product->id}. " .
                        "Produk yang masuk: {$productIn->qty}, stok saat ini: {$product->stock}"
                );
            }
        }
    }



    /**
     * Handle status ditolak: Kembalikan stok produk dan hapus data dari product_in.
     */
    private static function handleRejectedStatus($productIn)
    {
        $productIn->delete(); // Hapus data product_in
    }
}
