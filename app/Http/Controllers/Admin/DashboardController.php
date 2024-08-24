<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{

    public function index()
    {
        $count = [
            'user' => User::count()
        ];
        return view('admin.pages.dashboard', [
            'title' => 'Dashboard',
            'count' => $count
        ]);
    }
}
