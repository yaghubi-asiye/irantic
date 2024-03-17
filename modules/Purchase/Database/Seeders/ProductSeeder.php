<?php

namespace Modules\Purchase\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'test',
                'price' => 10000,
                'quantity' => 10,
            ]
        ]);
    }
}
