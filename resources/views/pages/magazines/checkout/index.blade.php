<x-magazine-checkout-layout :magazine="$magazine">

    @php
        // Initialize all variables at the beginning

        $showBillingInfo = false;

        // Check for physical items
        foreach ($cart->getContent() as $item) {
            if ($item->model->needShipping()) {
                $showBillingInfo = true;
                break;
            }
        }

    @endphp

    <div class="card">
        @if ($showBillingInfo && $shipping->count() == 0)
            <div class="card-body">

                <h3 class="text-center" style="color: #28BADF !important">
                    {{ __('words.need_country_title') }}
                </h3>
                <p class="text-center" style="color: #28BADF !important">
                    {{ __('words.need_country_message') }}
                </p>

                <div class="col-md-8 mx-auto">
                    <form method="post" action="{{ route('magazine.shipping', $magazine) }}">
                        <div class="input-group mb-3">
                            @csrf
                            <select name="country" class="form-control m-0" id="country" required>
                                <option value="" selected>Select your country</option>
                                @foreach (Sohoj::getCountries() as $code => $country)
                                    <option value="{{ $code }}">{{ $country }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn" style="background-color: #28badfd5; color: #ffff" type="submit">
                                <i class="fa fa-check"></i>
                                {{ __('words.confirmed') }}
                            </button>
                        </div>
                    </form>
                </div>


                <x-magazine-checkout-summary-table :cart="$cart" :coupon="$coupon" :shipping="$shipping" />
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('magazines.show', $magazine) }}" class="btn"
                        style="background-color: #28badfce; color: #ffff">
                        <i class="fa-solid fa-chevron-left"></i>
                        {{ __('words.go_back') }}
                    </a>

                </div>

            </div>
        @else
            <div class="card-body">



                <x-magazine-checkout-coupon-form :magazine="$magazine" :cart="$cart" :coupon="$coupon" />

                <x-magazine-checkout-summary-table :cart="$cart" :coupon="$coupon" :shipping="$shipping" />






                <form method="post" action="{{ route('magazinecheckout.store', $magazine) }}">
                    @csrf

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item bg-transparent">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
                                    style="background-color: #28BADF;">
                                    {{ __('words.billing_info') }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="vatNumber" class="form-label">{{ __('words.vat_number') }}</label>
                                        <input type="text" name="vatNumber" class="form-control" id="vatNumber"
                                            value="{{ auth()->user()->vatNumber }}"
                                            placeholder="{{ __('words.vat_number') }}">
                                    </div>
                                    <div class="mb-3 row row-cols-2">
                                        <div>
                                            <label for="name" class="form-label">{{ __('words.name') }}</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="{{ __('words.enter_name') }}"
                                                value="{{ auth()->user()->name }}">
                                        </div>
                                        <div>
                                            <label for="l_name" class="form-label">{{ __('words.name') }}</label>
                                            <input type="text" name="l_name" class="form-control" id="l_name"
                                                placeholder="{{ __('words.enter_name') }}"
                                                value="{{ auth()->user()->l_name }}">
                                        </div>
                                    </div>
                                    <label for="intl-phone" class="form-label">{{ __('words.contact_number') }}</label>
                                    <div class="mb-3">
                                        <input type="tel" name="contact_number" class="form-control" id="intl-phone"
                                            placeholder="{{ __('words.contact_number') }}"
                                            value="{{ auth()->user()->contact_number }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">{{ __('words.address') }}</label>
                                        <input type="text" name="address" class="form-control" id="address"
                                            placeholder="{{ __('words.enter_address') }}"
                                            value="{{ auth()->user()->address }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($showBillingInfo)
                            <div class="accordion-item bg-transparent mt-2">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                                        style="background-color: #28BADF;">
                                        {{ __('words.shipping_info') }}
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="recipient_name"
                                                    class="form-label">{{ __('words.recipient_name') }}</label>
                                                <input type="text" name="shipping[recipient_name]"
                                                    class="form-control" value="{{ auth()->user()->fullName() }}"
                                                    id="recipient_name"
                                                    placeholder="{{ __('words.recipient_name') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="company" class="form-label">{{ __('words.company') }}
                                                    ({{ __('words.optional') }})</label>
                                                <input type="text" name="shipping[company]" class="form-control"
                                                    id="company" placeholder="{{ __('words.company') }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="street_address"
                                                    class="form-label">{{ __('words.street_address') }}</label>
                                                <input type="text" name="shipping[street_address]"
                                                    class="form-control" id="street_address"
                                                    placeholder="{{ __('words.street_address') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="apartment"
                                                    class="form-label">{{ __('words.apartment_suite') }}
                                                    ({{ __('words.optional') }})</label>
                                                <input type="text" name="shipping[apartment]" class="form-control"
                                                    id="apartment" placeholder="{{ __('words.apartment_suite') }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="city"
                                                    class="form-label">{{ __('words.city') }}</label>
                                                <input type="text" name="shipping[city]" class="form-control"
                                                    id="city" placeholder="{{ __('words.city') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="state_province"
                                                    class="form-label">{{ __('words.state_province') }}</label>
                                                <input type="text" name="shipping[state_province]"
                                                    class="form-control" id="state_province"
                                                    placeholder="{{ __('words.state_province') }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="postal_code"
                                                    class="form-label">{{ __('words.postal_code') }}</label>
                                                <input type="text" name="shipping[postal_code]"
                                                    class="form-control" id="postal_code"
                                                    placeholder="{{ __('words.postal_code') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="country"
                                                    class="form-label">{{ __('words.country') }}</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ Sohoj::getCountries()[$shipping->first()->getAttributes()['country_code']] }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="intl-phone2"
                                                    class="form-label">{{ __('words.phone') }}</label>
                                                <input type="tel" name="shipping[phone]" class="form-control"
                                                    id="intl-phone2" value="{{ auth()->user()->contact_number }}"
                                                    placeholder="{{ __('words.phone') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email"
                                                    class="form-label">{{ __('words.email') }}</label>
                                                <input type="email" value="{{ auth()->user()->email }}"
                                                    name="shipping[email]" class="form-control" id="email"
                                                    placeholder="{{ __('words.email') }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="special_instructions"
                                                    class="form-label">{{ __('words.special_instructions') }}
                                                    ({{ __('words.optional') }})</label>
                                                <textarea name="shipping[special_instructions]" class="form-control" id="special_instructions" rows="3"
                                                    placeholder="{{ __('words.special_instructions_placeholder') }}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('magazines.show', $magazine) }}" class="btn"
                            style="background-color: #28BADF; color: #ffff">
                            <i class="fa-solid fa-chevron-left"></i>
                            {{ __('words.go_back') }}
                        </a>
                        <button type="submit" class="btn" style="background-color: #28BADF; color: #ffff">
                            {{ __('words.proceed_to_payment') }}
                        </button>
                    </div>
                </form>
            </div>

        @endif
    </div>

    <x-slot name="js">
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                const countryInput = document.getElementById('country');
                const priceInput = document.getElementById('price');
                const shippingPriceDisplay = document.getElementById('shipping-price');
                const totalDisplay = document.getElementById('calculated-total');

                const subtotal = parseFloat("{{ $cart->getTotal() }}") || 0;
                const discount = parseFloat(
                    "{{ $coupon ? $coupon->getCalculatedValue($cart->getSubTotal()) : null }}") || 0;

                function updateTotal(shipping = 0) {
                    const total = (subtotal - discount + shipping);
                    if (shippingPriceDisplay) shippingPriceDisplay.textContent = 'Є' + shipping.toFixed(2);
                    if (totalDisplay) totalDisplay.textContent = 'Є' + total.toFixed(2);
                    if (priceInput) priceInput.value = shipping;
                }

                function fetchShippingPrice() {
                    const country = countryInput.value;
                    if (country) {
                        fetch(`/get-shipping-price?country=${encodeURIComponent(country)}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data && data.price) {
                                    updateTotal(parseFloat(data.price));
                                } else {
                                    updateTotal(0);
                                }
                            });
                    }
                }

                if (countryInput) {
                    countryInput.addEventListener('change', fetchShippingPrice);
                }

                // Initialize
                updateTotal(0);
            });
        </script> --}}
        <script>
            $(document).ready(function() {


                var countryData = window.intlTelInputGlobals.getCountryData();


                input = document.querySelector("#intl-phone2"),
                    addressDropdown = document.querySelector("#country");

                // init plugin
                var iti = window.intlTelInput(input, {
                    separateDialCode: true,
                    hiddenInput: $("#intl-phone2").attr('name'),
                    preferredCountries: ["pt", 'es'],
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // just for formatting/placeholders etc
                });

                // populate the country dropdown
                for (var i = 0; i < countryData.length; i++) {
                    var country = countryData[i];
                    var optionNode = document.createElement("option");
                    optionNode.value = country.iso2;
                    var textNode = document.createTextNode(country.name);
                    optionNode.appendChild(textNode);
                    // addressDropdown.appendChild(optionNode);
                }

            });
        </script>
    </x-slot>
</x-magazine-checkout-layout>
