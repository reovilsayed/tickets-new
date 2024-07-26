<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketPlaced;
use App\Models\Ticket;
use Illuminate\Support\Carbon;

class TicketsController extends Controller
{
    public function create()
    {
        //  dd(Auth::user()->getShop());
        return view('auth.seller.tickets.create');
    }
    public function store(Request $request)
    {


        $request->validate([
            'subject' => 'required|string',
            'massage' => 'required|string',
            'image' => 'nullable|image',

        ]);
        try {
            $ticket = Ticket::create([
                'shop_id' => Auth::user()->shop->id,
                'subject' => $request->subject,
                'massage' => $request->massage,
                'status' => 0,
                'image' => $request->has('image') ? $request->image->store('tickets') : null,

            ]);
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new TicketPlaced($ticket, 'Thank your for tickets'));
            return redirect()->route('vendor.ticket.index')->withSuccess('Tickets create successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function index()
    {
        $tickets = Ticket::where('shop_id', Auth()->user()->shop->id)->where('parent_id', null)->latest()->get();
        return view('tickets.index', compact('tickets'));
    }
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }
    public function reply(Ticket $ticket, Request $request)
    {
        $request->validate([
            'massage' => 'required|string',
            'image' => 'nullable|image',

        ]);
        if (auth()->user()->role_id == 1) {
            $action = 1;
        } else {
            $action = 0;
        }

        try {
            $reply = Ticket::create([
                'shop_id' => Auth::user()->shop->id ?? null,
                'user_id' => Auth()->id(),
                'parent_id' => $ticket->id,
                'massage' => $request->massage,
                'status' => 0,
                'image' => $request->has('image') ? $request->image->store('tickets') : null,



            ]);
            $ticket->update([
                'updated_at' => Carbon::now()->timestamp,
                'action' => $action,
            ]);
            if (auth()->user()->role_id == 1) {
                $email = $ticket->user->email;
            } else {
                $email = env('MAIL_FROM_ADDRESS');
            }
            Mail::to($email)->send(new TicketPlaced($reply, 'Thank your for replay'));
            return redirect()->back()->withSuccess('Tickets Reply successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function close(Ticket $ticket)
    {
        if ($ticket->status == true) {
            $ticket->update([
                'status' => 0,
            ]);
            return redirect()->back()->withSuccess('Tickets Close successfully');
        } else {
            $ticket->update([
                'status' => 1,
            ]);
            return redirect()->back()->withSuccess('Tickets Open successfully');
        }
    }
}