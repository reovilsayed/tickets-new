<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');
        $event_id = $request->get('event_id');
        $event_date = $request->get('event_date');

        $products = Product::with('event')->where('name', 'like', "%{$query}%")->where('status', 1)->where('invite_only', 0);

        if ($event_id) {
            $products->where('event_id', $event_id);
        }
        // this may be wrong --- for future ref
        if (!empty($event_date)) {
            $products->where(function ($query) use ($event_date) {
                $query->whereDate('end_date', '>=', $event_date)->whereDate('start_date', '<', $event_date);
            });
        }
        $products = $products->paginate($perPage);
        return new ProductCollection($products);
    }

    public function ticketExtras(Request $request)
    {
        $validatedData = $request->validate([
            'extras' => 'required|array',
            'extras.*' => 'integer|exists:extras,id',
        ]);

        $extrasList = $validatedData['extras'];

        $extras = Extra::whereIn('id', $extrasList)->get();

        return response()->json($extras);
    }

    public function events(Request $request)
    {
        $events = Event::all();

        return new EventCollection($events);
    }

    public function extras(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');

        $extras = Extra::with('event')->where('name', 'like', "%{$query}%")->paginate($perPage);

        return response()->json($extras);
    }
}
