<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_product_management(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'penjual']))
            ->get(route('seller.products'))
            ->assertOk()
            ->assertSee('MANAJEMEN PRODUK')
            ->assertSee('Heavyweight Oversized Tee');
    }

    public function test_authenticated_user_can_view_order_management(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'penjual']))
            ->get(route('seller.orders'))
            ->assertOk()
            ->assertSee('MANAJEMEN ORDER')
            ->assertSee('#ORD-1092');
    }

    public function test_guest_cannot_view_seller_management(): void
    {
        $this->get(route('seller.products'))->assertRedirect(route('login'));
        $this->get(route('seller.orders'))->assertRedirect(route('login'));
    }
}
