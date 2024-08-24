<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getNewCode()
    {
        $kode_terakhir = self::latest()->first();
        if ($kode_terakhir) {
            $inv_userid = 'INV';
            $lastInvoiceNumber = substr($kode_terakhir->invoice, strlen($inv_userid));
            $nextInvoiceNumber = str_pad((int) $lastInvoiceNumber + 1, 5, '0', STR_PAD_LEFT);
            $invoice = 'INV' . $nextInvoiceNumber;
            return $invoice;
        } else {
            $invoice =  'INV' . '00001';
            return $invoice;
        }
    }
}
