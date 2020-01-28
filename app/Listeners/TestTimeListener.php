<?php

namespace App\Listeners;

use App\Events\TestTimeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TestTimeListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestTimeEvent  $event
     * @return void
     */
    public function handle(TestTimeEvent $event)
    {
        logger()->info('Listener Processed At '.now()->toDateTimeString());
        logger()->info('Listener Processed Data');
        logger()->info($event->time->toDateTimeString());
    }
}
