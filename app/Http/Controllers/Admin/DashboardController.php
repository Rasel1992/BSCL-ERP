<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Inventory;
use App\Models\Stock;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalDept = Department::count();
        $totalStock = Stock::sum('qty');
        $totalInventory= Inventory::sum('qty');
        return view('admin.dashboard', compact('totalUser', 'totalDept', 'totalStock', 'totalInventory'));
    }

    public function application() {
        $users = User::get();
        return view('admin.application', compact('users'));
    }
}
