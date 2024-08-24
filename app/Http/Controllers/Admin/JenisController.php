<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }


    public function index()
    {
        $items = Jenis::orderBy('nama', 'ASC')->get();
        return view('admin.pages.jenis.index', [
            'title' => 'Jenis',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('admin.pages.jenis.create', [
            'title' => 'Tambah Jenis'
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required', 'unique:jenis,nama'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            Jenis::create($data);

            DB::commit();
            return redirect()->route('admin.jenis.index')->with('success', 'Jenis berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Jenis::FindOrFail($id);
        return view('admin.pages.jenis.edit', [
            'title' => 'Edit Jenis',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required', 'unique:jenis,nama,' . $id . ''],
        ]);

        DB::beginTransaction();
        try {
            $item = Jenis::findOrFail($id);
            $data = request()->only(['nama']);
            $item->update($data);

            DB::commit();
            return redirect()->route('admin.jenis.index')->with('success', 'Jenis berhasil diupdate.');
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
            $item = Jenis::FindOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('admin.jenis.index')->with('success', 'Jenis berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
