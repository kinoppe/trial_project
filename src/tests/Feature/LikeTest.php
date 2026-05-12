<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_product()
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
            'name' => 'いいね商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $this->actingAs($user)->post('/item/' . $product->id . '/like');

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->get('/item/' . $product->id);

        $response->assertSee('1');
    }

    public function test_liked_icon_state_is_displayed()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
        ]);

        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => '色変更商品',
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

        $response = $this->actingAs($user)->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee('liked', false);
    }

    public function test_user_can_unlike_product()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'user3@example.com',
            'password' => bcrypt('password'),
        ]);

        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller3@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => '解除商品',
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

        $this->actingAs($user)->delete('/item/' . $product->id . '/like');

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
