<?php

namespace Xincap\Wechat\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Xincap\Wechat\Listeners\AbstractListener;
use Log;

class ResponseListener extends AbstractListener {

    private $name = 'train';

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