<?php

namespace Xincap\Wechat\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Xincap\Wechat\Listeners\AbstractListener;
use Log;

class MobileRegionPreListener extends AbstractListener {

    private $name = 'mobile_region';

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
    public function handle($customer, $message, $data = []) {
        $this->customer = $customer;
        $this->message = $message;
    }

}
