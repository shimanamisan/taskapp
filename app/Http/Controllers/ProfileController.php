<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileNameRequest;
use App\Http\Requests\ProfileEmailRequest;
use App\Http\Requests\ProfileImageRequest;
use Illuminate\Support\Facades\Auth; // 追加
use App\Http\Requests\ProfilePasswordRequest;

class ProfileController extends Controller
{

    protected $user;

    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth');
        
    }

    // プロフィール写真を更新
    public function ProfileImageEdit(ProfileImageRequest $request)
    {
       
        // フォームリクエストされてきたファイル名を取得する
        // profilePhotoはvue側で指定した key:value のkeyを指定している
        $file_name = $request->profilePhoto->getClientOriginalName();

        // storage/app/public/profile_imgフォルダへ保存
        $request->profilePhoto->storeAs('public/profile_img',$file_name);

        // 認証済みのユーザーでテーブルへ保存
        Auth::user()->update(['pic' => '/storage/profile_img/'.$file_name]);
        
        // 認証済みユーザー情報を返却
        return Auth::user();        
    }

    // ユーザー名を更新
    public function ProfileNameEdit(ProfileNameRequest $request)
    {
        Auth::user()->update([
            'name' => $request->input('name')
        ]);

        // 認証済みユーザー情報を返却
        return Auth::user(); 
    }

    // Emailを更新
    public function ProfileEmailEdit(ProfileEmailRequest $request)
    {   

        Auth::user()->update([
            'email' => $request->input('email')
        ]);

        // 認証済みユーザー情報を返却
        return Auth::user(); 
    }

    // パスワードを更新
    public function ProfilPasswordeEdit(ProfilePasswordRequest $request)
    {
    
        // password と password_confirmation のバリデーションはリクエストコントローラで行っている
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();

    }

    // ユーザー削除（論理削除）
    public function userSoftDelete(Request $request, $id)
    {
        // DBファサードではなく、Eloquent ORM にてdelete()メソッドを実行する事
        // https://www.ritolab.com/entry/53#environment_development
        $user = User::find($id);
        
        if($user->delete_flg === 0){
            $user->delete_flg = 1;
            $user->save();
            // これでログアウト処理
            Auth::logout();
            // ヘルパ関数を利用。セッションをクリア＆セッションIDを再発行(Illuminate\Session\Store::invalidate)
            $request->session()->invalidate();
            // 次回フォームで認証エラーが出ないようにcsrfトークンをリフレッシュ
            $request->session()->regenerateToken();

            return response()->json();
        }
    }
}
