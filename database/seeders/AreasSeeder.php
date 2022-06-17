<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("エリアのマスタ作成を開始します...");
        $areasSplFileObject = new \SplFileObject(__DIR__ . '/data/areas.csv');
        $areasSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach ($areasSplFileObject as $key => $row) {
            if ($key === 0) {
                continue;
            }
            $enc_line = mb_convert_encoding($row, 'UTF-8', 'SJIS');
            Area::create([
                'area_name' => trim($enc_line[0]),
                'display_order' => trim($enc_line[1]),
                'created_at' => trim($enc_line[2]),
            ]);
            $count++;
        }
        $this->command->info("エリアのマスタを{$count}件、作成しました。");
    }
}
