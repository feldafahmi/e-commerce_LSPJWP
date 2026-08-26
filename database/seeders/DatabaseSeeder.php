<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $seller = User::updateOrCreate(['email' => 'seller@example.com'], [
            'name' => 'SHOP.CO Seller',
            'role' => 'penjual',
            'status' => 'aktif',
            'password' => 'password123',
        ]);

        $buyer = User::updateOrCreate(['email' => 'buyer@example.com'], [
            'name' => 'SHOP.CO Buyer',
            'role' => 'pembeli',
            'status' => 'aktif',
            'password' => 'password123',
        ]);

        $categories = collect([
            ['name' => 'Apparel', 'slug' => 'apparel'],
            ['name' => 'Footwear', 'slug' => 'footwear'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
        ])->mapWithKeys(fn (array $category): array => [
            $category['slug'] => Category::updateOrCreate(['slug' => $category['slug']], $category),
        ]);

        $products = [
            ['name' => 'Heavyweight Oversized Tee', 'category_id' => $categories['apparel']->id, 'price' => 449000, 'stock' => 124, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=500&q=85'],
            ['name' => 'Minimalist Low-Top Sneaker', 'category_id' => $categories['footwear']->id, 'price' => 899000, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=500&q=85'],
            ['name' => 'Urban Utility Backpack', 'category_id' => $categories['aksesoris']->id, 'price' => 525000, 'stock' => 5, 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=500&q=85'],
            ['name' => 'Essential Pullover Hoodie', 'category_id' => $categories['apparel']->id, 'price' => 649000, 'stock' => 89, 'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=500&q=85'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['seller_id' => $seller->id, 'name' => $product['name']], [...$product, 'seller_id' => $seller->id, 'status' => 'tersedia']);
        }

        $product = Product::where('seller_id', $seller->id)->firstOrFail();
        $order = Order::updateOrCreate(['order_number' => 'ORD-1092'], [
            'buyer_id' => $buyer->id,
            'total_price' => $product->price,
            'status' => 'diproses',
            'recipient_name' => $buyer->name,
            'phone' => '08123456789',
            'shipping_address' => 'Jl. Marketplace No. 1',
            'city' => 'Jakarta',
            'postal_code' => '10110',
        ]);

        OrderItem::updateOrCreate(['order_id' => $order->id, 'product_id' => $product->id], [
            'seller_id' => $seller->id,
            'product_name' => $product->name,
            'unit_price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);
    }
}
