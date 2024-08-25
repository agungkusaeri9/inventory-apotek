<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class BarangMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin')->only(['edit', 'destroy']);
    }
    public function index()
    {
        $barang_id = request('barang_id');
        $tanggal = request('tanggal');
        $items = BarangMasuk::latest();
        // filterisasi
        if ($barang_id)
            $items->where('barang_id', $barang_id);
        if ($tanggal)
            $items->whereDate('created_at', $tanggal);

        $data = $items->get();
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang-masuk.index', [
            'title' => 'Barang Masuk',
            'items' => $data,
            'data_barang' => $data_barang
        ]);
    }

    public function create()
    {
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang-masuk.create', [
            'title' => 'Tambah Barang Masuk',
            'data_barang' => $data_barang
        ]);
    }

    public function store()
    {
        request()->validate([
            'barang_id' => ['required', 'numeric'],
            'jumlah' => ['required', 'min:1', 'numeric']
        ]);

        DB::beginTransaction();
        try {
            $barang = Barang::find(request('barang_id'));
            $data = request()->only(['barang_id', 'jumlah', 'keterangan']);
            $data['uuid'] = \Str::uuid();
            $data['kode'] = BarangMasuk::getNewCode();
            $barang_masuk = BarangMasuk::create($data);
            $barang->increment('stok', request('jumlah'));

            DB::commit();
            return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang Masuk berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = BarangMasuk::with(['barang.satuan', 'barang.jenis'])->FindOrFail($id);
        return view('admin.pages.barang-masuk.edit', [
            'title' => 'Edit Barang Masuk',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'jumlah' => ['required', 'min:1', 'numeric'],
        ]);

        DB::beginTransaction();
        try {
            $item = BarangMasuk::findOrFail($id);
            $data = request()->only(['jumlah', 'keterangan']);
            if ($item->jumlah != request('jumlah')) {
                $item->update([
                    'jumlah' => request('jumlah')
                ]);
                $item->barang->decrement('stok', $item->jumlah);
                // tambahkan stok dengan jumlah terbaru
                $item->barang->increment('stok', request('jumlah'));
            }
            $item->update($data);

            DB::commit();
            return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang Masuk berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = BarangMasuk::with('barang')->FindOrFail($id);
            $item->barang->decrement('stok', $item->jumlah);
            // tambahkan stok barang
            $item->delete();
            DB::commit();
            return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang Masuk berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function laporan()
    {
        return view('admin.pages.barang-masuk.laporan', [
            'title' => 'Laporan barang Masuk'
        ]);
    }

    public function print()
    {
        $dari = request('dari');
        $sampai = request('sampai');

        $items = BarangMasuk::with('barang');
        if ($dari && $sampai) {
            $items->whereBetween('created_at', [$dari, $sampai]);
        } elseif ($dari && !$sampai) {
            $items->whereDate('created_at', $dari);
        } else {
            $items->whereNotNull('id');
        }

        $data = $items->latest()->get();
        $pdf = Pdf::loadView('admin.pages.barang-masuk.print', [
            'data' => $data
        ]);
        return $pdf->download('laporan-barang-masuk.pdf');
    }
}
