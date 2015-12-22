<?php

namespace Ue\Listeners\Wechat;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Ue\Listeners\Wechat\AbstractListener;
use Log;
use Response;

class ExamplePostListener extends AbstractListener {

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
