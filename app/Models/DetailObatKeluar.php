<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailObatKeluar extends Model
{
    use HasFactory;

    protected $table = 'detail_obat_keluars';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function obatkeluar()
    {
        return $this->belongsTo(ObatKeluar::class, 'obat_keluar_id', 'id');
    }
}
