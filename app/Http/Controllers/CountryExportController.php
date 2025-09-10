<?php
namespace App\Http\Controllers;

use App\Exports\CountryExport;
use App\Exports\CountryPTExport;
use App\Models\SubscriptionRecord;
use Maatwebsite\Excel\Facades\Excel;

class CountryExportController extends Controller
{
    public function exportPortugal()
    {
        $countryPT = SubscriptionRecord::whereHas('user', function ($q) {
            $q->where('country', 'PT');
        })->get();
        return Excel::download(
            new CountryPTExport($countryPT),
            'portugal_subscriptions.xlsx'
        );

    }

    public function exportAll()
    {
        $country = SubscriptionRecord::all();
        return Excel::download(
            new CountryExport($country),
            'all_subscriptions.xlsx'
        );
    }
}
