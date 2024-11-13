<?php

namespace App\Listeners;

use App\Events\UrlRedirectCreateEvent;
use App\Models\UrlRedirect;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class SaveUrlRedirectListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UrlRedirectCreateEvent $event): void
    {
        $from_url = $event->from_url;
        $to_url = $event->to_url;

        // Save the redirect to the database
        $urlRedirect = new UrlRedirect();
        $urlRedirect->from_url = $from_url;
        $urlRedirect->to_url = $to_url;
        $urlRedirect->save();
    }
}
