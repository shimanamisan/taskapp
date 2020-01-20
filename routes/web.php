<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// ルーティングの設定
Route::get('/{app}', function() {
    // APIのURL以外のリクエストに対してはappテンプレートを返す
    return view('app');
    
// 正規表現でどんな文字列が来てもappファイルへリダイレクトするように設定
// この最後の行で、{app}に入るルートパラメータのフォーマットを指定している
})->where('app','.*');