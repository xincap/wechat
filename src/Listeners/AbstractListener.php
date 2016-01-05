<?php

namespace Xincap\Wechat\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Response;

class AbstractListener {
    
    protected $message;
    
    /**
     *
     * @var \Ue\Model\Wechat 
     */
    protected $wechat;

}
