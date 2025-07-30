<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductIn extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_ins';

    protected $fillable = [
        'product_id',
        'date',
        'recipient',         // penerima saat disetujui
        'requester_name',    // pemohon
        'qty',
        'status',            // menunggu / disetujui / ditolak
        'status_penjualan',  // optional: jika ingin tambah status penjualan
        'catatan',           // catatan alasan penolakan (jika ada)
    ];

    /**
     * Relasi ke produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relasi ke data penjualan (jika produk ini sudah diproses ke sales).
     */
    public function sales()
    {
        return $this->hasMany(Sales::class, 'product_ins_id');
    }

    /**
     * Menghitung sisa stok dari qty awal dikurangi total penjualan.
     */
    public function getRemainingStock()
    {
        $used = $this->sales()->sum('qty');
        return $this->qty - $used;
    }

    /**
     * Apakah permintaan sudah disetujui?
     */
    public function isApproved()
    {
        return $this->status === 'disetujui';
    }

    /**
     * Apakah permintaan masih menunggu persetujuan?
     */
    public function isPending()
    {
        return $this->status === 'menunggu';
    }

    /**
     * Apakah permintaan ditolak?
     */
    public function isRejected()
    {
        return $this->status === 'ditolak';
    }
}
