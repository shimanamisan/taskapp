// productionモードでの圧縮方法、https://reffect.co.jp/html/webpack-4-mini-css-extract-plugin

const path = require("path");
const { VueLoaderPlugin } = require("vue-loader");
// LIVEリロードをするためのプラグイン
const LiveReloadPlugin = require("webpack-livereload-plugin");
// app.jsとapp.cssファイルに分割するためのプラグイン
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
// JSのコメントをビルド時に削除する
const TerserPlugin = require("terser-webpack-plugin");
// 別ファイルに出力したCSSファイルを圧縮するために必要
const OptimizeCssAssetsPlugin = require("optimize-css-assets-webpack-plugin");
// ビルド時に通知するためのプラグイン
const WebpackBuildNotifierPlugin = require("webpack-build-notifier");
// プロダクションモードでバンドル時に、console.logを自動的に削除するプラグイン
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
// ファイルをコピーするプラグイン
const CopyPlugin = require("copy-webpack-plugin");
// 各種画像形式の圧縮ツールを取りまとめる
const ImageminPlugin = require("imagemin-webpack-plugin").default;
// jpgファイルを圧縮する
const ImageminMozjpeg = require("imagemin-mozjpeg");

// [定数] webpack の出力オプションを指定します
// 'production' か 'development' を指定
const MODE = "production";

const mydir = path.resolve(__dirname);

console.log("ファイルパスを確認しています：" + mydir);

// ソースマップの利用有無(productionのときはソースマップを利用しない)
const enabledSourceMap = MODE === "production";

module.exports = {
    // モード値を production に設定すると最適化された状態で、
    // development に設定するとソースマップ有効でJSファイルが出力される
    mode: MODE,
    performance: { hints: false },
    // ${__dirname}が C:\Users\mikan\myVagrant\centos\project までのファイルパスになる
    // vagrantの共有フォルダからコードを書いているのでサーバ側のように/resourcesで始まるとディレクトリが見つからずエラーになる
    // babel-loader8 でasync/awaitを動作させるためには、@babel/polyfillが必要
    entry: ["@babel/polyfill", mydir + "/resources/js/app.js"],
    output: {
        // 出力ファイル名
        filename: "app.js",
        // 出力先フォルダを指定
        path: mydir + "/public/js",
    },
    // 最適化（webpack4から導入された）
    optimization: {
        minimizer: [
            new TerserPlugin({
                extractComments: "all",
            }),
            new UglifyJsPlugin({
                uglifyOptions: {
                    compress: {
                        drop_console: true,
                    },
                },
            }),
            new OptimizeCssAssetsPlugin({}),
        ],
    },
    module: {
        rules: [
            {
                // 対象ファイルは .css .scss .scss
                test: /\.(sa|sc|c)ss$/,
                use: [
                    // app.jsとapp.cssファイルに分割するためのプラグイン
                    MiniCssExtractPlugin.loader,

                    // CSSをバンドルするための機能
                    {
                        loader: "css-loader",
                        options: {
                            // url()を変換しない
                            // url: false,
                            // ソースマップを有効にする
                            sourceMap: enabledSourceMap,
                        },
                    },
                    {
                        // Sassをバンドルするための機能
                        loader: "sass-loader",
                        options: {
                            // ソースマップの利用有無
                            sourceMap: enabledSourceMap,
                        },
                    },
                    {
                        loader: "import-glob-loader",
                    },
                    // PostCSSのための設定★
                    // {
                    //     loader: "postcss-loader",
                    //     options: {
                    //         // PostCSS側でもソースマップを有効にする
                    //         sourceMap: true,
                    //         plugins: [
                    //             // Autoprefixerを有効化
                    //             require("autoprefixer")({
                    //                 // ☆IEは11以上、Androidは4.4以上
                    //                 // その他は最新2バージョンで必要なベンダープレフィックスを付与する設定
                    //                 browsers: [
                    //                     "last 2 versions",
                    //                     "ie >= 11",
                    //                     "Android >= 4",
                    //                     "iOS >= 8"
                    //                 ]
                    //             })
                    //         ]
                    //     }
                    // }
                ],
            },
            {
                // Vueファイルに対する設定
                test: /\.vue$/,
                use: [
                    {
                        loader: "vue-loader",
                        options: {
                            loaders: {
                                js: "babel-loader",
                            },
                            options: {
                                presets: [
                                    // プリセットを指定することで、ES2020 を ES5 に変換
                                    "@babel/preset-env",
                                ],
                            },
                        },
                    },
                ],
            },
            {
                // JSファイルに対する設定
                test: /\.js$/,
                use: [
                    {
                        loader: "babel-loader",
                        options: {
                            presets: [
                                // プリセットを指定することで、ES2020 を ES5 に変換
                                "@babel/preset-env",
                            ],
                        },
                    },
                ],
            },
            {
                // 拡張子の大文字も許容するように最後尾に i を加える
                // jpegとjpgの様にeがあるかないかを許容するのに、jpe?gという形式にする
                test: /\.(jpe?g|png|svg|gif|ico)$/i,
                loader: "url-loader",
                options: {
                    // 指定のサイズを超過すると、画像が[name]で指定されたファイルに書き換わり独立する
                    // 画像のパスは別から取得できるので、指定のサイズを超えるものが複数ある場合はそれらをブラウザが並行して取得する
                    limit: 2048,
                    // jsディレクトリから見た相対パス
                    name: "../img/[name].[ext]",
                },
            },
        ],
    },
    // 各種プラグインを読み込む
    plugins: [
        // Vueを読み込めるようにするため
        new VueLoaderPlugin(),
        // LIVEリロードするためのプラグイン
        new LiveReloadPlugin(),
        // jsファイルとcssファイルを分割するためのプラグイン
        new MiniCssExtractPlugin({
            // ファイルの出力先。エントリーポイントのjsディレクトリが基準となるので出力先には注意
            filename: "../css/style.css",
        }),
        // ビルド時に通知するためのプラグイン
        new WebpackBuildNotifierPlugin({
            suppressSuccess: true,
        }),
        // ファイルをコピーするプラグイン
        new CopyPlugin({
            patterns: [
                {
                    from: path.resolve(__dirname, "resources/img/"),
                    to: path.resolve(__dirname, "public/img/"),
                    // from: "./resources/img/*",
                    // to: "@/../../public/img", // ディレクトリ構成もコピーされる
                    // context: ".src/sample",
                },
            ],
        }),
        new ImageminPlugin({
            test: /\.(jpe?g|jpg|png|gif|svg)$/i,
            pngquant: {
                quality: "50",
            },
            gifsicle: {
                interlaced: false,
                optimizationLevel: 1,
                colors: 256,
            },
            svgo: {},
            plugins: [
                ImageminMozjpeg({
                    quality: 60,
                    progressive: true,
                }),
            ],
        }),
    ],
    // import 文で .ts ファイルを解決するため
    resolve: {
        // Webpackで利用するときの設定
        alias: {
            vue$: "vue/dist/vue.esm.js",
            // jsディレクトリまでのフルパスをエイリアスとして設定
            "@": path.resolve(__dirname, "resources/js/"),
        },
        extensions: ["*", ".js", ".vue", ".json"],
    },
};
