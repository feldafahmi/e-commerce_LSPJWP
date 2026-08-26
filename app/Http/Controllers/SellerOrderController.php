<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerOrderController extends Controller
{
    public function show(Request $request, Order $order): View
    {
        $order = $this->sellerOrder($request, $order);
        $order->load('buyer');
        $items = $order->items()->with('product')->get();

        return view('seller.orders.show', compact('order', 'items'));
    }

    public function confirm(Request $request, Order $order): RedirectResponse
    {
        return $this->transition($request, $order, 'diproses', ['menunggu_konfirmasi']);
    }

    public function reject(Request $request, Order $order): RedirectResponse
    {
        return $this->transition($request, $order, 'dibatalkan', ['menunggu_konfirmasi']);
    }

    public function process(Request $request, Order $order): RedirectResponse
    {
        return $this->transition($request, $order, 'diproses', ['menunggu_konfirmasi']);
    }

    public function ship(Request $request, Order $order): RedirectResponse
    {
        return $this->transition($request, $order, 'dikirim', ['diproses']);
    }

    public function complete(Request $request, Order $order): RedirectResponse
    {
        return $this->transition($request, $order, 'selesai', ['dikirim']);
    }

    private function transition(Request $request, Order $order, string $status, array $allowedStatuses): RedirectResponse
    {
        $order = $this->sellerOrder($request, $order);

        if (! in_array($order->status, $allowedStatuses, true)) {
            return back()->withErrors(['order' => 'Perubahan status pesanan tidak valid.']);
        }

        $order->update(['status' => $status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    private function sellerOrder(Request $request, Order $order): Order
    {
        return Order::query()
            ->whereHas('items', fn ($query) => $query->where('seller_id', $request->user()->id))
            ->findOrFail($order->id);
    }
}
