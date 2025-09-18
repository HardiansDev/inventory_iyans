<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_satuan', 'keterangan'];

    // Relasi ke Product
    public function products()
    {
        return $this->hasMany(Product::class, 'satuan_id');
    }
}
