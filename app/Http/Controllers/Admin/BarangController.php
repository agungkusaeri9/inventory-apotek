<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Jenis;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{

    public function __construct()
    {
        $this->middleware('isAdmin')->only(['create', 'edit', 'destroy']);
    }
    public function index()
    {
        $items = Barang::with(['jenis', 'satuan'])->orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang.index', [
            'title' => 'Barang',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_satuan = Satuan::orderBy('nama', 'ASC')->get();
        $data_jenis = Jenis::orderBy('nama', 'ASC')->get();
        $kode_baru = Barang::getNewCode();
        return view('admin.pages.barang.create', [
            'title' => 'Tambah Barang',
            'data_jenis' => $data_jenis,
            'data_satuan' => $data_satuan,
            'kode_baru' => $kode_baru
        ]);
    }

    public function store()
    {
        request()->validate([
            'gambar' => ['image', 'mimes:png,jpg,jpeg', 'max:2028'],
            'nama' => ['required'],
            'jenis_id' => ['required', 'numeric'],
            'satuan_id' => ['required', 'numeric'],
            'stok_awal' => ['required', 'numeric'],
            'stok_minimal' => ['required', 'numeric'],
            'deskripsi' => ['required'],
            'harga' => ['required'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama', 'jenis_id', 'satuan_id', 'stok_awal', 'stok_minimal', 'deskripsi', 'harga']);
            if (request()->file('gambar')) {
                $data['gambar'] = request()->file('gambar')->store('barang', 'public');
            }
            $data['kode'] = Barang::getNewCode();
            $data['stok'] = request('stok_awal');
            Barang::create($data);

            DB::commit();
            return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Barang::FindOrFail($id);
        $data_satuan = Satuan::orderBy('nama', 'ASC')->get();
        $data_jenis = Jenis::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang.edit', [
            'title' => 'Edit Barang',
            'item' => $item,
            'data_jenis' => $data_jenis,
            'data_satuan' => $data_satuan
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'gambar' => ['image', 'mimes:png,jpg,jpeg', 'max:2028'],
            'nama' => ['required'],
            'jenis_id' => ['required', 'numeric'],
            'satuan_id' => ['required', 'numeric'],
            'stok_minimal' => ['required', 'numeric'],
            'deskripsi' => ['required'],
            'harga' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            $item = Barang::findOrFail($id);
            $data = request()->only(['nama', 'jenis_id', 'satuan_id', 'stok_minimal', 'deskripsi', 'harga']);
            if (request()->file('gambar')) {
                Storage::disk('public')->delete($item->gambar);
                $data['gambar'] = request()->file('gambar')->store('barang', 'public');
            }
            $item->update($data);

            DB::commit();
            return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diupdate.');
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
            $item = Barang::FindOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getByIdJson()
    {
        if (request()->ajax()) {
            $item = Barang::with(['jenis', 'satuan'])->find(request('barang_id'));
            if ($item) {
                return response()->json([
                    'status' => true,
                    'data' => $item
                ], 200);
            } else {
                return  response()->json([
                    'status' => false,
                    'data' => NULL
                ], 403);
            }
        }
    }
}
