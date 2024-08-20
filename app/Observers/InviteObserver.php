<?php

namespace App\Observers;

use App\Models\Invite;

class InviteObserver
{
    /**
     * Handle the Invite "created" event.
     */
    public function created(Invite $invite): void
    {
        $invite->security_key = uniqid();
        $invite->save();
    }

    /**
     * Handle the Invite "updated" event.
     */
    public function updated(Invite $invite): void
    {
        //
    }

    /**
     * Handle the Invite "deleted" event.
     */
    public function deleted(Invite $invite): void
    {
        //
    }

    /**
     * Handle the Invite "restored" event.
     */
    public function restored(Invite $invite): void
    {
        //
    }

    /**
     * Handle the Invite "force deleted" event.
     */
    public function forceDeleted(Invite $invite): void
    {
        //
    }
}
