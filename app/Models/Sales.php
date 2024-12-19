<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'qty', 'product_ins_id'
    ];

    /**
     * Relasi ke model ProductIns
     * Setiap transaksi penjualan terkait dengan satu produk yang masuk.
     */
    public function productIns()
    {
        return $this->belongsTo(ProductIn::class, 'product_ins_id');
    }

    /**
     * Relasi ke model SalesDetail
     * Satu transaksi penjualan memiliki banyak detail penjualan.
     */
    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class, 'sales_id');
    }
}
