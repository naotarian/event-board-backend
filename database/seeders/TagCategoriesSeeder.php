<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TagCategory;

class TagCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("タグカテゴリーのマスタ作成を開始します...");
        $tagCatergoriesSplFileObject = new \SplFileObject(__DIR__ . '/data/tag_categories.csv');
        $tagCatergoriesSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach ($tagCatergoriesSplFileObject as $key => $row) {
            if ($key === 0) {
                continue;
            }
            $enc_line = mb_convert_encoding($row, 'UTF-8', 'SJIS');
            TagCategory::create([
                'category_name' => trim($enc_line[0]),
                'display_order' => trim($enc_line[1]),
                'created_at' => trim($enc_line[2]),
            ]);
            $count++;
        }
        $this->command->info("タグカテゴリーのマスタを{$count}件、作成しました。");
    }
}
