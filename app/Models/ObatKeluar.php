<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_keluar',  // pastikan sesuai kolom DB
        'id_user',
        'tanggal_keluar',
        'jenis_keluar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function detail_obat_keluar()
    {
        return $this->hasMany(DetailObatKeluar::class, 'id_keluar', 'id_keluar');
    }
}
