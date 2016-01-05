<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Log;
use Event;

class Base {

    protected $message;
    protected $customer;
    protected $error = true;
    protected $result;
    protected $name;
    
    function __construct($customer, $message, $className) {
        $this->message = $message;
        $this->customer = $customer;
        $this->name     = $className;
        $this->process();
    }

    protected function getRequest($url) {
        $ch = curl_init();
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
    
    protected function getWord($filter) {
        return trim(str_replace($filter, '', $this->message->Content));
    }

    public function getResult() {
        $data   = ['name'=>$this->name];
        Event::fire('wechat.response', [$this->customer, $this->message, $data], true);
        return $this->result;
    }

    function getError() {
        return $this->error;
    }

}
