<?php

namespace Ue\Org\Plugin;

use Overtrue\Wechat\Message;
use Ue\Org\Plugin\Base;
use Log;
use Event;

class Example extends Base {

    public function process() {

        /**
         * 触发条件,请自行修改
         */
        if (mb_substr($this->message->Content, 0, 2) != '梦见') {
            return null;
        }

        $word   = $this->getWord('梦见');
        
        $response = Event::fire('wechat.dream.pre', [$this->customer, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }

        //code start here
        
        
        $response = Event::fire('wechat.dream.post', [$this->customer, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }

        //code start here
        
    }

    private function getWord($filter) {
        return trim(str_replace($filter, '', $this->message->Content));
    }

    public function getResult() {
        return $this->result;
    }

    function getError() {
        return $this->error;
    }

}
