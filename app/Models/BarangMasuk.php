<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal' => 'date',
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function harga()
    {
        return formatRupiah($this->harga);
    }

    public function total()
    {
        return formatRupiah($this->total);
    }

    public function details()
    {
        return $this->hasMany(BarangMasukDetail::class);
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
            $kodeBaru = 'BM' . $angkaFormatBaru;
        } else {
            // Jika tidak ada kode terakhir, buat kode baru dengan awalan BM001
            $kodeBaru = 'BM001';
        }

        return $kodeBaru;
    }

    public static function getLatestCode()
    {
        $item_latest = BarangMasuk::latest()->first();
        return $item_latest;
    }
}
