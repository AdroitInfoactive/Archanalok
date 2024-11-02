<?php

namespace App\Listeners;

use App\Events\UrlRedirectCreated;
use App\Models\UrlRedirect;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUrlRedirect
{
    /**
     * Create the event listener.
     */
    public function __construct(UrlRedirectCreated $event)
    {
        UrlRedirect::create([
        'from_url' => $event->oldUrl,
        'to_url' => $event->newUrl,
        ]);
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
    }
}
