<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\MagazineSubscription;
use App\Models\SubscriptionMagazineDetail;
use Illuminate\Support\Facades\DB;

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
        $subscriptionsDetails = SubscriptionMagazineDetail::with('magazineSubscription')
            ->where('magazine_id', $magazine->id)
            ->get();
        $annualSubscriptions = $subscriptionsDetails->filter(function ($item) {
            return $item->magazineSubscription && $item->magazineSubscription->name === 'annual';
        });
        $biAnnualSubscriptions = $subscriptionsDetails->filter(function ($item) {
            return $item->magazineSubscription && $item->magazineSubscription->name === 'bi-annual';
        });



        return view('pages.magazines.show', [
            'magazine' => $magazine,
            'archives' => $archives,
            'annualSubscriptions' => $annualSubscriptions,
            'biAnnualSubscriptions' => $biAnnualSubscriptions,
        ]);
    }
}
