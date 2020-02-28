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
            'name' => 'テストユーザー',
            'email' => 'mikan.sup.all@gmail.com',
            'password' => bcrypt('password'), // パスワードをハッシュ化している
            'created_at' => Carbon::now(), // 現在時刻を取得できる
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'かんきつさん',
            'email' => 'test01@mail.com',
            'password' => bcrypt('password'), // パスワードをハッシュ化している
            'created_at' => Carbon::now(), // 現在時刻を取得できる
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'しまなみさん',
            'email' => 'test02@mail.com',
            'password' => bcrypt('password'), // パスワードをハッシュ化している
            'created_at' => Carbon::now(), // 現在時刻を取得できる
            'updated_at' => Carbon::now(),
        ],
        [
            'name' => 'しまなみさん',
            'email' => 'test03@mail.com',
            'password' => bcrypt('password'), // パスワードをハッシュ化している
            'created_at' => Carbon::now(), // 現在時刻を取得できる
            'updated_at' => Carbon::now(),
        ],
    ]);
}
}
