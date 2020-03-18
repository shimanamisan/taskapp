<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="/css/style.css">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
      <title>TodoApp</title>
    <body>
        <h3>
            パスワード再設定用のメールです。
        </h3>
        <p>
            下記のパスワード再設定用URLをクリックしてください。<br>
            心当たりが無い場合は、このメールを削除してください。
        </p>
        <p>
            <a href="{{ $reset_url }}">パスワード再設定用URL</a>
        </p>
    </body>
</html>