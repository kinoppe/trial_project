<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct()
    {
        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        return Product::create([
            'user_id' => $seller->id,
            'name' => '購入テスト商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);
    }

    public function test_user_can_purchase_product()
    {
        $user = User::create([
            'name' => 'buyer',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = $this->createProduct();

        session([
            'purchase_data.' . $product->id => [
                'user_id' => $user->id,
                'product_id' => $product->id,
                'payment_method' => 2,
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区',
                'building' => 'テストビル',
            ]
        ]);

        $this->actingAs($user)->get('/purchase/success/' . $product->id);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_purchased_product_displays_sold_label()
    {
        $user = User::create([
            'name' => 'buyer',
            'email' => 'buyer2@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = $this->createProduct();

        session([
            'purchase_data.' . $product->id => [
                'user_id' => $user->id,
                'product_id' => $product->id,
                'payment_method' => 2,
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区',
                'building' => 'テストビル',
            ]
        ]);

        $this->actingAs($user)->get('/purchase/success/' . $product->id);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    public function test_purchased_product_is_displayed_on_mypage_buy_tab()
    {
        $user = User::create([
            'name' => 'buyer',
            'email' => 'buyer3@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = $this->createProduct();

        session([
            'purchase_data.' . $product->id => [
                'user_id' => $user->id,
                'product_id' => $product->id,
                'payment_method' => 2,
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区',
                'building' => 'テストビル',
            ]
        ]);

        $this->actingAs($user)->get('/purchase/success/' . $product->id);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertSee('購入テスト商品');
    }

    public function test_changed_address_is_saved_with_purchase()
    {
        $user = User::create([
            'name' => 'buyer',
            'email' => 'buyer5@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = $this->createProduct();

        $this->actingAs($user)->post('/purchase/address/' . $product->id, [
            'postal_code' => '999-9999',
            'address' => '大阪府大阪市',
            'building' => '変更ビル',
        ]);

        session([
            'purchase_data.' . $product->id => [
                'user_id' => $user->id,
                'product_id' => $product->id,
                'payment_method' => 2,
                'postal_code' => '999-9999',
                'address' => '大阪府大阪市',
                'building' => '変更ビル',
            ]
        ]);

        $this->actingAs($user)->get('/purchase/success/' . $product->id);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'postal_code' => '999-9999',
            'address' => '大阪府大阪市',
            'building' => '変更ビル',
        ]);
    }
}
