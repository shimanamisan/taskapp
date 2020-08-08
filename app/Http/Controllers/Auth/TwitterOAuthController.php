<?php

namespace App\Http\Controllers\Auth;

use App\User; // 追加
use Illuminate\Support\Facades\Auth; // 追加
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class TwitterOAuthController extends Controller
{
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
        // $redirectUrl = Socialite::driver('twitter')->redirect()->getTargetUrl();
        // return response()->json(['redirect_url' => $redirectUrl]);
    }

    public function handleTwitterCallback(Request $request)
    {
        // 認証キャンセルの処理
        if ($request->query('denied')) {
            return redirecr();
        }
        try {
            $socialUser = Socialite::driver('twitter')->userFromTokenAndSecret(env('TWITTER_ACCESS_TOKEN'), env('TWITTER_ACCESS_TOKEN_SECRET'));
            // $socialUser = Socialite::driver('twitter')->user();
    
            // firstOrNew：第一引数にカラム名、第二引数に検索値を入れてデータベースを検索するメソッド
            // このメソッドは保存するにはsave()メソッドを呼ぶ必要がある。（類似：firstOrCreate）
            // https://readouble.com/laravel/5.8/ja/eloquent.html
            $user = User::firstOrNew([
                'email' => $socialUser->getEmail()
            ]);
    
            // exists：countメソッドの代わりに使用する。クエリで引っ張ってきたレコードが存在しているか判定する。（類似：doesntExist）
            // https://readouble.com/laravel/5.8/ja/queries.html
            if ($user->exists) {
                Auth::login($user);
                return response()->json($user);
            }
    
            $user->name = $socialUser->getNickname();
            $user->email = $socialUser->getEmail();
            $user->twitter_token = $socialUser->token;
            $user->twitter_token_secret = $socialUser->tokenSecret;
            $user->pic = $socialUser->getAvatar();
    
            $user->save();
        } catch (Exception $e) {
            return abort(500);
        }

        Auth::login($user);
        return response()->json($user);
    }
}
