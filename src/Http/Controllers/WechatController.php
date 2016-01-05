<?php

namespace Xincap\Wechat\Http\Controllers;

use Ue\Http\Controllers\Controller;
use Overtrue\Wechat\Server;
use Overtrue\Wechat\Message;
use Request;
use Ue\Model\Wechat;
use Xincap\Wechat\Plugin\Loader;

class WechatController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $appId = Request::get('app_id', null);

        $wechat = Wechat::where(['app_id' => $appId])->first();
        
        if (!is_object($wechat)) {
            return response('user not found.');
        }

        $server = new Server($wechat->app_id, $wechat->token, $wechat->des_key);
        
        $server->on('message', function($message) use ($wechat) {
            return Loader::proccess($wechat, $message);
        });
        
        return $server->serve();
    }

}
