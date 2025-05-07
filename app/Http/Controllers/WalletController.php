<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('agent_id', auth()->id())->latest()->paginate(20);
        $todayDeposit = Transaction::where('agent_id', auth()->id())->where('description', 'Deposit')->sum('amount');
        $todayRefund = Transaction::where('agent_id', auth()->id())->where('description', 'Refund')->sum('amount');
        $customer = null;
        if (request()->filled('user')) {
            $customer = User::where(function ($query) {
                $query->where('email', request()->user)->orWhere('contact_number', request()->user);
            })->where('role_id', 2)->first();
        }
        if (request()->filled('qr')) {
            $customer = User::where('uniqid', request()->qr)->where('role_id', 2)->first();
        }

        return view('pages.wallet.index', compact('customer', 'transactions','todayDeposit','todayRefund'));
    }

    public function withdrawRefund(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'user' => 'required',
            'type' => 'required'
        ]);


        $user = User::find($request->user);

        if ($request->type == 'refund') {
            $user->refund($request->amount);
        } else {
            $user->deposit($request->amount);
        }

        return redirect()->back()->with('success', 'Transaction completed');
    }
}
