<?php

namespace Xincap\Wechat\Listeners;

use Illuminate\QueXincap\Wechat\InteractsWithQueue;
use Illuminate\Contracts\QueXincap\Wechat\ShouldQueue;
use Log;
use Response;

class AbstractListener {
    
    protected $message;
    
    /**
     *
     * @var \Xincap\Wechat\Model\Customer 
     */
    protected $customer;

}
