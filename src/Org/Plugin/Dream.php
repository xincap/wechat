<?php

namespace Xincap\Wechat\Org\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Org\Plugin\Base;
use Log;
use Event;

class Dream extends Base {

    public function process() {

        if (mb_substr($this->message->Content, 0, 2) != '梦见') {
            return null;
        }

        $response = Event::fire('wechat.dream.pre', [$this->customer, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }


        $response = Event::fire('wechat.dream.post', [$this->customer, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }
    }

}
