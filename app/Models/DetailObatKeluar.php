<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailObatKeluar extends Model
{
    use HasFactory;

    protected $guarded = [];

public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'id');
}

public function obatkeluar()
{
    return $this->belongsTo(ObatKeluar::class, 'Id_Keluar', 'Id_Keluar');
}

public function satuan()
{
    return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
}

}
