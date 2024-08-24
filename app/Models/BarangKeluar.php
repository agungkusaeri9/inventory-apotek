<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar';
    protected $guarded = ['id'];
    public $casts = ['tanggal' => 'datetime'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }


    public static function getNewCode()
    {
        $kodeTerakhir = self::getLatestCode();

        if ($kodeTerakhir) {
            // Ambil angka dari kode terakhir
            $angkaKodeTerakhir = intval(substr($kodeTerakhir->kode, 3));

            // Increment angka
            $angkaBaru = $angkaKodeTerakhir + 1;

            // Format ulang angka menjadi tiga digit (contoh: 001, 002, dst.)
            $angkaFormatBaru = sprintf('%03d', $angkaBaru);

            // Gabungkan dengan awalan (contoh: BM001, BM002, dst.)
            $kodeBaru = 'BK' . $angkaFormatBaru;
        } else {
            // Jika tidak ada kode terakhir, buat kode baru dengan awalan BM001
            $kodeBaru = 'BK001';
        }

        return $kodeBaru;
    }
    public function details()
    {
        return $this->hasOne(BarangKeluarDetail::class);
    }

    public static function getLatestCode()
    {
        $item_latest = BarangKeluar::latest()->first();
        return $item_latest;
    }
}
