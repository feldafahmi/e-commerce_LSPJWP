<?php

namespace Tests\Feature;

use Tests\TestCase;

class CheckoutPageTest extends TestCase
{
    public function test_checkout_page_is_available(): void
    {
        $this->get(route('checkout'))
            ->assertOk()
            ->assertSee('CHECKOUT')
            ->assertSee('Alamat Pengiriman')
            ->assertSee('Metode Pembayaran')
            ->assertSee('Buat Pesanan');
    }
}
