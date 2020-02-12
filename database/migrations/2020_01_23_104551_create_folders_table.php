<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 20);
            // unsigned()：整数カラムを符号なしに設定(MySQLのみ)：外部キーを付けていたらこれだとエラーになる、unsignedBigInteger()へ変更
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // 外部制約キーを追加
            // foldersテーブルのuser_idカラムに紐づくものは、usersテーブルの'idカラム'であることを設定している
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folders');
    }
}
