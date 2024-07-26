<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ChargeMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charge:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('role_id', 3)->has('shop')->whereHas('verification', function ($query) {
            $query->whereNotNull('card_no');
        })->where(function ($query) {
            $query->whereDate('paid_at', '<=', now()->subMonth())->orWhereNull('paid_at');
        })->get();
        foreach ($users as $user) {
            if ($user->subscribed('basic') && $user->shop->monthlyCharge()) {
                $user->chargeWithSubscription($user->shop->monthlyCharge(), 'Charges for extra products');
                $user->paid_at = now();
                $user->save();
            } else {
                // if the charge is not given
            }
        }
    }
}
