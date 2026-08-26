<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SellerProductController extends Controller
{
    public function create(): View
    {
        return view('seller.products.form', ['product' => new Product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product = new Product($request->safe()->except('image'));
        $product->seller_id = $request->user()->id;
        $product->image = $request->file('image')?->store('products', 'public');
        $product->save();

        return redirect()->route('seller.products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $this->authorizeSellerProduct($product);

        return view('seller.products.form', ['product' => $product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorizeSellerProduct($product);
        $product->fill($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            if ($product->image && ! filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('seller.products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeSellerProduct($product);
        $product->delete();

        return redirect()->route('seller.products')->with('success', 'Produk berhasil dihapus.');
    }

    private function authorizeSellerProduct(Product $product): void
    {
        abort_unless($product->seller_id === auth()->id(), 403);
    }
}
