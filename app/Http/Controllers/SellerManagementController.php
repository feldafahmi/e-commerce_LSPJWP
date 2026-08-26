<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class SellerManagementController extends Controller
{
    public function products(): View
    {
        $products = Product::query()
            ->with('category')
            ->where('seller_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function orders(): View
    {
        $orders = Order::query()
            ->with('buyer')
            ->whereHas('items', fn (Builder $query): Builder => $query->where('seller_id', auth()->id()))
            ->latest()
            ->paginate(10);

        return view('seller.orders.index', compact('orders'));
    }
}
