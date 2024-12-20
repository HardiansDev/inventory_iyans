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
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(Sales::class, 'product_ins_id');
    }

}
