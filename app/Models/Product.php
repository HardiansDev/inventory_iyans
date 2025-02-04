<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',           // Nama produk
        'code',           // Kode produk unik
        'photo',          // Lokasi foto produk
        'category_id',    // ID kategori
        'price',          // Harga produk
        'stock',          // Informasi stok
        'supplier_id',    // ID supplier
        'status',
    ];

    /**
     * Get the category associated with the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'No Category',
        ]);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault([
            'name' => 'No Supplier',
        ]);
    }

    public function productIns()
    {
        return $this->hasMany(ProductIn::class, 'product_id','id');
    }
}
