<?php

namespace Ue\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Response;

class AbstractListener {
    
    protected $message;
    
    /**
     *
     * @var \Ue\Model\Customer 
     */
    protected $customer;

}
