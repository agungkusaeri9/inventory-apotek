<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluarDetail extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar_detail';
    protected $guarded = ['id'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
    public function barang_keluar()
    {
        return $this->belongsTo(BarangKeluar::class);
    }
}
