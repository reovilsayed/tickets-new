<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Mail\UnpaidOrderReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckUnpaidOrders extends Command
{
    protected $signature = 'orders:check-unpaid';
    protected $description = 'Check for unpaid orders and send reminders';

    public function handle()
    {
        // Find orders that are unpaid for 30 minutes and created today
        $order = Order::where('status', 0)
            ->whereDate('created_at', Carbon::today())
            ->where('created_at', '<=', Carbon::now()->subMinutes(30))
            ->whereDoesntHave('reminders', function ($query) {
                $query->where('type', '30_minute_reminder');
            })
            ->first();
            
        if ($order) {
            // Send reminder email
            Mail::to($order->user->email)->send(new UnpaidOrderReminder($order));

            // Record that we sent this reminder
            $order->reminders()->create([
                'type' => '30_minute_reminder',
                'sent_at' => now(),
            ]);

            $this->info("Sent reminder for order #{$order->id}");
        }
    }
}
