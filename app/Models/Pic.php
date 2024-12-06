<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pic extends Model
{
    use HasFactory;
    protected $table = "pics";
    protected $fillable = ['name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'pic_id');
    }
}
