<?php

namespace Xincap\Wechat;

use Overtrue\Wechat\Message;
use Ue\Model\Wechat;
use DB;
use Log;
use Event;

class WechatApplication {
    
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
        
        $plugins    = $wechat->plugins;
        if(!count($plugins)){
            return Message::make('text')->content('功能尚未开启.');
        }
        
        foreach ($plugins as $key => $plugin) {
            self::$fun[]  =  $plugin->name;
        }
        
        $list   = self::plugins();
        
        foreach ($list as $key => $plugin) {
            if(in_array($key, self::$fun)){
                $data   = ['name'=>$key];
                $s = (new $plugin($wechat, $message, $key));
                if ($s->getResult()) {
                    Event::fire('wechat.response', [$wechat, $message, $data], false);
                    return $s->getResult();
                }
            }
        }
        return Message::make('text')->content('维护中.');
    }
    
}
