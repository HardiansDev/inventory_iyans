<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id', 'date_order', 'discount_id',
        'amount', 'total', 'subtotal', 'change',
        'transaction_number', 'invoice_number'
    ];

    /**
     * Relasi ke model Sales
     * Setiap detail penjualan terkait dengan satu transaksi penjualan.
     */
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    /**
     * Relasi ke model Discount
     * Setiap detail penjualan dapat memiliki satu diskon.
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
