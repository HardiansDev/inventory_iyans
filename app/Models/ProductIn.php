<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductIn extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_ins';

    protected $fillable = [
        'product_id',     // ID produk yang dimasukkan
        'date',           // Tanggal masuk
        'recipient',      // Nama penerima
        'qty',            // Jumlah produk yang masuk
        'status',         // Status produk
        'status_penjualan',
        'catatan',         // Notes Jika Penolakan
    ];

    /**
     * Relasi dengan model Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(Sales::class, 'product_ins_id');
    }



    public function getRemainingStock()
    {
        // Total terjual dari salesdetails
        $used = $this->sales()->sum('qty');
        return $this->qty - $used;
    }
}
