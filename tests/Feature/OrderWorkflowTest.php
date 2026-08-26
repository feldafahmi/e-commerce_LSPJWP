<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_view_only_their_orders_and_upload_payment_proof(): void
    {
        Storage::fake('public');
        $buyer = User::factory()->create();
        $otherBuyer = User::factory()->create();
        $seller = User::factory()->create(['role' => 'penjual']);
        $order = $this->createOrder($buyer, $seller, 'menunggu_bayar');
        $otherOrder = $this->createOrder($otherBuyer, $seller, 'menunggu_bayar');

        $this->actingAs($buyer)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertDontSee($otherOrder->order_number);
        $this->actingAs($buyer)->get(route('orders.show', $otherOrder))->assertNotFound();

        $this->actingAs($buyer)->post(route('orders.payment-proof.store', $order), [
            'payment_proof' => UploadedFile::fake()->image('proof.jpg'),
        ])->assertRedirect();

        $order->refresh();
        $this->assertSame('menunggu_konfirmasi', $order->status);
        Storage::disk('public')->assertExists($order->payment_proof);
    }

    public function test_seller_can_transition_their_order_and_cannot_access_another_sellers_order(): void
    {
        $seller = User::factory()->create(['role' => 'penjual']);
        $otherSeller = User::factory()->create(['role' => 'penjual']);
        $buyer = User::factory()->create();
        $order = $this->createOrder($buyer, $seller, 'menunggu_konfirmasi');
        $otherOrder = $this->createOrder($buyer, $otherSeller, 'menunggu_konfirmasi');

        $this->actingAs($seller)->get(route('seller.orders.show', $otherOrder))->assertNotFound();

        $this->actingAs($seller)->post(route('seller.orders.confirm', $order))->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'diproses']);
        $this->actingAs($seller)->post(route('seller.orders.ship', $order))->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'dikirim']);
        $this->actingAs($seller)->post(route('seller.orders.complete', $order))->assertRedirect();
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'selesai']);
    }

    public function test_payment_proof_requires_an_image(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create(['role' => 'penjual']);
        $order = $this->createOrder($buyer, $seller, 'menunggu_bayar');

        $this->actingAs($buyer)
            ->post(route('orders.payment-proof.store', $order), ['payment_proof' => UploadedFile::fake()->create('proof.pdf', 100, 'application/pdf')])
            ->assertSessionHasErrors('payment_proof');
    }

    private function createOrder(User $buyer, User $seller, string $status): Order
    {
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Test Product',
            'price' => 10000,
            'stock' => 5,
            'status' => 'tersedia',
        ]);
        $order = Order::create([
            'order_number' => 'ORD-'.fake()->unique()->numerify('######'),
            'buyer_id' => $buyer->id,
            'total_price' => 10000,
            'status' => $status,
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

        return $order;
    }
}
