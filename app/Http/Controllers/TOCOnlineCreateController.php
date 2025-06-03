<?php
namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Product;
use App\Services\TOCOnlineService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class TOCOnlineCreateController extends Controller
{
    public function __invoke(Extra $extra): RedirectResponse
    {
        $tocOnline = new TOCOnlineService();
        $tax_type  = $extra->tax_type;

        if ($tax_type == '23') {
            $tax_code = 'NOR';
        } else if ($tax_type == '13') {
            $tax_code = 'INT';
        } else {
            $tax_code = 'RED';
        }

        $data = $tocOnline->createProduct(
            type: $extra->type,
            code: 'EXTRA_' . $extra->id,
            description: $extra->name,
            price: $extra->price,
            vat: true,
            taxCode: $tax_code,
        );

        if (isset($data['error'])) {
            Log::error('TOCOnlineService: ' . $data['message']);
            return redirect()->back()->with([
                'message'    => 'Error creating TOCOnline item: ' . $data['message'],
                'alert-type' => 'error',
            ]);
        }

        if (isset($data['data']['id'])) {
            $extra->update([
                'toconline_item_code' => 'EXTRA_' . $extra->id,
                'toconline_item_id'   => $data['data']['id'],
            ]);

            return redirect()->back()->with([
                'message'    => 'TOCOnline item created successfully.',
                'alert-type' => 'success',
            ]);
        } else {
            Log::error('TOCOnlineService: ' . json_encode($data));
            return redirect()->back()->with([
                'message'    => 'Error creating TOCOnline item: ' . $data['message'],
                'alert-type' => 'error',
            ]);
        }
    }
    public function createFromTicket(Product $product): \Illuminate\Http\RedirectResponse
    {
        $tocOnline = new TOCOnlineService();
        $tax_type  = $product->tax_type;

        if ($tax_type == '23') {
            $tax_code = 'NOR';
        } elseif ($tax_type == '13') {
            $tax_code = 'INT';
        } else {
            $tax_code = 'RED';
        }

        $description = $product->name ?: 'No description';

        $data = $tocOnline->createProduct(
            type: $product->type,
            code: 'PRODUCT_' . $product->id,
            description: $description,
            price: $product->price,
            vat: true,
            taxCode: $tax_code,
        );

        if (isset($data['error'])) {
            Log::error('TOCOnlineService: ' . $data['message']);
            return redirect()->back()->with([
                'message'    => 'Error creating TOCOnline item: ' . $data['message'],
                'alert-type' => 'error',
            ]);
        }

        if (isset($data['data']['id'])) {
            $product->update([
                'toconline_item_code' => 'PRODUCT_' . $product->id,
                'toconline_item_id'   => $data['data']['id'],
            ]);

            return redirect()->back()->with([
                'message'    => 'TOCOnline item created successfully for Product.',
                'alert-type' => 'success',
            ]);
        } else {
            Log::error('TOCOnlineService: ' . json_encode($data));
            return redirect()->back()->with([
                'message'    => 'Error creating TOCOnline item: ' . $data['message'],
                'alert-type' => 'error',
            ]);
        }
    }
}
