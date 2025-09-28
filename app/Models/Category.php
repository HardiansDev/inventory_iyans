<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id'); // Menyatakan bahwa kategori memiliki banyak produk
    }

    public function productIns()
    {
        return $this->hasManyThrough(ProductIn::class, Product::class);
    }
}
