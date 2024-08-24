<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Transaksi;
use App\Services\WhatsappService;
use Barryvdh\DomPDF\Facade\Pdf;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        $items = Transaksi::latest()->get();
        return view('admin.pages.transaksi.index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        $kode_baru  = Transaksi::getNewCode();
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        return view('admin.pages.transaksi.create', [
            'data_barang' => $data_barang,
            'kode_baru' => $kode_baru
        ]);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'sub_total' => ['required', 'numeric'],
            'tunai' => ['required', 'numeric'],
            'kembalian' => ['required', 'numeric'],
            'data' => ['required', 'array']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();
        try {
            $penjualan = Transaksi::create([
                'invoice' => Transaksi::getNewCode(),
                'user_id' => auth()->id(),
                'sub_total' => request('sub_total'),
                'tunai' => request('tunai'),
                'kembalian' => request('kembalian'),
                'diskon' => request('diskon'),
                'total_harga' => 0
            ]);

            $data_barang = request('data');

            foreach ($data_barang as $barang) {
                $penjualan->details()->create([
                    'barang_id' => $barang[0]['barang_id'],
                    'jumlah' => $barang[0]['jumlah'],
                    'harga' => $barang[0]['harga'],
                    'total_harga' => $barang[0]['total_harga']
                ]);

                // create Transaksi
                $kode = BarangKeluar::getNewCode();
                BarangKeluar::create([
                    'uuid' => \Str::uuid(),
                    'kode' => $kode,
                    'barang_id' => $barang[0]['barang_id'],
                    'jumlah' => $barang[0]['jumlah'],
                    'keterangan' => 'Dari Penjualan'
                ]);

                // kurangi stok
                $produk = Barang::find($barang[0]['barang_id']);
                $produk->decrement('stok', $barang[0]['jumlah']);
            }

            // update total harga
            $penjualan->update([
                'total_harga' => $penjualan->details->sum('total_harga')
            ]);

            $this->cekMinimalStok();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transaksi berhasil dibuat!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;

            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show($invoice)
    {
        $item = Transaksi::where('invoice', $invoice)->firstOrFail();
        return view('admin.pages.transaksi.show', [
            'title' => 'Detail Penjualan',
            'item' => $item
        ]);
    }

    public function cekMinimalStok()
    {
        $barangs = barang::latest()->get();
        $wa = new WhatsappService();
        foreach ($barangs as $barang) {
            if ($barang->stok_minimal >= $barang->stok) {
                // kirim notifikasi
                $wa->stokMenipis($barang->id);
            }
        }
    }

    public function laporan()
    {
        return view('admin.pages.transaksi.laporan', [
            'title' => 'Laporan Transaksi'
        ]);
    }

    public function print()
    {
        $dari = request('dari');
        $sampai = request('sampai');

        $items = Transaksi::with('details');
        if ($dari && $sampai) {
            $items->whereBetween('created_at', [$dari, $sampai]);
        } elseif ($dari && !$sampai) {
            $items->whereDate('created_at', $dari);
        } else {
            $items->whereNotNull('id');
        }

        $data = $items->latest()->get();
        $pdf = Pdf::loadView('admin.pages.transaksi.print', [
            'data' => $data
        ]);
        return $pdf->download('laporan-transaksi.pdf');
    }
}
