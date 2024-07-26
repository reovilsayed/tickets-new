@component('mail::message')
<h1 class="title">Your Offer is Accepted</h1>
<div class="body-section">
<div style="display:flex;justify-content:center">
<table
style="width: 300px; height: 200px; background-color: #ffffff; border: 1px solid #cccccc; border-radius: 5px; box-shadow: 2px 2px 5px #cccccc; padding: 20px;">
<tr>
<td>
<img src="{{ Storage::url($offer->product->image) }}" alt="" style="width:220px">
<p style="font-size: 16px; color: #666666;">{{ $offer->product->name }}</p>
<p style="font-size: 16px; color: #666666; margin-bottom:5px">Reguler Price :
{{ $offer->product->sale_price ? Sohoj::price($offer->product->sale_price) : Sohoj::price($offer->product->price) }}
</p>
<p style="font-size: 16px; color: #666666;">Offer Price : {{ Sohoj::price($offer->price) }}</p>
@php $url = route('offer.cart',['quantity'=>$offer->qty,'product_id'=>$offer->product->id,'offer_price'=>$offer->price,'offer'=>$offer->id]); @endphp
@component('mail::button', ['url' => $url, 'color' => 'green'])
Add buy now
@endcomponent
</td>
</tr>
</table>
</div>
</div>
@endcomponent
