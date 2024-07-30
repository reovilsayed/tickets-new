@extends('layouts.user_dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        {{-- @if (setting('site.user_settings_info'))
            <div class="card shadow mb-3">
                <div class="card-body">
                    {!! setting('site.user_settings_info') !!}
                </div>
            </div>
        @endif --}}
        <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
            <div class="ec-vendor-card-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="ec-vendor-block-profile">
                            <div class="ec-vendor-block-img space-bottom-30">
                                <div>

                                    <p>Hello, <span>{{ Auth::user()->name }}!</span></p>
                                    <h4 class="mb-4">Personal Information</h4>
                                    <p>Name: {{ Auth::user()->name }}</p>
                                    <p>Email: {{ Auth::user()->email }}</p>

                                    <p>Phone:
                                        @if (Auth::user()->contact_number)
                                            {{ Auth::user()->contact_number }}
                                        @else
                                            <a href="{{ route('user.update_profile') }}" class="text-success">Add a contact
                                                number? </a>
                                        @endif

                                    </p>
                                </div>
                                {{-- <div class="border mt-4" style="border-bottom: 1px;color: #eeeeee">
                                </div> --}}
                                {{-- <div class="mb-2">
                                    @if (auth()->user()->role_id == 3)
                                        @if (auth()->user()->shop)
                                            <h4 class="mb-4 mt-4">Seller account</h4>
                                            <p>Name: {{ Auth::user()->shop->name }}</p>
                                            <p>Email: {{ Auth::user()->shop->email }}</p>
                                            <p>Phone:
                                                @if (Auth::check() && Auth::user()->phone)
                                                    {{ Auth::user()->shop->phone }}
                                                @endif
                                            </p>
                                            <a class="text-success" href="{{ route('vendor.shop') }}">Update shop info?</a>
                                            <h4 class="mt-4">Shop address</h4>
                                            <p>Address: {{ Auth::user()->shop->company_registration }}</p>
                                        @endif
                                    @else
                                        <a href="{{ route('user.become.seller') }}" class="text-primary"
                                            style="text-decoration: underline; font-size:16px">Become a seller?</a>
                                    @endif
                                </div> --}}
                                {{-- <div class="border mt-4 mb-3" style="border-bottom: 1px;color: #eeeeee">
                                </div> --}}


                                {{-- <h6 class=" px-0 py-2"
                                    style="   border: none;
                                background: none;">Default
                                    address </h6> --}}
                                {{-- 
                                @if (Auth()->user()->addresses->count() == !0)
                                    @foreach (Auth()->user()->addresses as $address)
                                        <div class="mb-1">
                                            <span>Address-{{ $loop->index + 1 }}:
                                                {{ $address->country }},
                                                {{ $address->state }},
                                                <br>{{ $address->city }} ,
                                                {{ $address->address_1 }},
                                                {{ $address->address_2 }},
                                                {{ $address->post_code }}</span> <br>
                                        </div>
                                        <div class="mt-1 mb-4 col-md-4"><a
                                                href="{{ route('user.address-edit', $address->id) }}"
                                                class="text-success">Edit Address</a>
                                            <a href="{{ route('user.address.destroy', $address) }}"
                                                onclick="return confirm('Are you sure you want to delete this Address?');"
                                                class="text-danger">Remove Address</a>
                                        </div>
                                    @endforeach
                                @endif --}}
                                {{-- <a href="javascript::void(0);" class="text-decoration-underline" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Add Address
                                </a> --}}
                                {{-- <h6 class=" px-0 py-2"
                                    style="   border: none;
                                background: none;">Credit/Debit
                                    Cards </h6> --}}
                                @php
                                    $methods = auth()->user()->paymentMethods();
                                @endphp
                                <div class="row">

                                    @foreach ($methods as $payment)
                                        <div class="col-md-6 col-12">
                                            <div class="card rounded shadow ">
                                                <div class="card-body ">
                                                    <h2>{{ ucwords($payment->card->brand) }}</h2>

                                                    <div class="d-flex justify-content-between">

                                                        <h5 style="float:right"> XXXX XXXX
                                                            XXXX
                                                            {{ $payment->card->last4 }}</h5>
                                                        <h5>
                                                            {{ $payment->card->exp_month }}/{{ $payment->card->exp_year }}
                                                        </h5>
                                                    </div>
                                                    <p>
                                                        {{ $payment->billing_details->name }}
                                                    </p>
                                                </div>

                                                <div class="card-footer">

                                                    @if (auth()->user()->getCard()->id == $payment->id)
                                                        <span class="text-success btn">Default</span>
                                                    @else
                                                        <a href="{{ route('user.setCardAsDefault', ['method' => $payment->id]) }}"
                                                            class="text-primary btn">Set as default</a>
                                                    @endif


                                                    <a href="{{ route('user.removeCard', ['method' => $payment->id]) }}"
                                                        class="text-danger btn" style="float:right">Remove</a>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>



                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Personal Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('user.address.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">

                                <input type="text" name="address_1" value="" required
                                    class="form-control mb-2 @error('address_1') is-invalid @enderror" id="inputAddress"
                                    placeholder="Street Address">
                                @error('address_1')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12">

                                <input type="text" name="address_2" placeholder="Address 2" required
                                    class="form-control mb-2 @error('address_2') is-invalid @enderror" value=""
                                    id="inputAddress2">
                                @error('address_2')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">

                                <x-country />
                            </div>
                            <div class="col-md-6">

                                <x-state />
                            </div>
                            <div class="col-md-6">

                                <input type="text" placeholder="City" required value="" name="city"
                                    class="form-control my-2 @error('city') is-invalid @enderror" id="inputPassword4">
                                @error('city')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="number" required
                                    class="form-control my-2 @error('post_code') is-invalid @enderror" value=""
                                    name="post_code" placeholder="Zip/Postal Code" id="inputEmail4">
                                @error('post_code')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
