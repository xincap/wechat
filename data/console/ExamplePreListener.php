<?php

namespace Xincap\Wechat\Listeners\Wechat;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Xincap\Wechat\Listeners\Wechat\AbstractListener;
use Log;

class ExamplePreListener extends AbstractListener {

    private $name = 'example';

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
