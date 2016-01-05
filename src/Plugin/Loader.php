<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Ue\Model\Wechat;
use DB;
use Log;

class Loader {
    
    private static $fun = [];
    
    private static function plugins() {
        $plugins = [];
        $plugins['kong_qi'] = \Xincap\Wechat\Plugin\KongQi::class;
        $plugins['jie_meng'] = \Xincap\Wechat\Plugin\JieMeng::class;
        $plugins['mobile_region'] = \Xincap\Wechat\Plugin\MobileRegion::class;
        $plugins['train'] = \Xincap\Wechat\Plugin\Train::class;
        $plugins['flight'] = \Xincap\Wechat\Plugin\Flight::class;
        $plugins['dream'] = \Xincap\Wechat\Plugin\Dream::class;
        $plugins['joke'] = \Xincap\Wechat\Plugin\Joke::class;
        $plugins['game'] = \Xincap\Wechat\Plugin\Game::class;
        $plugins['chat'] = \Xincap\Wechat\Plugin\Chat::class;
        return $plugins;
    }

    public static function proccess(Wechat $wechat, $message){
        
        DB::enableQueryLog();
        
        $wx = Wechat::find(1);
        
        $plugins    = $wx->plugins;
        if(!count($plugins)){
            return Message::make('text')->content('功能尚未开启.');
        }
        
        foreach ($plugins as $key => $plugin) {
            self::$fun[]  =  $plugin->name;
        }
        
        $list   = self::plugins();
        
        foreach ($list as $key => $plugin) {
            if(array_key_exists($key, self::$fun)){
                $fun    = self::$fun[$key];
                $s = (new $fun($wechat, $message));
                if ($s->getResult()) {
                    return $s->getResult();
                }
            }
        }
        return Message::make('text')->content('维护中.');
    }
    
}
