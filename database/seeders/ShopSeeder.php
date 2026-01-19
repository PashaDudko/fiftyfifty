<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shops = ['Amazone', '6pm', 'eBay', 'EVO'];

        foreach ($shops as $shop) {
            Shop::factory(1, ['name' => $shop])->create();
        }
    }
}
