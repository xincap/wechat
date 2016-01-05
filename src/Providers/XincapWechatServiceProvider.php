<?php

namespace Xincap\Wechat\Providers;

use Xincap\Wechat\Console\Commands\Wechat;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Support\ServiceProvider;
use Log;

class XincapWechatServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'wechat.kong_qi.pre' => [
            \Xincap\Wechat\Listeners\KongQiPreListener::class,
        ],
        'wechat.kong_qi.post' => [
            \Xincap\Wechat\Listeners\KongQiPostListener::class,
        ],
        'wechat.jie_meng.pre' => [
            \Xincap\Wechat\Listeners\JieMengPreListener::class,
        ],
        'wechat.jie_meng.post' => [
            \Xincap\Wechat\Listeners\JieMengPostListener::class,
        ],
        'wechat.mobile_region.pre' => [
            \Xincap\Wechat\Listeners\MobileRegionPreListener::class,
        ],
        'wechat.mobile_region.post' => [
            \Xincap\Wechat\Listeners\MobileRegionPostListener::class,
        ],
        'wechat.game.pre' => [
            \Xincap\Wechat\Listeners\GamePreListener::class,
        ],
        'wechat.game.post' => [
            \Xincap\Wechat\Listeners\GamePostListener::class,
        ],
        'wechat.joke.pre' => [
            \Xincap\Wechat\Listeners\JokePreListener::class,
        ],
        'wechat.joke.post' => [
            \Xincap\Wechat\Listeners\JokePostListener::class,
        ],
        'wechat.chat.pre' => [
            \Xincap\Wechat\Listeners\ChatPreListener::class,
        ],
        'wechat.chat.post' => [
            \Xincap\Wechat\Listeners\ChatPostListener::class,
        ],
        'wechat.train.pre' => [
            \Xincap\Wechat\Listeners\TrainPreListener::class,
        ],
        'wechat.train.post' => [
            \Xincap\Wechat\Listeners\TrainPostListener::class,
        ],
        'wechat.flight.pre' => [
            \Xincap\Wechat\Listeners\FlightPreListener::class,
        ],
        'wechat.flight.post' => [
            \Xincap\Wechat\Listeners\FlightPostListener::class,
        ],
        'wechat.response' => [
            \Xincap\Wechat\Listeners\ResponseListener::class,
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events) {
        
        //$events = $this->app['events'];
        
        Log::error(get_class($events));
        
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    public function register() {

        $this->app['command.make.wechat'] = $this->app->share(function ($app) {
            return new Wechat();
        });
        $this->commands('command.make.wechat');
    }

    public function provides() {
        return array('command.make.wechat');
    }

}
