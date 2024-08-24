<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barang_id = request('barang_id');
        $tanggal = request('tanggal');
        $items = BarangKeluar::latest();
        // filterisasi
        if ($barang_id)
            $items->where('barang_id', $barang_id);
        if ($tanggal)
            $items->whereDate('created_at', $tanggal);

        $data = $items->get();
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang-keluar.index', [
            'title' => 'Barang Keluar',
            'items' => $data,
            'data_barang' => $data_barang
        ]);
    }

    public function create()
    {
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang-keluar.create', [
            'title' => 'Tambah Barang Keluar',
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
            if ($barang->stok < request('jumlah')) {
                return redirect()->back()->with('error', 'Jumlah terlalu banyak dari stok');
            }
            $data = request()->only(['barang_id', 'jumlah', 'keterangan']);
            $data['uuid'] = \Str::uuid();
            $data['kode'] = BarangKeluar::getNewCode();
            $data['tanggal'] = Carbon::now()->format('Y-m-d');
            $barang_keluar = BarangKeluar::create($data);
            $barang->decrement('stok', request('jumlah'));

            DB::commit();
            return redirect()->route('admin.barang-keluar.index')->with('success', 'Barang Keluar berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = BarangKeluar::with(['barang.satuan', 'barang.jenis'])->FindOrFail($id);
        return view('admin.pages.barang-keluar.edit', [
            'title' => 'Edit Barang Keluar',
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
            $item = BarangKeluar::findOrFail($id);
            $data = request()->only(['jumlah', 'keterangan']);
            if ($item->jumlah != request('jumlah')) {
                $item->update([
                    'jumlah' => request('jumlah')
                ]);
                $item->barang->increment('stok', $item->jumlah);
                // tambahkan stok dengan jumlah terbaru
                $item->barang->decrement('stok', request('jumlah'));
            }
            $item->update($data);

            DB::commit();
            return redirect()->route('admin.barang-keluar.index')->with('success', 'Barang Keluar berhasil diupdate.');
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
            $item = BarangKeluar::with('details.barang')->FindOrFail($id);
            $item->details->barang->increment('stok', $item->details->jumlah);
            // tambahkan stok barang
            $item->delete();
            DB::commit();
            return redirect()->route('admin.barang-keluar.index')->with('success', 'Barang Keluar berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function laporan()
    {
        return view('admin.pages.barang-keluar.laporan', [
            'title' => 'Laporan barang Keluar'
        ]);
    }

    public function print()
    {
        $dari = request('dari');
        $sampai = request('sampai');

        $items = BarangKeluar::with('barang');
        if ($dari && $sampai) {
            $items->whereBetween('created_at', [$dari, $sampai]);
        } elseif ($dari && !$sampai) {
            $items->whereDate('created_at', $dari);
        } else {
            $items->whereNotNull('id');
        }

        $data = $items->latest()->get();
        $pdf = Pdf::loadView('admin.pages.barang-keluar.print', [
            'data' => $data
        ]);
        return $pdf->download('laporan-barang-keluar.pdf');
    }
}
