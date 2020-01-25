<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
     * @param StorePhoto $request
     * @return \Illuminate\Http\Response
     */
    public function create(StorePhoto $request, User $user)
    {
        $originalImg = $request->user_image;
        
        $filePath = $originalImg->store('public');
        $user->image = str_replace('public/', '', $filePath);
        $user->save();
    
    }

    public function profileview(){

        // ユーザー情報を返却
        // return User::find(1)->all();
        // 認証済みのユーザーを返却
        return Auth::user();
    }
}
