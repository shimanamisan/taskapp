<?php
return [
    // envファイルにurl等を設定しているので、それを呼び出している
    'url' => env('FRONT_APP'), //フロントエンドのURL
    'reset_pass_url' => env('FRONT_APP').env('FRONT_FORGOT_PASSWORD')// フロントエンドのパスワードリセットページのURL
    // 'email_verify_url' => env('FRONTEND_EMAIL_VERIFY_URL', '/verify?queryURL='), // メール認証用のURL 2020-01-17 15:38:1
];