<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("タグのマスタ作成を開始します...");
        $tagSplFileObject = new \SplFileObject(__DIR__ . '/data/tags.csv');
        $tagSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach ($tagSplFileObject as $key => $row) {
            if ($key === 0) {
                continue;
            }
            $enc_line = mb_convert_encoding($row, 'UTF-8', 'SJIS');
            Tag::create([
                'category_id' => trim($enc_line[0]),
                'tag_name' => trim($enc_line[1]),
                'created_at' => trim($enc_line[2]),
            ]);
            $count++;
        }
        $this->command->info("タグのマスタを{$count}件、作成しました。");
    }
}
