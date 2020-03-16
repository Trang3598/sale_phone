<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $total_user = User::all()->count();
        $total_order = Order::all()->count();
        $total_product = Product::all()->count();
        return view('admin.dashboard.dashboard',compact('total_user','total_order','total_product'));
    }

    public function show($id)
    {

    }
}
