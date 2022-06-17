<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class areaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::truncate();
        DB::insert('insert into areas (`id`, `area_name`, `display_order`, `created_at`, `updated_at`, `deleted_at`) values (?, ?)', [1, 'Dayle']);
        // Area::create([
        //     'area_name' => '北海道',
        //     'display_order' => '1',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);
        // Area::create([
        //     'area_name' => '青森県',
        //     'display_order' => '2',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);
    }
}
