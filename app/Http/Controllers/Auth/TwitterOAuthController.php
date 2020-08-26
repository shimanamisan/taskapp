<?php

namespace App\Http\Controllers\Auth;

use App\User; // 追加
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth; // 追加

class TwitterOAuthController extends Controller
{
    public function redirectToTwitter(): JsonResponse // 返り値の方をJSON形式と宣言する PHP7から返り値に型宣言がかけるようになった
    {
        // リダイレクトURLをJSON形式で返す
        $redirect_url = Socialite::driver('twitter')->redirect()->getTargetUrl();
        \Log::debug('リダイレクトURLを取得しています。。。');
        \Log::debug('    ');
        return response()->json(['redirect_url' => $redirect_url]);
    }

    public function handleTwitterCallback(): JsonResponse // 返り値の方をJSON形式と宣言する PHP7から返り値に型宣言がかけるようになった
    {
        try {
            $socialUser = Socialite::driver('twitter')->user();
    
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
            \Log::debug('SNS認証中にエラーが発生しました。'. $e->getMessage());
            \Log::debug('   ');
            return $this->errorResponse("エラーが発生しました。しばらく経過した後、再度SNS認証を行ってください。");
        }

        Auth::login($user);
        return response()->json($user);
    }

    protected function errorResponse(String $error_message): Jsonresponse // 返り値の方をJSON形式と宣言する PHP7から返り値に型宣言がかけるようになった
    {
        return response()->json(compact('error_message'), 422);
    }
}
