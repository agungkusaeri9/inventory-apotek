<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{

    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function index()
    {
        $items = Satuan::orderBy('nama', 'ASC')->get();
        return view('admin.pages.satuan.index', [
            'title' => 'Satuan',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('admin.pages.satuan.create', [
            'title' => 'Tambah Satuan'
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required', 'unique:satuan,nama'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            Satuan::create($data);

            DB::commit();
            return redirect()->route('admin.satuan.index')->with('success', 'Satuan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Satuan::FindOrFail($id);
        return view('admin.pages.satuan.edit', [
            'title' => 'Edit Satuan',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required', 'unique:satuan,nama,' . $id . ''],
        ]);

        DB::beginTransaction();
        try {
            $item = Satuan::findOrFail($id);
            $data = request()->only(['nama']);
            $item->update($data);

            DB::commit();
            return redirect()->route('admin.satuan.index')->with('success', 'Satuan berhasil diupdate.');
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
            $item = Satuan::FindOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('admin.satuan.index')->with('success', 'Satuan berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
