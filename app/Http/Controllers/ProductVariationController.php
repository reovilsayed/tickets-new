<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Shipping\ShippingCalculation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductVariationController extends Controller
{
    public function storeAttribue(Request $request)
    {
        Attribute::create([
            'name' => str_replace(' ', '_', $request->attr_name),
            'value' => str_replace(' ', '_', $request->attr_value),
            'product_id' => $request->product_id,
        ]);
        return back()
            ->with([
                'message'    => "Attribute Added",
                'target'     => "attribute",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ]);
    }

    public function updateAttribue(Request $request)
    {
        $value = json_encode(explode(',', $request->attr_value));
        Attribute::where('id', $request->attr_id)->update([
            'name' => str_replace(' ', '_', $request->attr_name),
            'value' => str_replace(' ', '_', $value),
        ]);
        return back()
            ->with([
                'message'    => "Attribute Updated",
                'target'     => "attribute",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ]);
    }

    public function deleteProductAttribute(Attribute $attribute)
    {
        $attribute->delete();

        return back()
            ->with([
                'message'    => "Attribute deleted",
                'target'     => "attribute",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ])
            ->with('new-attribute', true);
    }

    public function newVariation(Product $product)
    {
        //return $product->id;
        Product::create([
            'parent_id' => $product->id,
            'description' => $product->description,
            'name' => $product->name,
            'price' => $product->price,
            //'sale_price' => $product->sale_price,
            'quantity' => $product->quantity,
            'sku' => $product->sku,
            'shop_id'=>$product->shop_id,
        ]);
        return back()
            ->with([
                'message_msg'    => "Product Added",
                'target'     => "variation",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ])
            ->with('new-attribute', true);
    }

    public function updateVariation(Request $request, Product $product)
    {
       
        $data = $request->validate([
            'image' => ['nullable', 'file']
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products');
            $product->update([
                'image' => $data['image'],
            ]);
        }
        $product->update([
            'variations' => $request->variation,
            'price' => $request->variable_price,
            'quantity' => $request->variable_stock,
            'sale_price' => $request->sale_price,
            'sku' => $request->variable_sku,
            
        ]);


        return back()
            ->with([
                'message'    => "Product updated",
                'target'     => "variation",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ])
            ->with('new-attribute', true);
    }

    public function deleteProductMeta(Product $product)
    {
        $product->delete();

        return back()
            ->with([
                'message'    => "Variation deleted",
                'target'     => "variation",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ])
            ->with('new-vaiation', true);
    }

    public function CopyProduct(Product $product)
    {
        $new_id = Product::create([
            'name' => $product->name . ' (Copied)',
            'slug' => $product->slug . '-' . Str::random(5),
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'short_description' => $product->short_description,
            'sku' => $product->sku,
            'quantity' => $product->quantity,
            'description' => $product->description,
            'status' => $product->status,
            'featured' => $product->featured,
            'variations' => $product->variation,
            'is_variable' => $product->is_variable,
        ]);
        $products = Product::with('subproducts', 'attributes')->find($product->id);

        foreach ($products->subproducts as $product) {
            Product::create([
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => $product->image,
                'quantity' => $product->quantity,
                'variations' => $product->variation,
                'sku' => $product->sku,
                'parent_id' => $new_id->id,
            ]);
        }

        foreach ($products->attributes as $attribute) {
            DB::table('attributes')->insert([
                'name' => $attribute->name,
                'value' => json_encode($attribute->value),
                'product_id' => $new_id->id,
            ]);
        }
        return back()
            ->with([
                'message'    => "Copied Successfully",
                'alert-type' => 'success',

            ]);
    }
    public function create_all_variation(Product $product)
    {
        $input = [];
        $data = [];
        if ($product->attributes !== null) {
            foreach ($product->attributes as $attribute) {
                $input[$attribute->name] = $attribute->value;
            }
            $variations = $this->cartesian_product($input);
            foreach ($variations as $variation) {
                $data[] = [
                    'parent_id' => $product->id,
                    'short_description' => $product->short_description,
                    'name' => $product->name,
                    'price' => $product->price * 100,
                    'sale_price' => $product->sale_price * 100,
                    'quantity' => $product->quantity,
                    'sku' => $product->sku,
                    'variations' => json_encode($variation),
                    'shop_id' => $product->shop_id,
                ];
            }
        }
        Product::insert($data);
        return back()
            ->with([
                'message'    => "Variation added successfully",
                'alert-type' => 'success',
                'target'     => "variation",
                'scroll'     => "scroll",
            ]);
    }
    public function delete_all_child(Product $product)
    {
        Product::where('parent_id', $product->id)->delete();
        return back()
            ->with([
                'message'    => "All variation deleted successfully",
                'alert-type' => 'success',
                'target'     => "variation",
                'scroll'     => "scroll",
            ]);
    }
    private function cartesian_product($input)
    {
        $input   = array_filter($input);
        $results = array();
        $indexes = array();
        $index   = 0;

        // Generate indexes from keys and values so we have a logical sort order.
        foreach ($input as $key => $values) {
            foreach ($values as $value) {
                $indexes[$key][$value] = $index++;
            }
        }

        // Loop over the 2D array of indexes and generate all combinations.
        foreach ($indexes as $key => $values) {
            // When result is empty, fill with the values of the first looped array.
            if (empty($results)) {
                foreach ($values as $value) {
                    $results[] = array($key => $value);
                }
            } else {
                // Second and subsequent input sub-array merging.
                foreach ($results as $result_key => $result) {
                    foreach ($values as $value) {
                        // If the key is not set, we can set it.
                        if (!isset($results[$result_key][$key])) {
                            $results[$result_key][$key] = $value;
                        } else {
                            // If the key is set, we can add a new combination to the results array.
                            $new_combination         = $results[$result_key];
                            $new_combination[$key] = $value;
                            $results[]               = $new_combination;
                        }
                    }
                }
            }
        }

        // Sort the indexes.
        arsort($results);

        // Convert indexes back to values.
        foreach ($results as $result_key => $result) {
            $converted_values = array();

            // Sort the values.
            arsort($results[$result_key]);

            // Convert the values.
            foreach ($results[$result_key] as $key => $value) {
                $converted_values[$key] = array_search($value, $indexes[$key], true);
            }

            $results[$result_key] = $converted_values;
        }

        return $results;
    }
}
