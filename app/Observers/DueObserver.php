<?php

namespace App\Observers;

use App\Models\Due;
use App\Models\Invoice;
use App\Models\Supplier;

class DueObserver
{
    /**
     * Handle the Due "created" event.
     */
    public function created(Due $due): void
    {
        switch($due->dueable_type)
        {
            case Invoice::class:
                $invoice = Invoice::with(["invoicable", "dues"])->find($due->dueable_id);
                if($invoice->invoicable->total == ($invoice->paid_amount + $invoice->dues->sum("paid_amount")))
                    $invoice->update([
                        "completed" => TRUE
                    ]);
                break;
            case Supplier::class:
                Supplier::find($due->dueable_id)->increment('balance', $due->paid_amount);
                break;
        }
    }

    /**
     * Handle the Due "updated" event.
     */
    public function updated(Due $due): void
    {
        //
    }

    /**
     * Handle the Due "deleted" event.
     */
    public function deleted(Due $due): void
    {
        //
    }

    /**
     * Handle the Due "restored" event.
     */
    public function restored(Due $due): void
    {
        //
    }

    /**
     * Handle the Due "force deleted" event.
     */
    public function forceDeleted(Due $due): void
    {
        //
    }
}
