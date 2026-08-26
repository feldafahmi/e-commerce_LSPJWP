<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CatalogAndSellerCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_can_search_and_filter_products(): void
    {
        $seller = User::factory()->create(['role' => 'penjual']);
        $category = Category::create(['name' => 'Apparel', 'slug' => 'apparel']);
        Product::create(['seller_id' => $seller->id, 'category_id' => $category->id, 'name' => 'Linen Shirt', 'price' => 100000, 'stock' => 2, 'status' => 'tersedia']);
        Product::create(['seller_id' => $seller->id, 'name' => 'Hidden Item', 'price' => 100000, 'stock' => 2, 'status' => 'habis']);

        $this->get(route('home', ['q' => 'Linen']))->assertOk()->assertSee('Linen Shirt')->assertDontSee('Hidden Item');
        $this->get(route('categories.show', $category))->assertOk()->assertSee('Linen Shirt');
    }

    public function test_seller_can_create_update_and_delete_owned_product(): void
    {
        Storage::fake('public');
        $seller = User::factory()->create(['role' => 'penjual']);
        $category = Category::create(['name' => 'Apparel', 'slug' => 'apparel']);
        $payload = ['category_id' => $category->id, 'name' => 'New Tee', 'description' => 'Soft cotton', 'price' => 120000, 'stock' => 4, 'status' => 'tersedia', 'image' => UploadedFile::fake()->image('tee.jpg')];

        $this->actingAs($seller)->post(route('seller.products.store'), $payload)->assertRedirect(route('seller.products'));
        $product = Product::firstOrFail();
        $this->assertSame($seller->id, $product->seller_id);
        Storage::disk('public')->assertExists($product->image);

        $this->actingAs($seller)->put(route('seller.products.update', $product), [...$payload, 'name' => 'Updated Tee', 'image' => null])->assertRedirect(route('seller.products'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Tee']);
        $this->actingAs($seller)->delete(route('seller.products.destroy', $product))->assertRedirect(route('seller.products'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_buyer_cannot_access_seller_crud(): void
    {
        $buyer = User::factory()->create(['role' => 'pembeli']);

        $this->actingAs($buyer)->get(route('seller.products'))->assertForbidden();
    }
}
