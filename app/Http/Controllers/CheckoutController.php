<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $cart = Cart::query()->with('items.product.seller')->where('buyer_id', $request->user()->id)->first();
        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->withErrors(['cart' => 'Keranjang Anda masih kosong.']);
        }

        $addresses = $request->user()->addresses()->latest('is_default')->latest()->get();
        $subtotal = $cart->items->sum(fn ($item): int => $item->quantity * $item->product->price);

        return view('checkout.index', compact('cart', 'addresses', 'subtotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address_id' => ['nullable', 'integer', Rule::exists('addresses', 'id')->where('user_id', $request->user()->id)],
            'recipient_name' => ['required_without:address_id', 'nullable', 'string', 'max:255'],
            'phone' => ['required_without:address_id', 'nullable', 'string', 'max:30'],
            'address' => ['required_without:address_id', 'nullable', 'string'],
            'city' => ['required_without:address_id', 'nullable', 'string', 'max:255'],
            'postal_code' => ['required_without:address_id', 'nullable', 'string', 'max:10'],
        ]);

        try {
            $orderIds = DB::transaction(function () use ($request, $validated): array {
                $cart = Cart::query()->where('buyer_id', $request->user()->id)->with('items')->lockForUpdate()->firstOrFail();
                $items = $cart->items->sortBy('product_id');
                abort_if($items->isEmpty(), 422, 'Keranjang Anda masih kosong.');

                $address = $request->user()->addresses()->find($validated['address_id'] ?? null);
                if (! $address) {
                    $address = $request->user()->addresses()->create([
                        'recipient_name' => $validated['recipient_name'],
                        'phone' => $validated['phone'],
                        'address' => $validated['address'],
                        'city' => $validated['city'],
                        'postal_code' => $validated['postal_code'],
                        'is_default' => ! $request->user()->addresses()->exists(),
                    ]);
                }

                $products = Product::query()->whereIn('id', $items->pluck('product_id'))->lockForUpdate()->get()->keyBy('id');
                foreach ($items as $item) {
                    $product = $products->get($item->product_id);
                    abort_if(! $product || $product->status !== 'tersedia' || $product->stock < $item->quantity, 422, "Stok {$product?->name} tidak mencukupi.");
                }

                $orderIds = [];
                foreach ($items->groupBy(fn ($item): int => $products[$item->product_id]->seller_id) as $sellerItems) {
                    $total = $sellerItems->sum(fn ($item): int => $item->quantity * $products[$item->product_id]->price);
                    $order = Order::create([
                        'order_number' => 'ORD-'.Str::upper(Str::random(12)),
                        'buyer_id' => $request->user()->id,
                        'total_price' => $total,
                        'status' => 'menunggu_bayar',
                        'recipient_name' => $address->recipient_name,
                        'phone' => $address->phone,
                        'shipping_address' => $address->address,
                        'city' => $address->city,
                        'postal_code' => $address->postal_code,
                    ]);
                    foreach ($sellerItems as $item) {
                        $product = $products[$item->product_id];
                        $product->decrement('stock', $item->quantity);
                        $order->items()->create([
                            'product_id' => $product->id,
                            'seller_id' => $product->seller_id,
                            'product_name' => $product->name,
                            'unit_price' => $product->price,
                            'quantity' => $item->quantity,
                            'subtotal' => $item->quantity * $product->price,
                        ]);
                    }
                    $orderIds[] = $order->id;
                }
                $cart->items()->delete();

                return $orderIds;
            });
        } catch (Throwable $exception) {
            if ($exception instanceof HttpException) {
                throw $exception;
            }
            report($exception);

            return back()->withErrors(['checkout' => 'Pesanan tidak dapat dibuat. Silakan coba lagi.'])->withInput();
        }

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat ('.count($orderIds).' pesanan).');
    }
}
