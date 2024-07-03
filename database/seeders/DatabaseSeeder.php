<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('item_groups')->insert([
            'name' => 'Item',
        ]);

        DB::table('items')->insert([
            'name' => 'Fita Crepe 19x50MM',
            'item_group_id' => 1,
            'price' => 4730,
            'sale_price' => 4998,
            'iventory_item' => true,
            'sale_item' => true,
            'purchase_item' => false,
            'measurement_unit_id' => 1,
        ]);

        DB::table('measurement_units')->insert([
            'name' => 'Quantidade',
            'abbreviation' => 'Qtd',
        ]);

        DB::table('inventories')->insert([
            'item_id' => 1,
            'quantity' => 50,
        ]);
    }
}
