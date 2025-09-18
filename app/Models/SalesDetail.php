<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;

    protected $table = 'salesdetails'; // Sesuaikan nama tabel

    protected $fillable = [
        'sales_id',
        'date_order',
        'discount_id', //nullable
        'amount',
        'total',
        'subtotal',
        'change',
        'metode_pembayaran',
        'transaction_number',
        'invoice_number',
        'qty',
        'price',
        'created_by',
    ];

    /**
     * Relasi ke model Sales
     * Setiap detail penjualan terkait dengan satu transaksi penjualan.
     */
    public function sales()
    {
        return $this->belongsTo(Sales::class)->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\ProductIn::class, 'sales_id');
    }

    public function productin()
    {
        return $this->belongsTo(\App\Models\ProductIn::class, 'sales_id');
    }


    /**
     * Relasi ke model Discount
     * Setiap detail penjualan dapat memiliki satu diskon.
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function satuan()
    {
        return $this->hasOneThrough(
            Satuan::class,
            Product::class,
            'id',
            'id',
            'product_id',
            'satuan_id'
        );
    }
}
