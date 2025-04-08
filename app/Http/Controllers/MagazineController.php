<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\MagazineSubscription;
use App\Models\SubscriptionMagazineDetail;

class MagazineController extends Controller
{
    public function index()
    {
        $magazines = Magazine::where('status', 1)->paginate(10);

        return view('pages.magazines.index', ['magazines' => $magazines]);
    }

    public function show($slug)
    {
        $magazine = Magazine::where('slug', $slug)->firstOrFail();
        $archives = $magazine->archives;
        $annualSubscription = $magazine->annualSubscriptions;
        $biAnnualSubscriptions = $magazine->biAnnualSubscriptions;
        return view('pages.magazines.show', [
            'magazine' => $magazine,
            'archives' => $archives,
            'annualSubscription' => $annualSubscription,
            'biAnnualSubscriptions' => $biAnnualSubscriptions
        ]);
    }
}
