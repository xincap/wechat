<?php

namespace Xincap\Wechat\Listeners;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\Jobs\Job;
use Log;

class CompleteListener extends Job implements SelfHandling, ShouldQueue {
    
    use InteractsWithQueue, SerializesModels;
    
    
    protected $message;
    
    /**
     *
     * @var \Ue\Model\Wechat 
     */
    protected $wechat;
    
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct() {
        //
    }
    public function fire() {
        $this->resolveAndFire(json_decode($this->getRawBody(), true));
    }

    public function getRawBody() {
        return $this->job;
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
