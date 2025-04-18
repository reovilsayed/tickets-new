<div>
    
    @if ($coupon == false)
        <div class="coupon-section">
            <h5 style="color: #28BADF">{{ __('words.apply_cupon_code') }}</h5>
            <form class="coupon-form" method="POST" action="{{ route('magazine.coupon', $magazine->slug) }}">
                @csrf
                <input type="text" required name="coupon_code" placeholder="{{ __('words.enter_your_coupan_code') }}">
                <button type="submit">{{ __('words.apply') }}</button>
            </form>
        </div>
    @else
        <div class="coupon-section">
            <h5 style="color: #28BADF">{{ __('words.applied_coupon_code') }}</h5>
            <form class="coupon-form" method="post" action="{{ route('magazine.coupon.remove', $magazine->slug) }}">
                @csrf
                @method('DELETE')
                <h3>
                    {{ $coupon->getAttributes()['code'] }}
                </h3>
                <button type="submit" class="px-4">{{ __('words.remove') }}</button>
            </form>
        </div>
    @endif
</div>
