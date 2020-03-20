<?php
return [
    // envファイルにurl等を設定しているので、それを呼び出している
    'url' => env('FRONT_APP'), //フロントエンドのURL
    'reset_pass_url' => env('FRONT_APP').env('FRONT_FORGOT_PASSWORD')// フロントエンドのパスワードリセットページのURL
];