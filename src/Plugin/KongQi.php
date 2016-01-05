<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class KongQi extends Base {

    public function process() {

        /**
         * 触发条件,请自行修改
         */
        if (mb_substr($this->message->Content, 0, 2) != '空气') {
            return null;
        }

        $response = Event::fire('wechat.kong_qi.pre', [$this->wechat, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }


        $word = trim(str_replace('空气', '', $this->message->Content));

        $url = 'http://api.avatardata.cn/Aqi/LookUp?key=0eb92841968742699295a39f712e5a2e&city=' . $word;

        $result = $this->getRequest($url);

        $response = Event::fire('wechat.kong_qi.post', [$this->wechat, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }

        if (!isset($result['error_code']) || $result['error_code']) {
            $this->result = Message::make('text')->content('未找到该城市空气质量.');
            return true;
        }

        $info = $result['result'];
        $data = [
            '污染指数：' . $info['aqi'],
            '空气质量：' . $info['level'],
            '主要污染物：' . $info['core'],
            '播报时间：' . date('Y-m-d H:i', strtotime($info['time'])),
        ];
        $this->result = Message::make('text')->content(implode("\n", $data));
    }

}
