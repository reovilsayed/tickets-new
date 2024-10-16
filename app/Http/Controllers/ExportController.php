<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use Illuminate\Http\Request;
use App\Exports\InviteExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportInvites(Request $request)
    {
        $eventName = $request->event_name;
        $data = Invite::with('event') 
            ->get()
            ->map(function ($invite) use ($eventName) {
                return [
                    'event_id'     => $invite->event->name,
                    'person_name'  => $invite->person_name,
                    'invite_name'  => $invite->invite_name,
                    'link'=>route('invite.product_details', ['invite' => $invite, 'security' => $invite->security_key]),
                ];
            });
        
        return Excel::download(new InviteExport($data), 'invites.xlsx');
    }
    
}
