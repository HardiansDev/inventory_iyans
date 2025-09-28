<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = ['name', 'address', 'telp', 'email_sup', 'name_prod'];

    public function productIns()
    {
        return $this->hasManyThrough(ProductIn::class, Product::class);
    }
}
