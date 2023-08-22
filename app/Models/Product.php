<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\Pic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'code',
        'photo',
        'category_id',
        'price',
        'qty',
        'stock',
        'quality',
        'purchase',
        'billnum',
        'supplier_id',
        'pic_id',
    ];
    // protected $dates = ['created_at'];

    function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    function pics()
    {
        return $this->belongsTo(Pic::class, 'pic_id', 'id');
    }
}