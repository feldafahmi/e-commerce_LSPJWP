<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $product): View
    {
        $productModel = Schema::hasTable('products')
            ? Product::query()->with(['category', 'seller', 'images'])->find($product)
            : null;

        abort_if($productModel && $productModel->status !== 'tersedia', 404);

        return view('products.show', ['product' => $productModel]);
    }
}
