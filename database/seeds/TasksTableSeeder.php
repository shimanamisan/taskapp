<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // カード用テストデータ挿入
        $titles = 
        [
        'ループ処理復習',
        'MySQLも復習',
        'シンタックスエラー減らす',
        'ポートフォリオ作る',
        'ビジネスについてまとめる',
        '買い物をする',
        '今日は特売日',
        'お風呂掃除する',
        '明日までにオムツ買う',
        'JavaScriptの練習をする',
        'ブラウザテストやる',
        'インフラの復習する',
        '職務履歴書作成する'
        ];

        // $titlesに入っている配列の個数回ループが実行され、$titleに分解された値が入る
        foreach($titles as $title){
            DB::table('tasks')->insert([
                'title' => $title,
                'card_id' => rand(1, 2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
