@extends('layouts.app')
@section('content')
    <section class="rooms1 section-padding">
        <div class="container">
            <div class="row pdf">
                <div class="col-md-4">
                    <h3 class="pdf-date">
                        AUG 30,2024
                    </h3>
                    <h4 class="pdf-local">
                        LOCALIZATION
                    </h4>
                    <h3 class="pdf-price">
                        25 $
                    </h3>
                    <h4 class="pdf-final-price">
                        final Price
                    </h4>
                    <h6 class="pdf-tax">
                        Tax include
                    </h6>
                    <div class="pdf-bdr"></div>
                </div>
                <div class="col-md-4">
                    <div class="pdf-logo">
                        <img src="" alt="">
                    </div>
                    <h1 class="pdf-evnt-name">
                        EVENT NAME
                    </h1>
                    <h4 class="pdf-ticket-name">
                        Ticket Name
                    </h4>
                </div>
                <div class="col-md-4">
                    <div class="pdf-bdr"></div>
                    <div class="qr-code">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='' " alt="QR-Code">
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
