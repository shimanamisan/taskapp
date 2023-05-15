# README

※アプリケーションのバージョンが古いため動作しない可能性があります。

# 概要

**タスクを付箋のように管理できるサービスです。**

![TaskApp](https://user-images.githubusercontent.com/49751604/102682805-9bc12080-420f-11eb-8f18-975067792530.png)

![task](https://user-images.githubusercontent.com/49751604/102683107-eba0e700-4211-11eb-926e-734597eac87a.gif)

[https://s-taskapp.com/](https://s-taskapp.com/)

- ログイン ID：test01@example.com
- パスワード：password

## 制作背景

タスク管理の Web サービスは多種多様なものが存在していますが、新しいサービスを使用する際はその機能に慣れるまである程度の時間を有すると感じており、それが思っていた以上にストレスでした。個人向けで、もっとシンプルなタスク管理サービスが存在していても良いのではと思ったのが制作のきっかけです。

更に、学習途中だったフロント、バックエンドのフレームワークの CRUD 処理の良いアウトプットにもなりました。

## 工夫した点

- スマホからも使用できるようにレスポンシブに対応
- パフォーマンスを考慮して、Vue.js を使用し SPA で作成
- 簡単にユーザー登録・ログインが出来るように Twitter アカウント認証機能を実装
- DB の構成上タスクがネストされているので、N+1 問題に対処できるように[Eager ロード](https://readouble.com/laravel/5.8/ja/eloquent-relationships.html#eager-loading)を使用

## 反省点

- 個人で開発しているという点から、master ブランチで作業することが多かった。もっと細かくブランチを切って開発を行う
- Vuex のストアを単一のファイルに作成してしまい、機能を追加していくたびにファイルの容量が増えてコードが読み辛くなってしまった

## 機能一覧

### ユーザー登録関連

- ユーザー登録、ログイン、ログアウト
- マイページ機能、プロフィール編集、退会機能（論理削除）
- 画像アップロード機能
- メールアドレス変更通知
- パスワードリマインダー
- 簡単ログイン機能（ゲストユーザーでログイン）

### TwitterAPI 関連

- アカウントの登録、ログイン

### タスク登録機能全般

- ドラッグ＆ドロップでタスクの移動
- タスクカテゴリーフォルダの登録、編集、削除
- タスクカードの登録、編集、削除
- タスクリストの登録、編集、削除

## 使用技術

<!-- ### 開発全般

- Vagrant +CentOS8 の LAMP 環境、composer、npm、webpack、babel -->

### フロントエンド

- Vue.js （2.6.12）
- Vuex（3.5.1）
- Vuedraggable（2.24.3）
- VueRouter（3.4.9）
- axios （0.19.2）
- Sass（CSS 設計には FLOCSS を採用）

### バックエンド

- PHP（7.4.12）
- Laravel（5.8）

### インフラ

- LiteSpeed Web Server
- MySQL（5.6.23）

### その他ツール

- GitHub Actions（Xserver へ自動デプロイ）
- Visual Studio Code
- draw.io
- Adobe XD

## ER 図

![task-app](https://user-images.githubusercontent.com/49751604/97084714-f006b480-1653-11eb-82b9-7be41d70dbc7.png)

## テーブル構成

| テーブル名      | 説明                                       |
| --------------- | ------------------------------------------ |
| users           | ユーザー情報                               |
| folders         | タスクを管理するフォルダー                 |
| cards           | フォルダー配下に格納されるカード情報       |
| tasks           | カード配下に格納されるタスク情報           |
| email_resets    | メールアドレス変更時の認証用トークンを格納 |
| password_resets | パスワードリマインダーで使用               |

# 開発環境

- Windows11: 22H2
- WSL: Ubuntu-20.04 Version 2
- Visual Studio Code: v1.74.3
- Docker: 20.10.23（build 7155243）
- Docker Compose: 2.15.1

# 前提条件

1. Visual Studio Code の拡張機能に [WSL](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-wsl) と [Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) がインストールされていることを確認して下さい。

2. ローカルマシンの hosts ファイルを適当なエディタで開き、以下の記述を追加して下さい。

- ※Windows の hosts ファイルの場所は`C:\Windows\System32\drivers\etc\`にあります。

```bash

# ~ 中略 ~

# localhost name resolution is handled within DNS itself.
#	127.0.0.1       localhost
#	::1             localhost
127.0.0.1       test.example.com # ←適当なドメインを追記する
```

# 起動手順

1. Windows Terminal 等で Ubuntu を起動し、リポジトリをクローンします。

2. `code devcontainer-laravel-for-lamp`とコマンドを実行し、プロジェクトのディレクトリを VS Code で開きます。

3. `F1`キーでコマンドパレットを起動し `Dev Containers: Reopen in Container` と入力してエディタを開き直します。もしくは、以下の画像のようなポップアップの `Reopen in Container` ボタンをクリックします。

![devcontainer-build-start](https://user-images.githubusercontent.com/49751604/212446670-50eda0db-161e-4daf-b35a-030129e3c08e.png)

4. 以下のようにコンテナが起動します。初回起動時はイメージのダウンロードやビルドに少し時間が掛かります。

![devcontainer-build-start](https://user-images.githubusercontent.com/49751604/212431627-aecdb6c5-bc7f-4f79-b21b-ec50fc94a9e3.gif)

# コンテナ起動後の作業

```bash
# ディレクトリの確認
$ pwd
# /workspace

# このリポジトリからLaravelの開発を行う場合は以下のコマンドを実行します
$ cd src
# Laravelの動作に必要なパッケージをインストール
$ composer install
# 書き込み権限を与える
$ chmod 777 -R storage/
# .envファイルを作成
$ cp .env.example .env
# .envファイルに暗号化の際に利用されるランダムな英数字32文字を付与する
$ php artisan key:generate

# パッケージをインストール
$ yarn install
# vueをビルド
$ yarn run build
```

ここまで設定してブラウザから `http://test.example.com/` にアクセスして Laravel のトップページが表示されることを確認して下さい。

VS Code を閉じるとコンテナも停止します。
