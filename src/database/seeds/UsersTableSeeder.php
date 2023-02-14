<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ユーザーレコードの追加
        DB::table('users')->insert([
        [
            'name' => 'ゲストユーザー',
            'email' => 'test01@mail.com',
            'email_register_flg' => true,
            'password' => bcrypt('password'), // パスワードをハッシュ化している
            'created_at' => Carbon::now(), // 現在時刻を取得できる
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'みかんさん',
            'email' => 'mikan.sup.all@gmail.com',
            'email_register_flg' => true,
            'password' => bcrypt('password'), // パスワードをハッシュ化している
            'created_at' => Carbon::now(), // 現在時刻を取得できる
            'updated_at' => Carbon::now(),
        ],
    ]);
    }
}
