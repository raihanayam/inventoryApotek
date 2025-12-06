<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'Id_Keluar',
        'Id_User',
        'Tanggal_Keluar',
        'Jenis_Keluar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Id_User', 'id');
    }

    public function detail_obat_keluar()
    {
        return $this->hasMany(DetailObatKeluar::class, 'obat_keluar_id', 'id');
    }
}
