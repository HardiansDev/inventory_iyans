<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
