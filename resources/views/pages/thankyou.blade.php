@extends('layouts.app')
@section('css')
<style>
    /* svg{
        height: 200px;
    } */
    .navbar .navbar-nav .nav-link {
            color: black;
        }
    .section-space-p{
        margin-top: 70px;
    }
    .eci-check-circle{
        font-size: 50px;
        text-align: center;
        color: #1EBA62;
    }
    .ec-title {
        font-size: 40px;
        text-transform: uppercase;
    }
</style>
    
@endsection

@section('content')

    <!-- Ec Thank You page -->
    <section class="ec-thank-you-page section-space-p my-5">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="ec-thank-you section-space-p">
                        <!-- thank content Start -->
                        <div class="ec-thank-content">
                      
                            <div class="section-title">
                                <h2 class="ec-title text-center">Thank You</h2>
                                {{-- <p class="sub-title">For Shopping with us.</p> --}}
                                <div class="d-flex justify-content-center">
                                    <i class="ecicon eci-check-circle" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                         <div class="d-flex justify-content-center">
                            {{-- {!! QrCode::size(200)->generate($order->order_number) !!} --}}
                         </div>
                        <!--thank content End -->
                        <div class="ec-hunger">
                            <div class="ec-hunger-detial">
                                {{-- <h3>Want to track your order?</h3> --}}
                                {{-- <h6 class="text-center mt-3">This QR code show the product.</h6> --}}
                                {{-- <a href="{{ route('user.ordersIndex') }}" class="btn btn-danger rounded">Track Order</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 
@endsection

