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
タスク管理(一覧・登録)
*****************************************/
// フォルダー一覧
Route::get('/folder', 'TaskController@index')->name('folder.index');
// フォルダ登録
Route::post('/folder/create', 'TaskController@createFolder')->name('folder.createFolder');
// フォルダ更新
Route::put('/folder/{id}/update', 'TaskController@updateFolder')->name('folder.updateFolder');
// フォルダ削除
Route::delete('/folder/{folder_id}/delete', 'TaskController@deleteFolder')->name('folder.deleteFolder');
// フォルダ配下のカード取得
Route::get('/folder/{folder_id}/card/set', 'TaskController@selectCrad')->name('folder.selectCrad');

/****************************************
カード管理(更新・削除)
*****************************************/
// カード登録
Route::post('/folder/{folder_id}/card/create', 'TaskController@createCard')->name('card.createCard');
// カードの更新
Route::put('/folder/{folder_id}/card/{card_id}/update', 'TaskController@updateCard')->name('card.updateCard');
// カードの削除
Route::delete('/folder/{folder_id}/card/{card_id}/delete', 'TaskController@deleteCard')->name('card.deleteCard');


/****************************************
タスク管理(更新・削除)
*****************************************/
// タスク登録
Route::post('/folder/{folder_id}/card/{card_id}/task/create', 'TaskController@createTask')->name('task.createTask');
// タスク更新
Route::put('/folder/{folder_id}/card/{card_id}/task/{task_id}/update', 'TaskController@updateTask')->name('task.updateTask');
// タスク削除
Route::delete('/folder/{folder_id}/card/{card_id}/task/{task_id}/delete', 'TaskController@deleteTask')->name('task.deleteTask');










// Route::post('/profile/{id}',function(){
//     dd(request()->all());
//     $file_name = request()->file->getClientOriginalName();
//     // strage/app/public/profile_imgフォルダへ保存
// 	request()->file->storeAs('public/profile_img',$file_name);
// });

// Route::post('/fileupload',function(){
// 	dd(request()->all());
// });
