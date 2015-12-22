<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class Joke extends Base {

    public function process() {

        /**
         * 触发条件,请自行修改
         */
        if (mb_substr($this->message->Content, 0, 2) != '笑话') {
            return null;
        }

        $response = Event::fire('wechat.joke.pre', [$this->customer, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }


        $response = Event::fire('wechat.joke.post', [$this->customer, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }
    }

}
