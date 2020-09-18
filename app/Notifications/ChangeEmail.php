<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeEmail extends Notification
{
    use Queueable;

    public $token; // 追加
    protected $title = 'メールアドレス変更 通知'; // 追加

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        // $tokenを追加
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            // 件名
            ->subject('メールアドレス変更 通知')
            // メールテンプレートの指定
            ->view(
                'email.changeEmail',
                // urlヘルパメソッドは、URLを生成する。生成されるURLは自動的に
                // 現在のリクエストのスキームとホストが使用される
                ['result_url' =>url("/mypage/change-password/{$this->token}")]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
