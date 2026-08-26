<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = Cart::query()->firstOrCreate(['buyer_id' => $request->user()->id]);
        $cart->load('items.product.seller');
        $subtotal = $cart->items->sum(fn ($item): int => $item->quantity * $item->product->price);

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['nullable', 'integer', 'min:1']]);
        abort_if($product->status !== 'tersedia', 404);

        $cart = Cart::query()->firstOrCreate(['buyer_id' => $request->user()->id]);
        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = ($item->exists ? $item->quantity : 0) + ($validated['quantity'] ?? 1);
        abort_if($item->quantity > $product->stock, 422, 'Jumlah melebihi stok yang tersedia.');
        $item->save();

        return redirect()->route('cart')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, int $item): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $cart = $request->user()->cart;
        abort_if(! $cart, 404);
        $cartItem = $cart->items()->with('product')->findOrFail($item);
        abort_if($validated['quantity'] > $cartItem->product->stock, 422, 'Jumlah melebihi stok yang tersedia.');
        $cartItem->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request, int $item): RedirectResponse
    {
        $cart = $request->user()->cart;
        abort_if(! $cart, 404);
        $cart->items()->findOrFail($item)->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
