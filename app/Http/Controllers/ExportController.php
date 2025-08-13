<?php
namespace App\Http\Controllers;

use App\Exports\InviteExport;
use App\Exports\MagazineOrdersExport;
use App\Exports\SubscriptionRecordsExport;
use App\Models\Invite;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportInvites(Request $request)
    {
        $eventName = $request->event_name;
        $data      = Invite::with('event')
            ->get()
            ->map(function ($invite) use ($eventName) {
                return [
                    'event_id'    => $invite->event->name,
                    'person_name' => $invite->person_name,
                    'invite_name' => $invite->invite_name,
                    'link'        => route('invite.product_details', ['invite' => $invite, 'security' => $invite->security_key]),
                ];
            });

        return Excel::download(new InviteExport($data), 'invites.xlsx');
    }

    public function exportMagazineOrders(Request $request)
    {

        return Excel::download(new MagazineOrdersExport($request), 'magazine_orders.xlsx');
    }
    public function export(Request $request)
    {
        $filter = $request->query('filter');
        return Excel::download(
            new SubscriptionRecordsExport($filter),
            'subscription_records.xlsx'
        );
    }

}
