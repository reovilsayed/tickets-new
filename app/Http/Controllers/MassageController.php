<?php

namespace App\Http\Controllers;

use App\Mail\MassageEmail;
use App\Mail\NotificationEmail;
use App\Models\Massage;
use App\Models\Notification;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MassageController extends Controller
{
    public function store( $id, Request $request)
    {
        $shop=Shop::find($id);
        $massage = Massage::create([
            'massage' => $request->massage,
            'sender_id' => Auth()->id(),
            'reciver_id' => $shop->id,
        ]);

        $this->notification(null,$shop->id);

        // Mail::to($shop->email)->send(new MassageEmail($massage));
        return back()->with('success_msg', 'Massage Send successfully');
    }
    public function shopMassagestore($id, Request $request)
    {
        $user=User::find($id);
        $massage = Massage::create([
            'massage' => $request->massage,
            'reciver_id' => $user->id,
            'sender_id' => auth()->user()->shop->id,
        ]);

        $this->notification(auth()->id(),null);

        // Mail::to($shop->email)->send(new MassageEmail($massage));
        return back()->with('success_msg', 'Massage Send successfully');
    }
    public function seen(Notification $notification)
    {
        if(request()->has('seen')){

            $notification->update([
                'status' => true,
            ]);
           return back();
        }else{

            return redirect($notification->url);
        }

    }
    public function shopMassage($id=null)
    {
        if ($id) {
            $user = User::find($id);
            $massages = Massage::where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->where('reciver_id', auth()->user()->shop->id);
            })->orWhere(function($q)use($user){
                $q->where('sender_id', auth()->user()->shop->id)->where('reciver_id', $user->id);
            })->latest()->get();
   
            
       
      

   
        } else {
            $user = new User();
            $massages = null;
        
        }


        $massageusers = auth()->user()->shop->massages->pluck('sender_id')->unique();
        $users=User::whereIn('id',$massageusers)->get();

        return view('auth.seller.massage', compact('user', 'users', 'massages'));;
    }

    public function create($id = null)
    {
        if ($id) {
            $user = Shop::find($id);
            $massages = Massage::where(function ($q) use ($user) {
                $q->where('sender_id', auth()->id())->where('reciver_id', $user->id);
            })->orWhere(function($q)use($user){
                $q->where('sender_id', $user->id)->where('reciver_id', auth()->id());
            })->latest()->get();
   
        } else {
            $user = new User();
            $massages = null;
        }

        $massageusers = Massage::where('sender_id',auth()->id())->pluck('reciver_id')->unique();
 
        $shops = Shop::whereIn('id',$massageusers)->get();
        return view('pages.massages.create', compact('user', 'shops', 'massages'));
    }

    protected function notification($user, $shop)
    {
        Notification::create([
            'url' => env('APP_URL') . '/vendor/dashboard/massage',
            'title' => 'Massage Created',
            'shop_id' => $shop,
        ]);
    }
}