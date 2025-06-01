<?php
namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Event;
use App\Models\Invite;
use App\Models\Magazine;
use App\Models\Product;
use App\Models\SubscriptionMagazineDetail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Event $event, Request $request)
    {
        // Clear existing cart and discount sessions
        Cart::session($event->slug)->clear();
        session()->forget('discount');
        session()->forget('discount_code');

        $hasValidTicket = false;

        if ($request->has('tickets') && is_array($request->tickets)) {
            foreach ($request->tickets as $ticketId => $quantity) {
                if ($quantity > 0) {
                    $product = Product::find($ticketId);

                    if ($product) {
                        Cart::session($event->slug)->add(
                            $product->id,
                            $product->name,
                            $product->currentPrice(),
                            $quantity
                        )->associate('App\Models\Product');
                        $hasValidTicket = true;
                    }
                }
            }
        }

        if (! $hasValidTicket) {
            return redirect()->back()->with('error', 'Please select at least one valid ticket.');
        }

        return redirect()->route('checkout', $event);
    }

    public function magazineAdd(Magazine $magazine, Request $request)
    {
        // Clear previous cart and session data
        Cart::session($magazine->slug)->clear();
        Cart::session($magazine->slug)->clearCartConditions();
        session()->forget(['discount', 'discount_code', 'coupon_id']);

        $itemsAdded = 0;

        // Handle Archives
        if ($request->has('archive')) {
            foreach ($request->archive as $archiveId => $quantity) {
                if ($quantity > 0) {
                    $archive = Archive::find($archiveId);
                    if ($archive) {
                        Cart::session($magazine->slug)->add(
                            $archive->id,
                            $archive->title,
                            $archive->price,
                            $quantity,
                            ['type' => 'onetime']
                        )->associate(Archive::class);
                        $itemsAdded++;
                    }
                }
            }
        }

        // Handle Subscriptions
        if ($request->has('subscription')) {
            foreach (['annual', 'biannual'] as $type) {
                if (! empty($request->subscription[$type])) {
                    $subscription = SubscriptionMagazineDetail::find($request->subscription[$type]);
                    if ($subscription) {
                        Cart::session($magazine->slug)->add(
                            $subscription->id,
                            ucfirst($subscription->subscription_type) . ' (' . ucfirst($subscription->recurring_period) . ') Subscription',
                            $subscription->price,
                            1,
                            [
                                'type'              => 'subscription',
                                'subscription_type' => $subscription->subscription_type,
                                'subscription'      => $subscription->recurring_period,
                            ]
                        )->associate(SubscriptionMagazineDetail::class);
                        $itemsAdded++;
                    }
                }
            }
        }

        // If no items were added, redirect back with an error
        if ($itemsAdded === 0) {
            return back()->withErrors('Please select at least one archive or subscription.');
        }

        // Otherwise, proceed to checkout
        return redirect()->route('magazine_checkout', $magazine);
    }

    public function inviteadd(Invite $invite, Request $request)
    {

        Cart::session($invite->slug)->clear();
        foreach ($request->tickets as $ticket => $quantity) {
            if ($quantity > 0) {
                $product = Product::find($ticket);
                Cart::session($invite->slug)->add($product->id, $product->name, 0, $quantity)->associate('App\Models\Product');
            }
        }
        return redirect()->route('invitecheckout', $invite);
    }
    public function update(Request $request)
    {

        Cart::update($request->product_id, [
            'quantity' => [
                'relative' => false,
                'value'    => $request->quantity,
            ],
        ]);
        return back()->with('success_msg', 'Item has been updated!');
    }
    public function destroy($id)
    {
        Cart::remove($id);
        return back()->with('success_msg', 'Item has been removed!');
    }
}
