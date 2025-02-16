<?php

namespace App\Console\Commands;

use App\Mail\UnpaidOrderReminder;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class ListUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:list-unpaid';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all unpaid orders between 30 minutes to 2 hours with payment method easypay.pt';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('payment_method', 'easypay.pt')
            ->where('status', 0)
            ->whereRaw('created_at BETWEEN NOW() - INTERVAL 2 HOUR AND NOW() - INTERVAL 30 MINUTE')
            ->get();

        foreach ($orders as $order) {
            $email = $this->getEmailForOrder($order);

            Mail::to($email)->queue(new UnpaidOrderReminder($order));
        }
    }

    private function getEmailForOrder(Order $order)
    {
        if (isset($order->billing->email)) {
            return $order->billing->email;
        }

        return $order->user?->email;
    }
}
