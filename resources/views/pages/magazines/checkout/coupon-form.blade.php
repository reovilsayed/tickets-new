<div>
    @if ($coupon == false)
        <div>
            <h5 style="color: #28BADF !important">{{ __('words.apply_cupon_code') }}</h5>
            <form class="coupon-form" method="POST" action="{{ route('magazine.coupon', $magazine->slug) }}">
                @csrf
                <div>
                    <input type="text" required name="coupon_code"
                        placeholder="{{ __('words.enter_your_coupan_code') }}">
                    <button type="submit">{{ __('words.apply') }}</button>
                </div>
            </form>
        </div>
    @else
        <div class="coupon-section">
            <h5>{{ __('words.applied_coupon_code') }}</h5>
            <form class="coupon-form" method="post" action="{{ route('magazine.coupon.remove', $magazine->slug) }}">
                @csrf
                @method('DELETE')
                <div>
                    <input type="text" value="{{ $coupon->getAttributes()['code'] }}" readonly>
                    <button type="submit">{{ __('words.remove') }}</button>
                </div>
            </form>
        </div>
    @endif
</div>
