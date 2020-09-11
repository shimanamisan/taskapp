<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileNameRequest; // 追加
use App\Http\Requests\ProfileEmailRequest; // 追加
use App\Http\Requests\ProfileImageRequest; // 追加
use App\Http\Requests\ProfilePasswordRequest; // 追加
use Illuminate\Support\Facades\Auth; // 追加

class ProfileController extends Controller
{
    protected $user;

    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth');
    }

    // プロフィール写真を更新
    public function profileImageEdit(ProfileImageRequest $request)
    {
       
        // フォームリクエストされてきたファイル名を取得する
        // profilePhotoはvue側で指定した key:value のkeyを指定している
        $file_name = $request->profilePhoto->getClientOriginalName();

        // storage/app/public/profile_imgフォルダへ保存
        $request->profilePhoto->storeAs('public/profile_img', $file_name);

        // 認証済みのユーザーでテーブルへ保存
        Auth::user()->update(['pic' => '/storage/profile_img/'.$file_name]);
        
        // 認証済みユーザー情報を返却
        return Auth::user();
    }

    // ユーザー名を更新
    public function profileNameEdit(ProfileNameRequest $request)
    {
        Auth::user()->update([
            'name' => $request->input('name')
        ]);

        // 認証済みユーザー情報を返却
        return Auth::user();
    }

    // Emailを更新
    public function profileEmailEdit(ProfileEmailRequest $request)
    {
        Auth::user()->update([
            'email' => $request->input('email')
        ]);

        // 認証済みユーザー情報を返却
        return Auth::user();
    }

    // パスワードを更新
    public function profilPasswordeEdit(ProfilePasswordRequest $request)
    {
    
        // password と password_confirmation のバリデーションはリクエストコントローラで行っている
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();
    }

    // ユーザー削除（物理削除）
    public function userSoftDelete(Request $request, $id)
    {
        try {
            // DBファサードではなく、Eloquent ORM にてdelete()メソッドを実行する事
            // https://www.ritolab.com/entry/53#environment_development
            $user = User::find($id);
            // ログアウト
            Auth::logout();

            // delete_flgが立っていないユーザーを検索
            $userInfo = User::where('email', $user->email)
             ->where('delete_flg', 0)
             ->first();

            // デリートフラグを立てる
            $userInfo->delete_flg = 1;
            // ステータスを保存する
            $userInfo->save();
            
            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return response()->json(['success', '退会しました。ご利用ありがとうございました。'], 200);
        } catch (\Exception $e) {

             // ログアウト
            Auth::logout();
            // セッションを削除
            session()->invalidate();
            // csrfトークンを再生成
            session()->regenerateToken();
            \Log::debug('退会処理時に例外が発生しました。'. $e->getMessage());
 
            return response()->json(['error', 'エラーが発生しました。'], 500);
        }
    }
}
