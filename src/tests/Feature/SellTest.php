<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_product()
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $response = $this->actingAs($user)->post('/sell', [
            'image' => UploadedFile::fake()->create('product.jpg', 100, 'image/jpeg'),
            'categories' => [$category->id],
            'condition' => '良好',
            'name' => '出品テスト商品',
            'brand_name' => 'テストブランド',
            'description' => '商品の説明です',
            'price' => 3000,
        ]);

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'name' => '出品テスト商品',
            'brand_name' => 'テストブランド',
            'description' => '商品の説明です',
            'condition' => '良好',
            'price' => 3000,
        ]);

        $product = Product::where('name', '出品テスト商品')->first();

        $this->assertDatabaseHas('product_categories', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);
    }
}
