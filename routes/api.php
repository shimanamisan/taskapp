<?php

use Illuminate\Http\Request; // トークンリフレッシュで使う
use App\Http\Controllers\Auth\ResetPasswordController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/****************************************
ユーザー認証処理
*****************************************/
// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');
// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');
// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// パスワード再設定メール
Route::post('/password/reminder', 'Auth\ForgotPasswordController@sendResetLinkEmail');
// パスワードリマインダー
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
// twitterログイン
Route::get('/twitter', 'Auth\TwitterOAuthController@redirectToTwitter');
// twitterログインコールバックURL
Route::get('/callback', 'Auth\TwitterOAuthController@handleTwitterCallback');
// ログインユーザー取得（ログインしているユーザーを返すだけなのでコントローラーは作成しない）、プロフィール一覧でも使う
Route::get('/user', function () {
    return Auth::user();
    })->name('user');
/****************************************
csrfトークンをリフレッシュする
*****************************************/
Route::get('/refresh-token', function(Request $request){
    $request->session()->regenerateToken();
    return response()->json();
});


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
Route::delete('/profile/delete/{id}', 'ProfileController@userSoftDelete')->name('profile.userSoftDelete');

/****************************************
タスク管理(一覧・登録)
*****************************************/
// フォルダー一覧
Route::get('/folder', 'FolderController@index')->name('folder.index');
// フォルダ登録
Route::post('/folder/create', 'FolderController@createFolder')->name('folder.createFolder');
// フォルダ更新
Route::put('/folder/{id}/update', 'FolderController@updateFolder')->name('folder.updateFolder');
// フォルダソートの並び替え更新
Route::patch('/folder/update-all', 'FolderController@updateFolderSort')->name('folder.updateFolderSort');
// フォルダ削除
Route::delete('/folder/{folder_id}/delete', 'FolderController@deleteFolder')->name('folder.deleteFolder');
// フォルダ配下のカード取得
Route::get('/folder/{folder_id}/card/set', 'FolderController@selectCrad')->name('folder.selectCrad');

/****************************************
カード管理(更新・削除)
*****************************************/
// カード登録
Route::post('/folder/{folder_id}/card/create', 'CardController@createCard')->name('card.createCard');
// カードの更新
Route::put('/folder/{folder_id}/card/{card_id}/update', 'CardController@updateCard')->name('card.updateCard');
// カードの削除
Route::delete('/folder/{folder_id}/card/{card_id}/delete', 'CardController@deleteCard')->name('card.deleteCard');


/****************************************
タスク管理(更新・削除)
*****************************************/
// タスク登録
Route::post('/folder/{folder_id}/card/{card_id}/task/create', 'TaskController@createTask')->name('task.createTask');
// タスク更新
Route::put('/folder/{folder_id}/card/{card_id}/task/{task_id}/update', 'TaskController@updateTask')->name('task.updateTask');
// タスク列の並び替え更新
Route::put('/task/{id}', 'TaskController@updateTaskDraggable')->name('task.updateTaskDraggable');
// タスクソートの並び替え更新
Route::patch('/task/update-all', 'TaskController@updateTaskSort')->name('task.updateTaskSort');
// タスク削除
Route::delete('/folder/{folder_id}/card/{card_id}/task/{task_id}/delete', 'TaskController@deleteTask')->name('task.deleteTask');

Route::get('/mail', function(){
    return view('mail.html.passwordreset');
});

/****************************************
お問い合わせメール送信
*****************************************/
Route::post('/contact', 'ContactController@postMessage')->name('contact.postMessage');


// Route::post('/profile/{id}',function(){
//     dd(request()->all());
//     $file_name = request()->file->getClientOriginalName();
//     // strage/app/public/profile_imgフォルダへ保存
// 	request()->file->storeAs('public/profile_img',$file_name);
// });

// Route::post('/fileupload',function(){
// 	dd(request()->all());
// });
