<?php

namespace Xincap\Wechat\Plugin;

use Overtrue\Wechat\Message;
use Xincap\Wechat\Plugin\Base;
use Log;
use Event;

class MobileRegion extends Base {

    public function process() {

        /**
         * 触发条件,请自行修改
         */
        if (mb_substr($this->message->Content, 0, 2) != '手机') {
            return null;
        }

        $response = Event::fire('wechat.mobile_region.pre', [$this->customer, $this->message], true);

        if ($response) {
            $this->result = $response;
            return true;
        }

        $no = str_replace('手机', '', $this->message->Content);

        $url = 'http://apis.baidu.com/showapi_open_bus/mobile/find?num=' . trim($no);
        $result = $this->getRequest($url);

        $response = Event::fire('wechat.mobile_region.post', [$this->customer, $this->message], true);
        if ($response) {
            $this->result = $response;
            return true;
        }

        if (!isset($result['showapi_res_code']) || $result['showapi_res_code']) {
            $this->result = Message::make('text')->content('手机归属查询服务异常.');
            return true;
        }

        $data = [
            '城市：' . $result['showapi_res_body']['city'],
            '名称：' . $result['showapi_res_body']['name']
        ];

        $this->result = Message::make('text')->content(implode("\n", $data));
    }

    protected function getRequest($url) {
        $ch = curl_init();
        $header = array(
            'apikey: 4fd481fcd2f05b407d96f756cd939b73',
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }

}
