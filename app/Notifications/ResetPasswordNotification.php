<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token; // 追加
    protected $title = 'パスワードリセット 通知'; // 追加

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token) // $tokenを追加
    {
        $this->token = $token; // $this->token = $tokenを追加
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
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }
    
    // カスタマイズ
    public function toMail($notifiable)
    {
        $forgotPasswordURL = config('frontend.reset_pass_url'). "?token={$this->token}";

        // デフォルトではそのままメール分を記述しているが、今回は作成したテンプレートを使用する
        // return (new MailMessage)
        //             ->from('itsup-info@shimanamisan.com', config('app.name'))
        //             ->subject($this->title)
        //             ->line('下のボタンをクリックしてパスワードを再設定してください。')
        //             ->action('パスワード再設定', $forgotPasswordURL)
        //             ->line('もし心当たりがない場合は、本メッセージは破棄してください。');
        return (new MailMessage)
                ->subject($this->title)
                ->view(
                    'emails.reset',
                [
                    'reset_url' => url($forgotPasswordURL),
                ]);
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
