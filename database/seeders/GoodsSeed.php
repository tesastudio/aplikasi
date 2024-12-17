<?php

namespace Database\Seeders;

use App\Models\Goods;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoodsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Goods::create([
            'name' => 'Kertas A4 70gr',
            'goods_type' => 'ATK',
            'dept_id' => 0,
            'is_asset' => 0,
            'unit' => 'RIM',
            'qty_onhand' => 20,
            'qty_buffer' => 30,
            'price' => 40000,
        ]);
        Goods::create([
            'name' => 'Kertas A4 80gr',
            'goods_type' => 'ATK',
            'dept_id' => 0,
            'is_asset' => 0,
            'unit' => 'RIM',
            'qty_onhand' => 25,
            'qty_buffer' => 30,
            'price' => 50000,
        ]);
        Goods::create([
            'name' => 'Kertas F4 70gr',
            'goods_type' => 'ATK',
            'dept_id' => 0,
            'is_asset' => 0,
            'unit' => 'RIM',
            'qty_onhand' => 10,
            'qty_buffer' => 9,
            'price' => 55000,

        ]);
        Goods::create([
            'name' => 'Mouse',
            'goods_type' => 'IT',
            'dept_id' => 0,
            'is_asset' => 0,
            'unit' => 'Unit',
            'qty_onhand' => 10,
            'qty_buffer' => 5,
            'price' => 76000,
        ]);
        Goods::create([
            'name' => 'Printer',
            'goods_type' => 'IT',
            'dept_id' => 0,
            'is_asset' => 1,
            'unit' => 'Unit',
            'qty_onhand' => 1,
            'qty_buffer' => 2,
            'price' => 4000000,
        ]);
        Goods::create([
            'name' => 'Amplop',
            'goods_type' => 'ATK',
            'dept_id' => 0,
            'is_asset' => 0,
            'unit' => 'Lembar',
            'qty_onhand' => 100,
            'qty_buffer' => 20,
            'price' => 300,
        ]);
    }
}
