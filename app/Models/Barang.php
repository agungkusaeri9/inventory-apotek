<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $guarded = ['id'];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function gambar()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        } else {
            return asset('assets/images/logo.svg');
        }
    }

    public static function getNewCode()
    {
        $barang_terakhir = Barang::latest()->first();
        if ($barang_terakhir) {
            $kode_nomor = \Str::after($barang_terakhir->kode, 'BRG');
            $kode_baru = "BRG" . str_pad($kode_nomor + 1, 3, 0, STR_PAD_LEFT);
        } else {
            $kode_baru = "BRG001";
        }
        return $kode_baru;
    }

    public function harga()
    {
        return "Rp " . number_format($this->harga, 0, 0);
    }
}
