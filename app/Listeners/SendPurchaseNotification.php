<?php

namespace App\Listeners;

use App\Events\PurchaseProcessed;
use App\Notifications\PurchaseStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPurchaseNotification
{
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
     * @param  PurchaseProcessed  $event
     * @return void
     */
    public function handle(PurchaseProcessed $event)
    {
        $purchase = $event->purchase;

        request()->user()->notify(new PurchaseStatusChanged($purchase));
    }
}
