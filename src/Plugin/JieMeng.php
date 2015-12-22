<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class JieMeng extends Base {

    public function process() {

        /**
         * 触发条件,请自行修改
         */
        if (mb_substr($this->message->Content, 0, 2) != '解梦') {
            return null;
        }

        $response = Event::fire('wechat.jie_meng.pre', [$this->customer, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }
        $word = str_replace('解梦', '', $this->message->Content);
        $key = '1f071a80dd53409da4186846206fc76a';
        $url = 'http://api.avatardata.cn/ZhouGongJieMeng/LookUp?key=' . $key . '&keyword=' . $word;
        $result = $this->getRequest($url);

        $response = Event::fire('wechat.jie_meng.post', [$this->customer, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }

        if (!isset($result['total']) || !$result['total']) {
            $this->result = Message::make('text')->content('周公不能解此梦.');
            return true;
        }

        $data = array_flip(array_column($result['result'], 'title'));
        if (array_key_exists($word, $data)) {
            $index = $data[$word];
            $text = str_replace(['<br/>', '<br>'], "\n", $result['result'][$index]['content']);
            $text = strip_tags($text);
            $this->result = Message::make('text')->content($text);
            return true;
        }
        $this->result = Message::make('text')->content('周公也无能为力.');
    }
}
