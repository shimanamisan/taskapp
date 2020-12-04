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
    public function redirectToTwitter(): JsonResponse
    {
        // 返り値の方をJSON形式と宣言する PHP7から返り値に型宣言がかけるようになった
        // リダイレクトURLをJSON形式で返す
        $redirect_url = Socialite::driver("twitter")
            ->redirect()
            ->getTargetUrl();
        \Log::debug("リダイレクトURLを取得しています。。。" . $redirect_url);
        \Log::debug("    ");
        return response()->json(["redirect_url" => $redirect_url]);
    }

    public function handleTwitterCallback(): JsonResponse
    {
        // 返り値の方をJSON形式と宣言する PHP7から返り値に型宣言がかけるようになった
        try {
            $socialUser = Socialite::driver("twitter")->user();

            // メールアドレスが未登録の場合は、ユーザー登録していないユーザーと判定する
            $userInfo = User::where("email", $socialUser->getEmail())
                ->where("delete_flg", 0)
                ->first();

            \Log::debug(
                "既に登録済みであれば情報が入っています。 ：" . $userInfo
            );
            \Log::debug("  ");
            \Log::debug(
                "socialUserから情報を取り出しています。 ：" .
                    $socialUser->getEmail()
            );

            // 既にメールアドレスが登録されていて、パスワードが空でなければメールアドレスから登録されている旨を通知する
            if (!empty($userInfo->email_register_flg)) {
                return $this->errorResponse(
                    "Twitterアカウントではなくメールアドレスから登録されたユーザーです。ログインページよりログインしてください。"
                );
            }

            // exists：countメソッドの代わりに使用する。クエリで引っ張ってきたレコードが存在しているか判定する。（類似：doesntExist）
            // https://readouble.com/laravel/5.8/ja/queries.html
            if (!empty($userInfo)) {
                $userInfo->name = $socialUser->getNickname();
                $userInfo->email = $socialUser->getEmail();
                $userInfo->my_twitter_id = $socialUser->getId();
                $userInfo->twitter_token = $socialUser->token;
                $userInfo->twitter_token_secret = $socialUser->tokenSecret;
                $userInfo->pic = $socialUser->getAvatar();
                $userInfo->save();

                Auth::login($userInfo);
                return response()->json($userInfo);
            }

            // 未登録ユーザーだったときの処理
            $newUser = User::create([
                "name" => $socialUser->getNickname(),
                "email" => $socialUser->getEmail(),
                "pic" => $socialUser->getAvatar(),
                "my_twitter_id" => $socialUser->getId(),
                "twitter_token" => $socialUser->token,
                "twitter_token_secret" => $socialUser->tokenSecret,
            ]);

            Auth::login($newUser);
            return response()->json($userInfo);
        } catch (Exception $e) {
            \Log::debug("SNS認証中にエラーが発生しました。" . $e->getMessage());
            \Log::debug("   ");
            return $this->errorResponse(
                "エラーが発生しました。しばらく経過した後、再度SNS認証を行ってください。"
            );
        }

        Auth::login($user);
        return response()->json($user);
    }

    protected function errorResponse(string $error_message): Jsonresponse
    {
        // 返り値の方をJSON形式と宣言する PHP7から返り値に型宣言がかけるようになった
        return response()->json(compact("error_message"), 422);
    }
}
