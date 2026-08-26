<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_product_management(): void
    {
        $seller = User::factory()->create(['role' => 'penjual']);
        Product::create([
            'seller_id' => $seller->id,
            'name' => 'Heavyweight Oversized Tee',
            'price' => 449000,
            'stock' => 124,
            'status' => 'tersedia',
        ]);

        $this->actingAs($seller)
            ->get(route('seller.products'))
            ->assertOk()
            ->assertSee('MANAJEMEN PRODUK')
            ->assertSee('Heavyweight Oversized Tee');
    }

    public function test_authenticated_user_can_view_order_management(): void
    {
        $seller = User::factory()->create(['role' => 'penjual']);
        $buyer = User::factory()->create(['role' => 'pembeli']);
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Test Product',
            'price' => 449000,
            'stock' => 10,
            'status' => 'tersedia',
        ]);
        $order = Order::create([
            'order_number' => 'ORD-1092',
            'buyer_id' => $buyer->id,
            'total_price' => 449000,
            'status' => 'diproses',
            'recipient_name' => $buyer->name,
            'phone' => '08123456789',
            'shipping_address' => 'Jl. Test No. 1',
            'city' => 'Jakarta',
            'postal_code' => '10110',
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'seller_id' => $seller->id,
            'product_name' => $product->name,
            'unit_price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);

        $this->actingAs($seller)
            ->get(route('seller.orders'))
            ->assertOk()
            ->assertSee('MANAJEMEN ORDER')
            ->assertSee('ORD-1092');
    }

    public function test_guest_cannot_view_seller_management(): void
    {
        $this->get(route('seller.products'))->assertRedirect(route('login'));
        $this->get(route('seller.orders'))->assertRedirect(route('login'));
    }
}
