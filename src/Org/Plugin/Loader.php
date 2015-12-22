<?php

namespace Xincap\Wechat\Org\Plugin;

use Overtrue\Wechat\Message;

class Loader {

    private static $plugins = [
        \Xincap\Wechat\Org\Plugin\KongQi::class,
        \Xincap\Wechat\Org\Plugin\JieMeng::class,
        \Xincap\Wechat\Org\Plugin\MobileRegion::class,
        \Xincap\Wechat\Org\Plugin\Train::class,
        \Xincap\Wechat\Org\Plugin\Flight::class,
        \Xincap\Wechat\Org\Plugin\Dream::class,
        \Xincap\Wechat\Org\Plugin\Joke::class,
        \Xincap\Wechat\Org\Plugin\Game::class,
        \Xincap\Wechat\Org\Plugin\Chat::class,
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
