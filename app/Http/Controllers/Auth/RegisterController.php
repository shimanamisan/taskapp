<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Validation\Rule; // ★追加
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ★ 追加
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest; // 追加
use Illuminate\Auth\Events\Registered; // 追加
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = "/home";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("guest");
    }

    protected function validator(array $data)
    {
        // カスタムエラーメッセージ
        $message = [
            "email.unique" =>
                "無効なメールアドレスです。メールアドレスを確認してやり直してください。",
            "regex" => "半角英数のみご利用いただけます。",
            "confirmed" => ":attributeと、:attribute再入力が一致していません。",
        ];

        return Validator::make(
            $data,
            [
                "name" => ["required", "string", "max:30"],
                "email" => [
                    "required",
                    "string",
                    "email",
                    "max:100",
                    // Ruleクラスを使用してバリデーションルールをカスタマイズ出来る
                    // ユーザーテーブルのdelete_flgが0のユーザーに対してemailの同値チェックを行う
                    Rule::unique("users", "email")->where("delete_flg", 0),
                ],
                "password" => [
                    "required",
                    "string",
                    "min:8",
                    "max:100",
                    "confirmed",
                    'regex:/^[a-zA-Z0-9]+$/',
                ],
            ],
            $message
        );
    }

    protected function create(array $data)
    {
        return User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "email_register_flg" => true, //Emailで登録されたか判定用フラグ
            "password" => Hash::make($data["password"]),
        ]);
    }

    // リクエストコントローラーを適応するため、トレイトのメソッドをオーバーライド
    // トレイト側でコントローラーを指定しても同じ動きだが、オーバーライドしたほうが
    // 何かバリデーションの変更があった際に対応しやすいと考えた。
    public function register(RegisterRequest $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered(($user = $this->create($request->all()))));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?:
            redirect($this->redirectPath());
    }

    // Illuminate\Foundation\Auth\RegistersUsers トレイトを見てみましょう
    protected function registered(Request $request, $user)
    {
        return $user;
    }
}
