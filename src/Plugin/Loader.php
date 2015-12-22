<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;

class Loader {

    private static $plugins = [
        \Xincap\Wechat\Plugin\KongQi::class,
        \Xincap\Wechat\Plugin\JieMeng::class,
        \Xincap\Wechat\Plugin\MobileRegion::class,
        \Xincap\Wechat\Plugin\Train::class,
        \Xincap\Wechat\Plugin\Flight::class,
        \Xincap\Wechat\Plugin\Dream::class,
        \Xincap\Wechat\Plugin\Joke::class,
        \Xincap\Wechat\Plugin\Game::class,
        \Xincap\Wechat\Plugin\Chat::class,
    ];

    public static function run($wechat, $message) {
        foreach (self::$plugins as $key => $plugin) {
            $s = (new $plugin($wechat, $message));
            if ($s->getResult()) {
                return $s->getResult();
            }
        }
        return Message::make('text')->content('维护中.');
    }

}
