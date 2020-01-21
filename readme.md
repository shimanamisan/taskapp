# Laravel + Vuex + axios でSPAアプリを作る

## 機能一覧
- ログイン
- ログアウト
- 会員登録
- パスワードリマインダー
- 退会機能
- Twitterログイン
- タスクフォルダーを作成
  - TODOリストを作成
  - TODOリストを編集
  - TODOリストを削除
  - TODOリストの検索
  - TODOリストのドラッグアンドドロップ移動
  - TODOリストにできればメモ機能
  - 完了したものを削除する
- タスクフォルダー名の編集
- タスクフォルダーのドラッグアンドドロップ移動
- タスクフォルダーを削除

## データベース設計
- ユーザーテーブル
  - デフォルトのものを使う
- フォルダーテーブル
|列名|型|PRIMARY|UNIQUE|NOT NULL|FOREIGN|
|--|--|--|--|--|--|--|
|id|integer|✔| | | |
|title|varchar(255)| | | | |
|user_id|integer| | | | |
|created_at|TIMESTAMP| | | | |
|updated_at|TIMESTAMP| | | | |
- タスクテーブル
|列名|型|PRIMARY|UNIQUE|NOT NULL|FOREIGN|
|--|--|--|--|--|--|--|
|id|integer|✔| | | |
|title|varchar(255)| | | | |
|status|integer| | | | |
|user_id|integer| | | | |
|folder_id|integer| | | | |
|created_at|TIMESTAMP| | | | |
|updated_at|TIMESTAMP| | | | |

## 各種vueのプラグインをインストール
```shell
npm install vuex vue-spinner vue-router -D
npm install
```

## scssファイルの出力先を変更するので、Laravel Mix を編集
```js
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/style.scss', 'public/css')
    // コンパイルしたファイルのバージョニングを有効にする
    // ビルドするたびにコンパイルしたファイルの URL にランダムな文字列を付けてブラウザがキャッシュを読まないようにする
    .version();
```

## app.blade.phpを作成
```php
// resources/views
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="/css/style.css">
      <title>TodoApp</title>

        <script>
            window.Laravel = {};
            window.Laravel.csrfToken = "{{ csrf_token() }}";
        </script>
    </head>
    <body>
        <div id="app">
       
        </div>
    </body>

    <script src="js/app.js"></script>
</html>
```

## ルーティングの設定
```php
// ルーティングの設定
Route::get('/{app}', function() {
    // APIのURL以外のリクエストに対してはappテンプレートを返す
    return view('app');
    
// 正規表現でどんな文字列が来てもappファイルへリダイレクトするように設定
// この最後の行で、{app}に入るルートパラメータのフォーマットを指定している
})->where('app','.*');
```

## API 用のルートを設定
- API と画面のルート定義は別々のファイルに記述した方が分かりやすいので、API のルート定義は前回画面を返却するルートを定義した routes/web.php ではなく api.php に記載しましょう。そのためには少しデフォルトの定義を変更する必要があります。
- RouteServiceProvider はアプリケーションの起動時にルート定義を読み込むためのクラスです。
- routes/api.php に記述したルート定義に適用されるミドルウェアグループは api なのですが、それを web に変更します。
- ちなみにミドルウェアグループの定義は app/Http/Kernel.php に記述されています。
```php
// app/Providers/RouteServiceProvider.php

protected function mapApiRoutes()
{
    Route::prefix('api')
         ->middleware('web') // webに変更
        //  ->middleware('api')
         ->namespace($this->namespace)
         ->group(base_path('routes/api.php'));
}
```
# 会員登録 API
## テストコード
```shell
php artisan make:test RegisterApiTest
```

## バリデーションエラー
- `authストアモジュール`にエラーメッセージを入れるステートを追加して、コンポーネント側で参照して表示させる




















