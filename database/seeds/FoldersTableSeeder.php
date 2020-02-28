<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // フォルダ用テストデータ挿入
        $titles = [
        '仕事',
        'プライベート',
        '家族',
        '家事・育児',
        'フィットネス',
        '副業',
        '来週までにやるリスト',
        '今週までにやるリスト',
        'テストフォルダー01',
        'テストフォルダー02',
    ];
        
        // $titlesに入っている配列の個数回ループが実行され、$titleに分解された値が入る
        foreach($titles as $title){
            DB::table('folders')->insert([
                'title' => $title,
                'user_id' => rand(1, 2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
