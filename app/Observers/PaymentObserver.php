<?php

namespace App\Observers;

use App\Enums\BarbershopStatusEnum;
use App\Models\Barbershop;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PaymentObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $payment->refresh(); // need refresh or refacting data
        $barbershop                 = Barbershop::find($payment->barbershop_id);
        $barbershop->status         = BarbershopStatusEnum::ACTIVE;
        $barbershop->expired_date   = Carbon::now()->addDays($payment->days_added);
        $barbershop->save();
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
