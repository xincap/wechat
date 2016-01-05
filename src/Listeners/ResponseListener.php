<?php

namespace Xincap\Wechat\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Xincap\Wechat\Listeners\AbstractListener;
use Log;

class ResponseListener extends AbstractListener {

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Events  $event
     * @return void
     */
    public function handle($wechat, $message, $data = []) {
        $this->wechat = $wechat;
        $this->message = $message;
        Log::error('wechat：'.$this->wechat->app_id);
    }

}
