<?php

namespace Xincap\Wechat\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Xincap\Wechat\Listeners\AbstractListener;
use Log;
use Response;

class DreamPostListener extends AbstractListener {

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
    }

}
