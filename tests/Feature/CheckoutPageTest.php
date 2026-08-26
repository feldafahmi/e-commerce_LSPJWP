<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_page_is_available(): void
    {
        $buyer = User::factory()->create();
        $this->actingAs($buyer)->get(route('checkout'))->assertRedirect(route('cart'));
        $seller = User::factory()->create(['role' => 'penjual']);
        $product = Product::create(['seller_id' => $seller->id, 'name' => 'Tee', 'price' => 10000, 'stock' => 5, 'status' => 'tersedia']);
        $cart = Cart::create(['buyer_id' => $buyer->id]);
        $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);

        $this->actingAs($buyer)->get(route('checkout'))
            ->assertOk()
            ->assertSee('CHECKOUT')
            ->assertSee('Alamat Pengiriman')
            ->assertSee('Metode Pembayaran')
            ->assertSee('Buat Pesanan');
    }

    public function test_checkout_rejects_insufficient_stock(): void
    {
        [$buyer, $product] = $this->cartWithProduct(1, 3);

        $this->actingAs($buyer)->post(route('checkout.store'), $this->addressData())->assertStatus(422);
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock' => 1]);
    }

    public function test_checkout_splits_orders_and_uses_server_totals(): void
    {
        $buyer = User::factory()->create();
        $sellerOne = User::factory()->create(['role' => 'penjual']);
        $sellerTwo = User::factory()->create(['role' => 'penjual']);
        $first = Product::create(['seller_id' => $sellerOne->id, 'name' => 'First', 'price' => 10000, 'stock' => 5, 'status' => 'tersedia']);
        $second = Product::create(['seller_id' => $sellerTwo->id, 'name' => 'Second', 'price' => 25000, 'stock' => 5, 'status' => 'tersedia']);
        $cart = Cart::create(['buyer_id' => $buyer->id]);
        $cart->items()->createMany([['product_id' => $first->id, 'quantity' => 2], ['product_id' => $second->id, 'quantity' => 1]]);

        $this->actingAs($buyer)->post(route('checkout.store'), [...$this->addressData(), 'recipient_name' => 'Buyer'])->assertRedirect(route('home'));
        $this->assertDatabaseCount('orders', 2);
        $this->assertDatabaseHas('orders', ['buyer_id' => $buyer->id, 'total_price' => 20000]);
        $this->assertDatabaseHas('orders', ['buyer_id' => $buyer->id, 'total_price' => 25000]);
        $this->assertDatabaseHas('products', ['id' => $first->id, 'stock' => 3]);
        $this->assertDatabaseHas('products', ['id' => $second->id, 'stock' => 4]);
        $this->assertDatabaseCount('cart_items', 0);
    }

    private function cartWithProduct(int $stock, int $quantity): array
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create(['role' => 'penjual']);
        $product = Product::create(['seller_id' => $seller->id, 'name' => 'Low stock', 'price' => 10000, 'stock' => $stock, 'status' => 'tersedia']);
        Cart::create(['buyer_id' => $buyer->id])->items()->create(['product_id' => $product->id, 'quantity' => $quantity]);

        return [$buyer, $product];
    }

    private function addressData(): array
    {
        return ['recipient_name' => 'Sari', 'phone' => '08123456789', 'address' => 'Jl. Merdeka 1', 'city' => 'Jakarta', 'postal_code' => '10110'];
    }
}
