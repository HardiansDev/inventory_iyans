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



    public function productIns()
    {
        return $this->hasMany(ProductIn::class, 'product_id', 'id');
    }


    public function latestApprovedProductIn()
    {
        return $this->hasOne(ProductIn::class, 'product_id')->where('status', 'disetujui')->latestOfMany();
    }

    public function getStatusAttribute($value)
    {
        // Jika ada ProductIn terbaru → pakai status dari situ
        return $this->latestProductIn?->status ?? $value;
    }

    public function getCatatanAttribute()
    {
        return $this->latestProductIn?->catatan;
    }

    public function getRequesterNameAttribute()
    {
        return $this->latestProductIn?->requester_name;
    }

    public function getRecipientAttribute()
    {
        return $this->latestProductIn?->recipient;
    }
}
