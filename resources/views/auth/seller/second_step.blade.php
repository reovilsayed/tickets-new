@extends('layouts.app')

@section('css')
<style>
       .navbar .navbar-nav .nav-link {
            color: black;
        }
</style>
@endsection
@section('content')
    <section class="mb-5" style="margin-top:100px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        {{-- <h2 class="ec-bg-title">Log In</h2> --}}

                        <h2 class="ec-title">2nd Step Verification
                             {{-- <span class="text-success">AhroMart</span> --}}
                             </h2>
                        <p class="sub-title mb-3">{{ __('Register as vendor') }}</p>
                    </div>
                </div>

                <div class="col-md-10 px-5 " style="box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;">
                    <div class="d-flex justify-content-center text-center mb-4">
                        {{-- <div class="card col-md-11 bg-danger text-white">
                            <div class="card-body">

                                <span>Monthly payment from a shop $24.95</span>
                            </div>
                        </div> --}}
                   


                    </div>
                    <div class="ec-login-container" style="border: none">
                        <div class="ec-login-form">
                            <form method="POST" action="{{ route('vendor.second.step.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <label for="">Personal Info</label>
                                <fieldset class="border p-3">
                                    <div class="row">

                                        <div class="col-md-6 form-group">
                                       
                                            <input id="phone" type="text" placeholder="Phone *"
                                                class=" @error('meta.phone') is-invalid @enderror"
                                                name="meta[phone]" value="{{ old('meta.phone') ?? '' }}" required
                                                autocomplete="phone" autofocus>

                                            @error('meta.phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group ">
                                          
                                            <input id="birth_date" type="date" id="dob"  max="2003-05-29" placeholder="Date Of Birth *"
                                                class="@error('dob') is-invalid @enderror"
                                                name="dob" value="{{ old('dob') ?? '' }}" required
                                                autocomplete="birth_date" autofocus>

                                            @error('dob')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-12 form-group">
                                        
                                            <input id="tax_no" type="text"
                                                placeholder="Leave blank if you don't have an EIN number. *"
                                                class=" @error('tax_no') is-invalid @enderror"
                                                name="tax_no" value="{{ old('tax_no') ?? '' }}" autocomplete="phone"
                                                autofocus>

                                            @error('tax_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>




                                    <div class="row mt-3">
                                        <p>Please provide a valid government ID for identify verification</p>
                                        <div class="col-md-6 form-group">
                                            <label for="govt_id_front">ID Front side <span
                                                    class="text-danger">*</span></label>
                                            <input id="govt_id_front" type="file"
                                                class="  @error('govt_id_front') is-invalid @enderror"
                                                name="govt_id_front" value="{{ old('govt_id_front') ?? '' }}" required
                                                autofocus>

                                            @error('govt_id_front')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <span class="col-md-6 from-group">
                                            <label for="govt_id_back">ID Back side <span
                                                    class="text-danger">*</span></label>
                                            <input id="govt_id_back" type="file" multiple
                                                placeholder="One Government ID for verification"
                                                class=" @error('govt_id_back') is-invalid @enderror"
                                                name="govt_id_back" value="{{ old('govt_id_back') ?? '' }}" required
                                                autofocus>

                                            @error('govt_id_back')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </span>
                                    </div>
                                </fieldset>
                                {{-- <label for="" class="mt-3">Bank Info</label>
                                <fieldset class="border p-3 mt-2">
                                <legend class="text-primary" style="font-size: 15px; font-weight:600;">This info will be used to send sales earnings</legend>
                                    <div class="row">
                                      
                                        <span class="ec-login-wrap col-md-12">
                                            <label for="bank_name">Bank Name<span class="text-danger">*</span></label>
                                            <input id="bank_name" type="text" placeholder="Bank Name"
                                                class="form-control bg-light @error('bank_name') is-invalid @enderror"
                                                name="bank_name" value="{{ old('bank_name') ?? '' }}" required
                                                autocomplete="bank_name" autofocus>

                                            @error('bank_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </span>
                                        <span class="ec-login-wrap col-md-12">
                                            <label for="inputZip" class="form-label">Acount Holder Name <span class="text-danger">*</span></label>
                                            <input type="text" placeholder="Acount Holder Name"
                                                class="form-control bg-light p-2  @error('ac_holder_name') is-invalid @enderror"
                                                value="{{ old('ac_holder_name') }}" name="ac_holder_name"
                                                id="ac_holder_name" required>
                                            @error('ac_holder_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </span>

                                        <span class="ec-login-wrap col-md-6">
                                            <label for="inputZip" class="form-label">Routing Number <span class="text-danger">*</span></label>
                                            <input type="text" placeholder="Routing Transit Number"
                                                class="form-control bg-light p-2  @error('rtn') is-invalid @enderror"
                                                value="{{ old('rtn') }}" name="rtn" id="rtn" required>
                                            @error('rtn')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </span>


                                        <span class="ec-login-wrap col-md-6 ">
                                            <label for="bank_ac">Confirm Routing number<span class="text-danger">*</span></label>
                                            <input id="bank_ac" type="text"
                                                placeholder="Confirm routing number"
                                                class="form-control bg-light @error('rtn_confirmation') is-invalid @enderror"
                                                name="rtn_confirmation" value="{{ old('rtn_confirmation') ?? '' }}"
                                                required autocomplete="rtn_confirmation" autofocus>

                                            @error('rtn_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </span>
                                        <span class="ec-login-wrap col-md-6">
                                            <label for="inputZip" class="form-label">Account Number <span class="text-danger">*</span></label>
                                            <input type="text" placeholder=" Account Number"
                                                class="form-control bg-light p-2  @error('ac_number') is-invalid @enderror"
                                                value="{{ old('ac_number') }}" name="ac_number" id="ac_number" required>
                                            @error('ac_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </span>


                                        <span class="ec-login-wrap col-md-6 ">
                                            <label for="bank_ac">Confirm Acount number<span class="text-danger">*</span></label>
                                            <input id="bank_ac" type="text"
                                                placeholder="Confirm Acount number"
                                                class="form-control bg-light @error('ac_number_confirmation') is-invalid @enderror"
                                                name="ac_number_confirmation" value="{{ old('ac_number_confirmation') ?? '' }}"
                                                required autocomplete="ac_number_confirmation" autofocus>

                                            @error('ac_number_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </span>
                                  
                                    </div>
                                </fieldset> --}}
                                <label class="mt-3" for="">Shop address</label>
                                <fieldset class="border p-3 my-2">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="inputCity">Country<span class="text-danger">*</span></label>
                                            <x-country />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputState" class="">State<span
                                                    class="text-danger">*</span></label>
                                            <x-state />
                                            @error('meta.state')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 
                                        <div class=" col-md-6 form-group">
                                       
                                                <input id="city" type="text" placeholder="City *"
                                                class=" @error('meta.city') is-invalid @enderror"
                                                name="meta[city]" value="{{ old('meta.city') ?? '' }}" required
                                                autocomplete="city" autofocus>
                                                
                                            @error('meta.city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                    
                                            <input type="text" placeholder="post code *"
                                                class="@error('meta.post_code') is-invalid @enderror"
                                                value="{{ old('meta.post_code') }}"
                                                name="meta[post_code]" id="post_code" required>
                                            @error('meta.post_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <span class="form-group col-md-12">

                                            <textarea id="address" placeholder="Street address *"
                                                class=" @error('meta.address') is-invalid @enderror" name="meta[address]" required>{{ old('meta.address') ?? '' }}</textarea>

                                            @error('meta.address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </span>



                                    </div>
                                </fieldset>
                                {{-- <label class="mt-3" for="">Credit/Debit card</label>
                                <fieldset class="border p-3 my-2">
                                <input id="card-holder-name" type="hidden" value="{{ auth()->user()->name }}">
                                <input name="payment_method" id="card-payment-method" type="hidden">



                                <!-- Stripe Elements Placeholder -->
                                <div class="form-group">
                                    <label for="card_info">Provide a valid Credit or Debit card to pay for monthly subscription.
<span class="text-danger">*</span></label>
                                    <div id="card-element" class="form-control bg-light"></div>
                                </div>
                                <p class="mb-2">This card will be take monthly payment every month</p>
                                <div class="d-flex" style="height: 40px;">

                                <input type="checkbox" required class="@error('ismonthly_charge') is-invalid @enderror"id="ismonthly_charge" style="width: 25px;" value="1" name="ismonthly_charge"><a
                                    href="#" style="" class="mt-3 ms-3">Auto pay</span>
                                    @error('ismonthly_charge')
                                    <span class="invalid-feedback " role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>  
                                <button id="card-button" type="button" class="mt-2 px-3"
                                    style="padding:10px;background-color:red;color:white"
                                    data-secret="{{ $intent->client_secret }}">
                                    Verify
                                </button>
                                
                                </fieldset> --}}



                                <div class="d-flex">

                                    <input type="checkbox" required class="@error('terms') is-invalid @enderror"
                                        id="terms"  value="1" name="terms"><a
                                        href="#" style="" class=" ms-3 ">I have
                                        read and agree to the <span>Terms &amp; Conditions</span></a><span
                                        class="checked"></span>
                                    @error('terms')
                                        <span class="invalid-feedback " role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

      
                                    <div class="col-md-12 my-4">
                                        <button type="submit" id="submit"
                                            class="butn-dark2 text-white">
                                            <span>
                                                Submit
                                            </span>
                                        </button>

                      
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var verified = false;
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                console.log(error);
                {{-- document.getElementById('card-payment-method').value = error.setupIntent.payment_method; --}}
                toastr.error(error.message)
            } else {
                document.getElementById('card-button').style.display = "none";
                document.getElementById('submit').disabled = false;
                document.getElementById('card-payment-method').value = setupIntent.payment_method;
                toastr.info('Payment method is verified')
            }
        });
    </script>
@endsection
