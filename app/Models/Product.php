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
        'category_id',
        'supplier_id',
        'pic_id',
        'name',
        'code',
        'photo',
        'price',
        'qty',
        'stock',
        'quality',
        'purchase',
        'billnum',
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
