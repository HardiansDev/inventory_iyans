<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nilai',
    ];

    /**
     * Relasi ke model SalesDetail
     * Satu diskon dapat digunakan oleh banyak detail penjualan.
     */
    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
