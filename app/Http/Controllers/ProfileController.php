<?php

namespace App\Http\Controllers;

use App\User; // ★追加
use App\EmailReset; // ★追加
use Carbon\Carbon; // ★追加
use Illuminate\Support\Str; // ★追加
use Illuminate\Support\Facades\Log; // ★追加
use App\Http\Requests\MypageRequest; // ★追加
use Illuminate\Support\Facades\Auth; // ★追加
use Illuminate\Support\Facades\Hash; // ★追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileNameRequest; // 追加
use App\Http\Requests\ProfileEmailRequest; // 追加
use App\Http\Requests\ProfileImageRequest; // 追加
use App\Http\Requests\ProfilePasswordRequest; // 追加

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

    // パスワードを更新
    public function profilPasswordeEdit(ProfilePasswordRequest $request)
    {
        try {
            $user = Auth::user();
            // password と password_confirmation のバリデーションはリクエストコントローラで行っている
            $data = $request->all();

            // 現在のパスワードをチェック
            if (!(Hash::check($request->get('old_password'), $user->password))) {
                \Log::debug('現在のパスワードが違います');
                \Log::debug('   ');
                
                $errors = ['errors' =>
                    ['old_password' =>
                        ['現在のパスワードが違います。']
                    ]
                ];
                // ステータスコードとエラーメッセージを返す
                return response()->json($errors, 422);
            }

            // パスワード更新時の処理
            // DBに登録されているハッシュ化されたパスワードと入力されたパスワードが一致するか確認
            if (Hash::check($request->password, $user->password)) { // 第一引数にプレーンパスワード、第二引数にハッシュ化されたパスワード
                // パスワードがDBのものと同じ場合は、違うパスワードを設定するようにメッセージを出す。
                \Log::debug('登録されているパスワードと同じでした。');
                \Log::debug('   ');

                $errors = ['errors' =>
                    ['password' =>
                        ['前回と違うパスワードを設定して下さい。']
                    ]
                ];
                // ステータスコードとエラーメッセージを返す
                return response()->json($errors, 422);
            } else {
                // DBと違っていればパスワードを更新する
                // リクエストフォームから受け取ったパスワードをハッシュ化
                $newPass = Hash::make($request->password);
                $user->password = $newPass;
                $user->save();
                \Log::debug('パスワードを更新しました');
                \Log::debug('   ');
            }
            
            return response()->json(['success' => 'パスワードを変更しました。'], 200);
        } catch (\Exception $e) {
            \Log::debug('アカウント情報変更時に例外が発生しました。' .$e->getMessage());
            \Log::debug('   ');
            return response()->json(['errors', 'エラーが発生しました。'], 500);
        }
    }

    // ユーザー退会
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

    // Emailを更新及び認証用リンクを送信
    public function profileEmailEdit(ProfileEmailRequest $request)
    {
        $email = $request->email;
        $id = $request->user_id;
 
        if (empty($id)) {
            \Log::debug('何らかの原因でメールアドレス変更時にユーザーIDが格納されていません。');
            \Log::debug('   ');
 
            $errors = ['errors' =>
                 ['email' =>
                     ['予期せぬエラーが発生しました。']
                 ]
             ];
            return response()->json($errors, 500);
        }
 
        // トークン生成
        $token = hash_hmac('sha256', Str::random(40) . $email, config('app.key'));
 
        try {
            $param = [];
            $param['user_id'] = $id;
            $param['new_email'] = $email;
            $param['token'] = $token;
            // 新しいレコードを作成
            $email_reset = EmailReset::create($param);
            // リセットメールを送信する
            $email_reset->sendEmailResetNotification($token);
      
            \Log::debug('メールアドレス変更確認メールを送信しました。');
            \Log::debug('   ');
            $success = ['success' =>
             ['message' =>
                 ['メールアドレス変更確認メールを送信しました。受信ボックスを確認して下さい。']
             ]
         ];
            // ステータスコードとエラーメッセージを返す
            return response()->json($success, 200);
        } catch (\Exception $e) {
            \Log::debug('アカウント情報変更時に例外が発生しました。' .$e->getMessage());
            \Log::debug('   ');
 
            $errors = ['errors' =>
             ['email' =>
                 ['予期せぬエラーが発生しました。']
             ]
             
         ];

            // ログアウト
            Auth::logout();
            // セッションを削除
            session()->invalidate();
            // csrfトークンを再生成
            session()->regenerateToken();

            return response()->json($errors, 500);
        }
    }

    // メールアドレス変更用リンクから遷移してきた際の処理
    public function changeEmail(Request $request, EmailReset $email_reset)
    {
        $token = $request->token;
        try {
            // トークンが登録されているものか確認
            $userEmail = $email_reset->where('token', $token)->first();
            \Log::debug('URLクエリから渡ってきたトークンがDBに保存されているかチェックしています。');
            \Log::debug('   ');
    
            // トークンが存在している且つ、有効期限が切れていないかチェック
            if ($userEmail && !$this->tokenExpired($userEmail->created_at)) {
                \Log::debug('トークンが存在しており、有効期限以内でした！');
                \Log::debug('   ');
                // ユーザーのメールアドレスを変更
                $user = User::find($userEmail->user_id);
                $user->email = $userEmail->new_email;
                $user->save();
                // 登録後は、変更に使用したトークンやユーザーID、メールアドレスが格納されたレコードを削除する
                $userEmail->delete();
                \Log::debug('ユーザーのメールアドレスを変更して、email_resetsテーブルのレコードを削除しました。');
                \Log::debug('   ');
                $success = ['success' =>
                ['message' =>
                    ['メールアドレスを変更しました。']
                ]
            ];
                // ステータスコードとエラーメッセージを返す
                return response()->json($success, 200);
            } else {
                // レコードが存在していて、有効期限が切れていた場合削除
                if ($userEmail) {
                    $email_reset->where('token', $token)->delete();
                }
            
                $errors = ['errors' =>
                    ['email' =>
                        ['トークンの有効期限が切れています。']
                    ]
                ];
    
                // ステータスコードとエラーメッセージを返す
                return response()->json($errors, 401);
            }
        } catch (\Exception $e) {
            \Log::debug('例外処理が発生しています。' . $e->getMessage());
            \Log::debug('   ');
            $errors = ['errors' =>
            ['email' =>
                ['予期せぬエラーが発生しました。']
            ]
        ];
            // ログアウト
            Auth::logout();
            // セッションを削除
            session()->invalidate();
            // csrfトークンを再生成
            session()->regenerateToken();

            return response()->json($errors, 500);
        }
    }

    // トークンが有効期限切れしていないかチェック
    protected function tokenExpired($createdAt)
    {
        // トークンの有効期限は30分に設定
        $expires = 60 * 30;
        // parseメソッドで、サーバー内の時刻ではなく現在時刻を指定した値にする。ここでは、DBに登録された created_atの時刻が指定される
        // そこから30分が経過しているか判定する。
        // addSecondsメソッドで、日付を加算する。60 * 30 が入っている
        // isPastメソッドで、指定された時刻より過去かどうか判定する。進んでいればfalseが返ってくる
        return Carbon::parse($createdAt)->addSeconds($expires)->isPast();
    }
}
