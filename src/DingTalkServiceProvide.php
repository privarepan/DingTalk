<?php


namespace ThinkCar\DingTalk;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use ThinkCar\DingTalk\Notice\WorkNoticeClient;
use ThinkCar\DingTalk\Robot\Client\DingTalkRobotClient;

class DingTalkServiceProvide extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/ding.php' => config_path('ding.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('ding.http', function ($app) {
            return $app->make(Client::class,['config' => config('ding.http')]);
        });

        $this->app->singleton('ding.robot', function ($app) {
            return new DingTalkRobotClient;
        });

        $this->app->singleton('ding.auth', function () {
            return new Notice\Auth\DingTalkAuth;
        });

        $this->app->singleton('ding.work-notice', function ($app) {
            return new WorkNoticeClient($app->make('ding.auth'));
        });
    }
}
