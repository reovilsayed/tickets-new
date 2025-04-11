<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\Archive;
use App\Models\MagazineSubscription;
use App\Models\SubscriptionMagazineDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BreadController extends Controller
{
    public function store(Request $request, Magazine $magazine)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
            'pdf_file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $pdfPath = $request->file('pdf_file')->store('archives', 'public');

        $archive = new Archive([
            'title' => $request->title,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'shipping_cost' => $request->shipping_cost ?? 0,
            'description' => $request->description,
            'pdf_file' => $pdfPath,
            'magazine_id' => $magazine->id,
        ]);

        $archive->save();

        return redirect()->back()
            ->with('message', 'Archive created successfully.');
    }
    public function edit(Archive $archive)
    {
        return response()->json($archive);
    }

    public function update(Request $request, Archive $archive)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('archives', 'public');
            $archive->pdf_file = $pdfPath;
        }

        $archive->title = $request->title;
        $archive->description = $request->description;
        $archive->price = $request->price;
        $archive->quantity = $request->quantity;
        $archive->shipping_cost = $request->shipping_cost;
        $archive->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Archive $archive)
    {
        Storage::disk('public')->delete($archive->pdf_file);
        $archive->delete();

        return response()->json([
            'success' => true,
            'message' => 'Archive deleted successfully'
        ]);
    }
    public function subscriptionStore(Request $request, Magazine $magazine)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'magazine_subscription_id' => 'required|exists:magazine_subscriptions,id',
            'subscription_type' => 'required|in:physical,digital',
            'price' => 'required|numeric|min:0',
            'recurring_period' => 'required'
        ]);

        DB::beginTransaction();



        // Create the subscription detail
        $subscriptionDetail = SubscriptionMagazineDetail::create([
            'magazine_subscription_id' => $validatedData['magazine_subscription_id'],  // Fixed typo from maga->id
            'magazine_id' => $magazine->id,
            'subscription_type' => $validatedData['subscription_type'],
            'price' => $validatedData['price'],
            'recurring_period' => $validatedData['recurring_period'],
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully',
        ]);
    }
    public function subscriptionEdit(MagazineSubscription $subscription)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $subscription->id,
                'name' => $subscription->name,
                'subscription_type' => $subscription->details->subscription_type,
                'price' => $subscription->details->price,
                'recurring_period' => $subscription->details->recurring_period
            ]
        ]);
    }
    public function subscriptionUpdate(Request $request, MagazineSubscription $subscription)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'magazine_subscription_id' => 'required|exists:magazine_subscriptions',
            'subscription_type' => 'required|in:physical,digital',
            'price' => 'required|numeric|min:0',
            'recurring_period' => 'required'
        ]);

        DB::beginTransaction();


       

        // Update the subscription detail (assuming one-to-one relationship)
        $subscription->details()->update([
            'magazine_subscription_id' => $validatedData['magazine_subscription_id'],
            'subscription_type' => $validatedData['subscription_type'],
            'price' => $validatedData['price'],
            'recurring_period' => $validatedData['recurring_period'],
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Subscription updated successfully',
        ]);
    }
    public function subscriptionDestroy(MagazineSubscription $subscription)
    {
        $subscription->details()->delete();

        // Then delete the subscription
        $subscription->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Subscription deleted successfully'
        ]);
    }
}
