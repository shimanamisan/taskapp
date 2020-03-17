<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ★ 追加
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered; // 追加
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest; // 追加
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // リクエストコントローラーを適応するため、トレイトのメソッドをオーバーライド
    // トレイト側でコントローラーを指定しても同じ動きだが、オーバーライドしたほうが
    // 何かバリデーションの変更があった際に対応しやすいと考えた。
    public function register(RegisterRequest $request)
    {
        // $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
    
    // メソッド追加（なぜ追加するのか？）オーバーライド
    // Illuminate\Foundation\Auth\RegistersUsers トレイトを見てみましょう
    protected function registered(Request $request, $user)
    {
        return $user;
    }
}
