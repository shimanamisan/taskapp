<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth');
        
    }

     /**
     * プロフィール写真投稿
     * @param ProfileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function profileEdit(ProfileRequest $request)
    {
       
        /****************************************
        プロフィール写真編集の処理
        ****************************************/

        // フォームリクエストされてきたファイル名を取得する
        // profilePhotoはvue側で指定した key:value のkeyを指定している
        $file_name = $request->profilePhoto->getClientOriginalName();

        // strage/app/public/profile_imgフォルダへ保存
        $request->profilePhoto->storeAs('public/profile_img',$file_name);

        // 認証済みのユーザーでテーブルへ保存
        Auth::user()->update(['pic' => '/storage/'.$file_name]);

        /****************************************
        ユーザー情報を更新
        ****************************************/

        

        // 認証済みユーザー情報を返却
        return Auth::user();

        
    
    }
}
