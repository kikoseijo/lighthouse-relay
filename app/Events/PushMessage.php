<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class PushMessage extends Event implements ShouldBroadcast
{

    use SerializesModels;

    public $message;
    private $_as, $_on;

    /**
     * Create a new event instance.
     *
     * @param string $message
     * @param string $as
     * @param string $on
     * @param string $file_line
     */
    public function __construct($message = null, $as = null, $on = null, $file_line = '')
    {
        if (null !== $message) {
            $this->message = $message;
        }
        if (null !== $as) {
            $this->_as = $as;
        }

        $this->_on = ENV('APP_PLATFORM', 'demo');
        if (null !== $on) {
            if ($on[0] == '.') {
                $this->_on .= $on;
            } else {
                $this->_on = $on;
            }
        }

        $now = \DateTime::createFromFormat('U.u', microtime(true));
        $this->message = '[' . $now->format('Y-m-d H:i:s.u') . '] ['.env('APP_PLATFORM').']: ' . $this->message;

        if ($file_line) {
            error_log('[' . $now->format('Y-m-d H:i:s.u') . '] ['.env('APP_PLATFORM').'] ' . $file_line . " [{$this->_on}] \"{$this->message}\"\n", 3, '/tmp/debug.txt');
        }

    }

    /**
     * Get the broadcast event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return $this->_as ? $this->_as : 'api.message';
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [$this->_on . '.api.message'];
    }

    /**
     * Set the name of the queue the event should be placed on.
     *
     * @return string
     */
    public function onQueue()
    {
        return env('APP_PLATFORM') . '_WS';
    }

}
