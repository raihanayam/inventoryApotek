<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'satuan_id',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function satuan() {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function detail_obat_masuk() {
        return $this->hasMany(DetailObatMasuk::class, 'product_id', 'id');
    }

    public function detail_obat_keluar()
    {
        return $this->hasMany(DetailObatKeluar::class, 'product_id', 'id');
    }

    public function expiredSoonest()
    {
        return $this->detail_obat_masuk()
            ->whereNotNull('Tanggal_Kadaluwarsa')
            ->orderBy('Tanggal_Kadaluwarsa', 'asc')
            ->value('Tanggal_Kadaluwarsa');
    }

    public function batch()
    {
        return $this->hasMany(DetailObatMasuk::class, 'product_id');
    }
}

