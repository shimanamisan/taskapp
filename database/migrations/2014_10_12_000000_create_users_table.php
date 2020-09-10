<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('pic')->nullable()->comment('Twitterアカウントに設定されているプロフィール画像');
            $table->string('my_twitter_id')->nullable()->comment('SNS認証した際に入る、SNS側のユーザー固有のID');
            $table->string('twitter_token')->nullable()->comment('SNS認証した際に入る、SNS側のユーザー固有のトークン');
            $table->string('twitter_token_secret')->nullable()->comment('SNS認証した際に入る、SNS側のユーザー固有のシークレットトークン');
            $table->boolean('delete_flg')->default(false)->comment('退会機能用のフラグ');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
