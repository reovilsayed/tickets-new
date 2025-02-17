<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Services\TOCOnlineService;

class SyncCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync customers from TOCOnlineService';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->info('Starting customer sync...');

        // $toc = new TOCOnlineService();
        // $customersData = $toc->getCustomer();

        // foreach ($customersData['data'] as $customer) {
        //     $customerAttributes = [
        //         'customer_id' => $customer['id'],
        //         'business_name' => $customer['attributes']['business_name'],
        //         'phone_number' => $customer['attributes']['phone_number'],
        //         'email' => $customer['attributes']['email'],
        //     ];

        //     Customer::updateOrCreate(
        //         ['tax_registration_number' => $customer['attributes']['tax_registration_number']],
        //         $customerAttributes
        //     );
        // }

        // $this->info('Customer sync completed successfully.');
    }
}
