<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class Flight extends Base {

    public function process() {

        if (mb_substr($this->message->Content, 0, 2) != '飞机') {
            return null;
        }

        $response = Event::fire('wechat.flight.pre', [$this->customer, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }


        $key = str_replace('飞机', '', $this->message->Content);
        list($from, $to) = explode('到', $key);

        $date = date('Y-m-d', strtotime('+1 days'));


        $url = 'http://touch.qunar.com/h5/flight/flightlist?';
        $url = $url . 'startCity=' . $from . '&destCity=' . $to . '&startDate=' . $date;

        $response = Event::fire('wechat.flight.post', [$this->customer, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }

        $title = '机票查询';
        $pic = 'http://img0.imgtn.bdimg.com/it/u=2756508793,1924774665&fm=21&gp=0.jpg';
        $desc = '便民工具箱';

        $this->result = Message::make('news')->items(function() use ($title, $url, $desc, $pic) {
            return [Message::make('news_item')->title($title)->description($desc)->url($url)->picUrl($pic)];
        });
    }

}
