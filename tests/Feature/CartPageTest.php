<?php

namespace Tests\Feature;

use Tests\TestCase;

class CartPageTest extends TestCase
{
    public function test_cart_page_is_available(): void
    {
        $this->get(route('cart'))
            ->assertOk()
            ->assertSee('KERANJANG ANDA')
            ->assertSee('Ringkasan Pesanan')
            ->assertSee('Lanjut ke Checkout');
    }
}
