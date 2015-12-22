<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class Game extends Base {

    public function process() {

        /**
         * 触发条件,请自行修改
         */
        if (mb_substr($this->message->Content, 0, 2) != '游戏') {
            return null;
        }

        $response = Event::fire('wechat.game.pre', [$this->customer, $this->message], true);

        if ($response) {
            $this->result   = $response;
            return true;
        }


        $response = Event::fire('wechat.game.post', [$this->customer, $this->message], true);
        if ($response) {
            $this->result   = $response;
            return true;
        }
        
        $title  = '微信游戏';
        $url    = 'http://'.$_SERVER['HTTP_HOST'].'/game/kanshu';
        $desc   = '上百款微信小游戏';
        $pic    = 'https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=3149524520,430835410&fm=58';

        $this->result = Message::make('news')->items(function() use ($title, $url, $desc, $pic) {
            return [Message::make('news_item')->title($title)->description($desc)->url($url)->picUrl($pic)];
        });
    }
}
