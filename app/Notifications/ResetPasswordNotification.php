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

        return (new MailMessage)
                    ->line('リセット用のメールアドレスを入力してください。')
                    ->action('Notification Action', $forgotPasswordURL)
                    ->line('Thank you for using our application!');
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
