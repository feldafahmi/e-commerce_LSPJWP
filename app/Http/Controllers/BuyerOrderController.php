<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BuyerOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->where('buyer_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        $order = $this->buyerOrder($request, $order)->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function uploadPaymentProof(Request $request, Order $order): RedirectResponse
    {
        $order = $this->buyerOrder($request, $order);

        $validated = $request->validate([
            'payment_proof' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($order->status !== 'menunggu_bayar') {
            return back()->withErrors(['payment_proof' => 'Bukti pembayaran tidak dapat diunggah untuk status pesanan ini.']);
        }

        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        $order->update([
            'payment_proof' => $validated['payment_proof']->store('payment-proofs', 'public'),
            'status' => 'menunggu_konfirmasi',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    private function buyerOrder(Request $request, Order $order): Order
    {
        return Order::query()
            ->where('buyer_id', $request->user()->id)
            ->findOrFail($order->id);
    }
}
