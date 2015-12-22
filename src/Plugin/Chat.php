<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class Chat extends Base {

    private $url = 'http://www.tuling123.com/openapi/api?key=';
    private $key = 'd423a9b1568779217e385837434b36e1';

    public function process() {

        $response = Event::fire('wechat.chat.pre', [$this->customer, $this->message], true);

        if ($response) {
            return $response;
        }

        $url = $this->url . $this->key . '&info=' . $this->message->Content;
        $url = $url . '&userid=' . $this->message->FromUserName;

        $client = new \GuzzleHttp\Client();
        $ret = $client->get($url);
        $ret = json_decode($ret->getBody(), true);

        $response = Event::fire('wechat.chat.post', [$this->customer, $this->message, ['data' => $ret]], true);

        if ($response) {
            return $response;
        }

        if (isset($ret['code']) && $ret['code'] = 100000) {
            $this->result = Message::make('text')->content($ret['text']);
        }

        if (is_null($ret)) {
            $this->result = Message::make('text')->content('接口调用异常.');
        }
    }

}
