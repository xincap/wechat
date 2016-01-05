<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class Dream extends Base {

    public function process() {

        if (mb_substr($this->message->Content, 0, 2) != '梦见') {
            return null;
        }

        $response = Event::fire('wechat.dream.pre', [$this->wechat, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }


        $response = Event::fire('wechat.dream.post', [$this->wechat, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }
    }

}
