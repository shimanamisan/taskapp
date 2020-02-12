<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/****************************************
ユーザー認証処理
*****************************************/
// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');
// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');
// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// ログインユーザー取得（ログインしているユーザーを返すだけなのでコントローラーは作成しない）、プロフィール一覧でも使う
Route::get('/user', function () {
    return Auth::user();
    })->name('user');

/****************************************
プロフィール変更
*****************************************/
// プロフィール画像
Route::post('/profile/image/{id}', 'ProfileController@ProfileImageEdit')->name('profile.ProfileImageEdit'); // 名前をつけることでview側で効率よくURLを生成できる（SPAでは使用しない？）
// 名前変更
Route::post('/profile/name/{id}', 'ProfileController@ProfileNameEdit')->name('profile.ProfileNameEdit');
// email変更
Route::post('/profile/email/{id}', 'ProfileController@ProfileEmailEdit')->name('profile.ProfileEmailEdit');
// パスワード変更
Route::post('/profile/password/{id}', 'ProfileController@ProfilPasswordeEdit')->name('profile.ProfilPasswordeEdit');
// ユーザー論理削除
Route::delete('/profile/delete/{id}', 'ProfileController@ProfileUserDelete')->name('profile.ProfileUserDelete');

/****************************************
タスク管理
*****************************************/
// フォルダー一覧
Route::get('/folder', 'TaskController@index')->name('folder.index');
// フォルダ登録
Route::post('/folder/add', 'TaskController@folderAdd')->name('folder.folderAdd');

// Route::post('/profile/{id}',function(){
//     dd(request()->all());
//     $file_name = request()->file->getClientOriginalName();
//     // strage/app/public/profile_imgフォルダへ保存
// 	request()->file->storeAs('public/profile_img',$file_name);
// });

// Route::post('/fileupload',function(){
// 	dd(request()->all());
// });
