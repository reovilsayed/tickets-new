<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\MagazineSubscription;
use App\Models\SubscriptionMagazineDetail;

class MagazineController extends Controller
{
    public function index()
    {
        $magazines = Magazine::latest()->paginate(10);

        return view('pages.magazines.index', ['magazines' => $magazines]);
    }

    public function show($slug)
    {
        $magazine = Magazine::with(['archives', 'subscriptions' => function ($query) {
            $query->whereIn('recurring_period', ['annual', 'bi-annual'])
                  ->whereIn('subscription_type', ['digital', 'physical']);
        }])->where('slug', $slug)->firstOrFail();
    
        return view('pages.magazines.show', [
            'magazine' => $magazine,
            'subscriptions' => $magazine->subscriptions,
            'is_invite' => true
        ]);
    }
}
