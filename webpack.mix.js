const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.js("resources/js/app.js", "public/js")
    // SCSSのビルド（JSと同じフォルダ構成）
    .sass("resources/sass/style.scss", "public/css")
    .options({
        // laravelにはAutoprefixerが最初から入っていて、必要なプレフィックスを自動的に適用
        autoprefixer: {
            options: {
                browsers: ["last 2 versions"]
            }
        }
    })
    // versionメソッドで、コンパイルしたファイルのバージョニングを有効にする
    // ビルドするたびにコンパイルしたファイルの URL にランダムな文字列を付けてブラウザがキャッシュを読まないようにする
    .version()
    .sourceMaps();

// ローカルサーバ立ち上げの設定
mix.browserSync({
    files: [
        "resource/views/**/*.blade.php",
        // 公開フォルダを指定
        "public/**/*.*"
    ],
    proxy: {
        // laravel側で立ち上げる内部サーバと合わせる
        target: "http://127.0.0.1:8000"
    }
});
