<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products =[
            [
                'user_id' => 1,
                'name' => '腕時計',
                'price' => 15000,
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image' => 'products/Armani+Mens+Clock.jpg',
                'condition' => '良好',
                'categories' => [1,5],
            ],
            [
                'user_id' => 1,
                'name' => 'HDD',
                'price' => 5000,
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image' => 'products/HDD+Hard+Disk.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => [2],
            ],
            [
                'user_id' => 1,
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand_name' => null,
                'description' => '新鮮な玉ねぎ3束セット',
                'image' => 'products/iLoveIMG+d.jpg',
                'condition' => 'やや傷や汚れあり',
                'categories' => [10],
            ],
            [
                'user_id' => 1,
                'name' => '革靴',
                'price' => 4000,
                'brand_name' => null,
                'description' => 'クラシックなデザインの革靴',
                'image' => 'products/Leather+Shoes+Product+Photo.jpg',
                'condition' => '状態が悪い',
                'categories' => [1,5],
            ],
            [
                'user_id' => 1,
                'name' => 'ノートPC',
                'price' => 45000,
                'brand_name' => null,
                'description' => '高性能なノートパソコン',
                'image' => 'products/Living+Room+Laptop.jpg',
                'condition' => '良好',
                'categories' => [2],
            ],
            [
                'user_id' => 1,
                'name' => 'マイク',
                'price' => 8000,
                'brand_name' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image' => 'products/Music+Mic+4632231.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => [2],
            ],
            [
                'user_id' => 1,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand_name' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'image' => 'products/Purse+fashion+pocket.jpg',
                'condition' => 'やや傷や汚れあり',
                'categories' => [1,4],
            ],
            [
                'user_id' => 1,
                'name' => 'タンブラー',
                'price' => 500,
                'brand_name' => 'なし',
                'description' => '使いやすいタンブラー',
                'image' => 'products/Tumbler+souvenir.jpg',
                'condition' => '状態が悪い',
                'categories' => [10],
            ],
            [
                'user_id' => 1,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand_name' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image' => 'products/Waitress+with+Coffee+Grinder.jpg',
                'condition' => '良好',
                'categories' => [3,10],
            ],
            [
                'user_id' => 1,
                'name' => 'メイクセット',
                'price' => 2500,
                'brand_name' => null,
                'description' => '便利なメイクアップセット',
                'image' => 'products/外出メイクアップセット.jpg',
                'condition' => '目立った傷や汚れなし',
                'categories' => [1,4,6],
            ],
        ];

        foreach ($products as $data) {
            $categories = $data['categories'];
            unset($data['categories']);

            $product = Product::create($data);

            $product->categories()->sync($categories);
        }
    }
}
