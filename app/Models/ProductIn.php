<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIn extends Model
{
    use HasFactory;

    /**
     * Table name associated with the model.
     */
    protected $table = 'product_ins';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'supplier_id',
        'category_id',
        'date',
        'recipient',
        'qty',
        'status',
    ];

    /**
     * Relationship with the Product model.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship with the Supplier model.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
