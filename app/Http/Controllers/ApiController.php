<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Extra;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');

        $products = Product::with('event')->where('name', 'like', "%{$query}%")->paginate($perPage);

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

    public function extras(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');

        $extras = Extra::with('event')->where('name', 'like', "%{$query}%")->paginate($perPage);

        return response()->json($extras);
    }
}
