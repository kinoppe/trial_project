<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_post_comment()
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
            'name' => 'コメント商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $response = $this->actingAs($user)->post('/item/' . $product->id . '/comment', [
            'content' => 'テストコメントです',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'テストコメントです',
        ]);

        $response = $this->get('/item/' . $product->id);
        $response->assertSee('テストコメントです');
    }

    public function test_guest_user_cannot_post_comment()
    {
        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => 'コメント商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $this->post('/item/' . $product->id . '/comment', [
            'content' => '未ログインコメント',
        ]);

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'content' => '未ログインコメント',
        ]);
    }

    public function test_comment_is_required()
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
            'name' => 'コメント商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $response = $this->actingAs($user)->post('/item/' . $product->id . '/comment', [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_comment_must_be_255_characters_or_less()
    {
        $user = User::create([
            'name' => 'user',
            'email' => 'user4@example.com',
            'password' => bcrypt('password'),
        ]);

        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller4@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => 'コメント商品',
            'price' => 1000,
            'brand_name' => 'ブランド',
            'description' => '説明文',
            'image' => 'test.jpg',
            'condition' => '良好',
        ]);

        $response = $this->actingAs($user)->post('/item/' . $product->id . '/comment', [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors('content');
    }
}
