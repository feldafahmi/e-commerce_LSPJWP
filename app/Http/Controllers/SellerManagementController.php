<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SellerManagementController extends Controller
{
    public function products(): View
    {
        return view('seller.products.index');
    }

    public function orders(): View
    {
        return view('seller.orders.index');
    }
}
