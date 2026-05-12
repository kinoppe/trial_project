<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_mypage_displays_user_information_sell_products_and_buy_products()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'profile_image' => 'profiles/test.jpg',
            'postal_code' => '123-4567',
            'address' => '和歌山県御坊市',
            'building' => 'テストビル',
        ]);

        $sellProduct = Product::create([
            'user_id' => $user->id,
            'name' => '出品した商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'products/sell.jpg',
            'condition' => '良好',
        ]);

        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);

        $buyProduct = Product::create([
            'user_id' => $seller->id,
            'name' => '購入した商品',
            'price' => 2000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'products/buy.jpg',
            'condition' => '良好',
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $buyProduct->id,
            'payment_method' => 2,
            'postal_code' => '123-4567',
            'address' => '和歌山県御坊市',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('profiles/test.jpg');
        $response->assertSee('出品した商品');

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入した商品');
    }

    public function test_profile_edit_page_displays_current_user_information()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'profile_image' => 'profiles/test.jpg',
            'postal_code' => '123-4567',
            'address' => '和歌山県御坊市',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('profiles/test.jpg');
        $response->assertSee('123-4567');
        $response->assertSee('和歌山県御坊市');
    }
}
