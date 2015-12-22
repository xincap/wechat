<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class Train extends Base {

    public function process() {

        if (mb_substr($this->message->Content, 0, 2) != '火车') {
            return null;
        }

        $response = Event::fire('wechat.train.pre', [$this->customer, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }

        $key = str_replace('火车', '', $this->message->Content);
        list($from, $to) = explode('到', $key);

        $date = date('Y-m-d', strtotime('+1 days'));

        $url = 'http://touch.qunar.com/h5/train/trainList?startStation=' . $from;
        $url = $url . '&endStation=' . $to . '&searchType=stasta&date=' . $date;
        $url = $url . '&sort=3&wakeup=1';

        $response = Event::fire('wechat.train.post', [$this->customer, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }

        $title = '火车查询';
        $pic = 'http://img0.imgtn.bdimg.com/it/u=2756508793,1924774665&fm=21&gp=0.jpg';
        $desc = '便民工具箱';

        $this->result = Message::make('news')->items(function() use ($title, $url, $desc, $pic) {
            return [Message::make('news_item')->title($title)->description($desc)->url($url)->picUrl($pic)];
        });
    }

}
