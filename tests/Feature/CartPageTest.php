<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_page_is_available(): void
    {
        $buyer = User::factory()->create();

        $this->actingAs($buyer)->get(route('cart'))
            ->assertOk()
            ->assertSee('KERANJANG ANDA')
            ->assertSee('Ringkasan Pesanan')
            ->assertSee('Lanjut ke Checkout');
    }

    public function test_guest_and_seller_cannot_use_buyer_cart(): void
    {
        $this->get(route('cart'))->assertRedirect(route('login'));
        $seller = User::factory()->create(['role' => 'penjual']);

        $this->actingAs($seller)->get(route('cart'))->assertForbidden();
    }

    public function test_buyer_can_add_update_and_remove_a_cart_item(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create(['role' => 'penjual']);
        $product = Product::create(['seller_id' => $seller->id, 'name' => 'Tee', 'price' => 10000, 'stock' => 5, 'status' => 'tersedia']);

        $this->actingAs($buyer)->post(route('cart.add', $product), ['quantity' => 2])->assertRedirect(route('cart'));
        $item = $buyer->cart->items()->first();
        $this->actingAs($buyer)->patch(route('cart.update', $item), ['quantity' => 3])->assertRedirect();
        $this->assertDatabaseHas('cart_items', ['id' => $item->id, 'quantity' => 3]);
        $this->actingAs($buyer)->delete(route('cart.remove', $item))->assertRedirect();
        $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
    }
}
