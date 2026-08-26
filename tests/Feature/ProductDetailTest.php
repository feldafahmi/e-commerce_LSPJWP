<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    public function test_product_detail_page_is_available(): void
    {
        $this->get(route('products.show', ['product' => 1]))
            ->assertOk()
            ->assertSee('KEMEJA LINEN SANTAI')
            ->assertSee('Tambah ke Keranjang')
            ->assertSee('MUNGKIN ANDA SUKA');
    }
}
