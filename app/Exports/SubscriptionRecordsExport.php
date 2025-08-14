<?php
namespace App\Exports;

use App\Models\SubscriptionRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionRecordsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filter;
    protected $magazineFilter;
    protected $subscriptionTypeFilter;

    public function __construct($filter = null, $magazineFilter = null, $subscriptionTypeFilter = null)
    {
        $this->filter = $filter;
        $this->magazineFilter = $magazineFilter;
        $this->subscriptionTypeFilter = $subscriptionTypeFilter;
    }

    public function collection()
    {
        $query = SubscriptionRecord::with(['user', 'magazine']);

        if ($this->filter !== null && $this->filter !== '') {
            $query->where('is_offer', $this->filter);
        }
        if ($this->magazineFilter !== null && $this->magazineFilter !== '') {
            $query->where('magazine_id', $this->magazineFilter);
        }
        if ($this->subscriptionTypeFilter !== null && $this->subscriptionTypeFilter !== '') {
            $query->where('subscription_type', $this->subscriptionTypeFilter);
        }

        return $query->get();
    }

    public function map($record): array
    {
        return [
            $record->id,
            $record->user?->name,
            $record->magazine?->name,
            $record->subscription?->id,
            $record->subscription_type,
            $record->recurring_period,
            $record->is_offer ? 'Offer' : 'Paid', // Add this line to show Paid/Offer
            $record->start_date,
            $record->end_date,
            $record->status,
            json_encode($record->details),
            json_encode($record->shipping_info),
            $record->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'User Name',
            'Magazine Title',
            'Subscription ID',
            'Subscription Type',
            'Recurring Period',
            'Payment Type', // Added heading for Paid/Offer
            'Start Date',
            'End Date',
            'Status',
            'Details',
            'Shipping Info',
            'Created At',
        ];
    }
}
