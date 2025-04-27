<?php

namespace App\Observers;

use App\Models\MagazineOffer;
use App\Models\SubscriptionRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MagazineOfferObserver
{
    /**
     * Handle the MagazineOffer "created" event.
     */
    public function created(MagazineOffer $magazineOffer): void
    {
        $password = uniqid();

        $user = User::where('email', $magazineOffer->receiver_email)
            ->orWhere('contact_number', $magazineOffer->receiver_phone)
            ->first();

        if (!$user) {

            $magazineOffer->user()->create([
                'name' => $magazineOffer->receiver_name,
                'email' => $magazineOffer->receiver_email,
                'contact_number' => $magazineOffer->receiver_phone,
                'password' => Hash::make($password),
            ]);

            
        }{
            $magazineOffer->update([
                'user_id'=> $user->id,
            ]);
        }



        // ✅ Make sure subscription relation is loaded
        $magazineOffer->load('subscription');

        // ✅ Now safely access
        SubscriptionRecord::create([
            'recordable_id' => $magazineOffer->id,
            'recordable_type' => get_class($magazineOffer),
            'user_id' => $user->id,
            'magazine_id' => $magazineOffer->magazine_id,
            'subscription_id' => $magazineOffer->subscription_magazine_details_id,
            'subscription_type' => optional($magazineOffer->subscription)->subscription_type,
            'recurring_period' => optional($magazineOffer->subscription)->recurring_period,
            'start_date' => now(),
            'end_date' => now()->addMonths(optional($magazineOffer->subscription)->recurring_period ?? 1),
        ]);
    }


    /**
     * Handle the MagazineOffer "updated" event.
     */
    public function updated(MagazineOffer $magazineOffer): void
    {
        //
    }

    /**
     * Handle the MagazineOffer "deleted" event.
     */
    public function deleted(MagazineOffer $magazineOffer): void
    {
        //
    }

    /**
     * Handle the MagazineOffer "restored" event.
     */
    public function restored(MagazineOffer $magazineOffer): void
    {
        //
    }

    /**
     * Handle the MagazineOffer "force deleted" event.
     */
    public function forceDeleted(MagazineOffer $magazineOffer): void
    {
        //
    }
}
