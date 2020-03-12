<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CradsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          // カード用テストデータ挿入
          $titles = ['PHP', 'CSS', 'JavaScript', 'Laravel', 'HTML', 'jQuery'];
        
          // $titlesに入っている配列の個数回ループが実行され、$titleに分解された値が入る
          foreach($titles as $title){
              DB::table('cards')->insert([
                  'title' => $title,
                  'folder_id' => rand(1, 2),
                  'created_at' => Carbon::now(),
                  'updated_at' => Carbon::now(),
              ]);
          }
    }
}
