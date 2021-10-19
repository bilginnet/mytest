<?php

namespace App\Observers;

use App\Events\PurchaseProcessed;
use App\Models\Purchase;
use App\Notifications\PurchaseStatusChanged;

class PurchaseObserver
{
    /**
     * Handle the Purchase "created" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function created(Purchase $purchase)
    {
        // @todo started job
        //request()->user()->notify(new PurchaseStatusChanged($purchase));
        event(new PurchaseProcessed($purchase));
    }

    /**
     * Listen to the User updating event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function updating(Purchase $purchase)
    {
        if($purchase->isDirty('status')){
            //$new_status = $purchase->status;
            //$old_status = $purchase->getOriginal('status');
            //request()->user()->notify(new PurchaseStatusChanged($purchase));
            event(new PurchaseProcessed($purchase));
        }
    }

    /**
     * Handle the Purchase "updated" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function updated(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the Purchase "deleted" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function deleted(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the Purchase "restored" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function restored(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the Purchase "force deleted" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function forceDeleted(Purchase $purchase)
    {
        //
    }
}
