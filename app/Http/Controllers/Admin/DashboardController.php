<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{

    public function index()
    {
        $count = [
            'transaksi_hari_ini' => Transaksi::whereDate('created_at', Carbon::now())->sum('total_harga'),
            'barang_masuk' => Transaksi::whereDate('created_at', Carbon::now())->count(),
            'barang_keluar' => Transaksi::whereDate('created_at', Carbon::now())->count(),
        ];
        return view('admin.pages.dashboard', [
            'title' => 'Dashboard',
            'count' => $count
        ]);
    }
}
