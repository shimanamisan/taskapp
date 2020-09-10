<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_resets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('メールアドレスを更新したユーザーID');
            $table->string('new_email')->comment('ユーザーが新規に設定したメールアドレス');
            $table->string('token')->comment('認証に使用するトークン');
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
        Schema::dropIfExists('email_resets');
    }
}
