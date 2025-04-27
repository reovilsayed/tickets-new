<?php
namespace App\Exports;

use App\Models\MagazineOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MagazineOrdersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

     protected $request;

     public function __construct($request)
     {
         $this->request = $request;
     }

    public function collection()
    {
       
        $orders = MagazineOrder::with('items', 'user')
        ->select('id', 'user_id', 'type', 'total')
        ->when($this->request->start_date && $this->request->end_date, function ($query) {
            $query->whereBetween('created_at', [
                $this->request->start_date,
                $this->request->end_date,
            ]);
        })
        ->when($this->request->subscription_type, function ($query) {
            $query->where('type', $this->request->subscription_type);
        })
        ->get();

        return $orders->map(function ($order) {
        
            $subscriptionTypes = [];

       
            foreach ($order->items as $item) {
                $details = json_decode($item->details);

                    $subscriptionTypes[] = $details->subscription_type ?? 'N/A';
              
            }

         
            $subscriptionTypeString = $subscriptionTypes ? implode(', ', $subscriptionTypes) : 'N/A';
          

            $data= [
                'ID'                => $order->id,
                'User Name'         => $order->user ? $order->user->name : 'N/A',
                'Type'              => $order->type,
                'Subscription Type' => $subscriptionTypeString,
                'Total'             => number_format($order->total, 2), 
            ];
         

            return $data;
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Type',
            'Subscription Type',
            'Total',
        ];
    }
}
