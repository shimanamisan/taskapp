const mix = require('laravel-mix');

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

// jsのビルド（右が開発環境、左が実際に読み込むファイルの出力先）
mix.js('resources/js/app.js', 'public/js') 
    // SCSSのビルド（JSと同じフォルダ構成）
    .sass('resources/sass/style.scss', 'public/css')
    .options({
        // laravelにはAutoprefixerが最初から入っていて、必要なプレフィックスを自動的に適用
        autoprefixer: {
            options: {
              browsers: [
                'last 2 versions',
              ]
            }
          }
    })
    // versionメソッドで、コンパイルしたファイルのバージョニングを有効にする
    // ビルドするたびにコンパイルしたファイルの URL にランダムな文字列を付けてブラウザがキャッシュを読まないようにする
    .version()
    .sourceMaps();

    // .browserSync({
    //     // https://browsersync.io/docs/options/#option-proxy
    //     // proxyオプションで、ローカルホストのポートを指定
    //     // laravelのビルドインサーバでのポートは8000番なのでそれと同じ値を指定
    //     proxy: {
    //         target: "http://localhost:8000",
    //     },
    // }); 
