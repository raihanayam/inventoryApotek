<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'Id_Masuk',
        'Id_User',
        'Tanggal_Masuk',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Id_User', 'id');
    }

    public function detail_obat_masuk()
    {
        return $this->hasMany(DetailObatMasuk::class, 'obat_masuk_id', 'id');
    }
}