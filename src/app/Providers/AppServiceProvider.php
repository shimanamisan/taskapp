<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    // register()では、サービスコンテナへの登録を実装
    public function register()
    {
        // 商用環境以外だった場合にSQLログを出力させる
        if (config("app.env") !== "production") {
            \DB::listen(function ($query) {
                \Log::info(" Query Time: {$query->time}s $query->sql ");
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    // boot() では、そのサービス固有の初期処理を自由に実装できる
    public function boot()
    {
        //
    }
}
