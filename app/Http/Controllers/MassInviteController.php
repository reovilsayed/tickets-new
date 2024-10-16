<?php

namespace App\Http\Controllers;

use App\Mail\InviteMail;
use App\Models\Event;
use App\Models\Invite;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class MassInviteController extends Controller
{
    public function MassInvitePage()
    {
        $events = Event::get();
        return view('vendor.voyager.invites.mass_invite', compact('events'));
    }

    public function getProducts($eventId)
    {
        $products = Product::where('event_id', $eventId)->where('invite_only', 1)->get();

        return response()->json($products);
    }

    public function MassInvite(Request $request)
    {
 
        $validate = $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('excel_file');
        $data = Excel::toCollection(null, $file);
        $rows = $data[0];
        unset($rows[0]);

        foreach ($rows as $row) {
            if (isset($row[0]) && isset($row[1])) {

                $invite = Invite::create([
                    'event_id' => $request->event_name,
                    'person_name' => $row[0],
                    'invite_name' => $row[0] . "'s-invite",
                    'security_key' => Str::random(10),
                    'slug' => uniqid(),
                ]);

                $data = [];
                foreach ($request->product as $key => $product) {

                    if (isset($product['checked'])) {
                        $data[$key] = ['quantity' => $product['qty']];
                    }
                }
                $invite->attachProducts($data);

                foreach ($request->product as $key => $product) {
                    if (isset($product['checked']) && isset($product['qty'])) {

                        $productModel = Product::find($key);

                        if ($productModel) {

                            $productModel->quantity -= (int) $product['qty'];

                            $productModel->save();
                        }
                    }
                }
                if($request->sent_email){
                    Mail::to($row[1])->send(new InviteMail($invite));
                }
            }
        }

        return redirect()->route('voyager.invites.index')->with(['alert-type' => 'success', 'message' => 'Invite created successfully!']);
    }
}
