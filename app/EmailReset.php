<?php
namespace App;

use App\Notifications\ChangeEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // ★追加

class EmailReset extends Model
{
    use Notifiable; // ★追加

    protected $fillable = ["user_id", "new_email", "token"];

    /**
     * メールアドレス認証通知の送信
     *
     * @param  string  $token
     * @return void
     */
    public function sendEmailResetNotification($token)
    {
        // notifyメソッドで通知を送信する。引数に通知インスタンスを渡す
        $this->notify(new ChangeEmail($token));
    }

    /**
     * メールチャンネルに対する通知をルートする
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // メールアドレスのみを返す場合
        return $this->new_email;
    }
}
