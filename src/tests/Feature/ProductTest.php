<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Like;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_products_are_displayed()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    public function test_sold_product_displays_sold_label()
    {
        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $buyer = User::create([
            'name' => 'buyer',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
            'payment_method' => '2',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    public function test_own_products_are_not_displayed()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => '自分の商品',
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
    }

    public function test_mylist_displays_only_liked_products()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $likedProduct = Product::create([
            'user_id' => $seller->id,
            'name' => 'いいねした商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        Product::create([
            'user_id' => $seller->id,
            'name' => 'いいねしてない商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $likedProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしてない商品');
    }

    public function test_sold_product_displays_sold_label_in_mylist()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => '購入済みいいね商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
            'payment_method' => 2,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('購入済みいいね商品');
        $response->assertSee('Sold');
    }

    public function test_guest_mylist_displays_no_products()
    {
        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'user_id' => $seller->id,
            'name' => '未認証では表示されない商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('未認証では表示されない商品');
    }

    public function test_products_can_be_searched_by_product_name()
    {
        $user = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => 'テストバッグ',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => 'サンプル時計',
            'price' => 2000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $response = $this->get('/?keyword=バッグ');

        $response->assertStatus(200);
        $response->assertSee('テストバッグ');
        $response->assertDontSee('サンプル時計');
    }

    public function test_search_keyword_is_kept_in_mylist()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => 'テストバッグ',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=バッグ');

        $response->assertStatus(200);
        $response->assertSee('テストバッグ');
        $response->assertSee('keyword=バッグ', false);
    }

    public function test_product_detail_displays_required_information()
    {
        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $commentUser = User::create([
            'name' => 'comment_user',
            'email' => 'comment@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => '詳細テスト商品',
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => '商品の説明文です',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $category = Category::create([
            'name' => 'ファッション',
        ]);

        $product->categories()->attach($category->id);

        Like::create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
        ]);

        Comment::create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'content' => 'テストコメントです',
        ]);

        $response = $this->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee('詳細テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('1,000');
        $response->assertSee('商品の説明文です');
        $response->assertSee('良好');
        $response->assertSee('ファッション');
        $response->assertSee('comment_user');
        $response->assertSee('テストコメントです');
    }

    public function test_product_detail_displays_multiple_categories()
    {
        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => 'カテゴリ複数商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $category1 = Category::create(['name' => 'ファッション']);
        $category2 = Category::create(['name' => 'メンズ']);

        $product->categories()->attach([
            $category1->id,
            $category2->id,
        ]);

        $response = $this->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}
