@extends('layouts.app')

@section('css')
    <style>
        .scanner-page {
            min-height: 100vh;
            background-color: #f36a30;

        }

        .status {
            padding: 10px;
        }

        .status .box {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .status .box img {
            height: 150px;
            width: 150px;
        }

        .status .box h3 {
            color: #000;
            font-weight: 700;
        }

        .scanner-header {
            min-height: 30vh;
        }

        .scanner-header h4 {

            margin: 0px;
        }

        .scanner-header .event-name {
            background-color: #fff;
            padding: 20px 10px;
            text-align: center;
            font-weight: bold;
            color: black;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        .scanner-header .door-name {
            /* background-color: #fff; */
            padding: 20px 10px !important;
            text-align: center;
            font-weight: bold;
            color: #fff;

            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        .add-new-session {
            transition: .2s ease-in;
            padding: 10px;
            text-align: center;
            color: black;
            background-color: #fff;
            width: 100%;
            margin-bottom: 2px;
        }

        .add-new-session:hover {
            background-color: #cfc1bb !important;
        }

        .scanner-inner {
            padding-top: 20px;
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
        }

        .qr-image {
            height: 150px;
            width: 150px;
        }

        .qr-box h3 {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-weight: thin;
            color: #fff;
            text-transform: lowercase;
        }

        .qr-box {
            cursor: pointer;
            gap: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .qr-box:hover .qr-image {
            transform: scale(1.1);
        }

        #video-container {
            position: relative;
            display: flex;
            justify-content: center !important;
            align-items: center !important;
            width: 100%;
        }

        #qr-video {
            width: 100%;
            overflow: hidden;
        }

        #viewfinder {

            display: none;
            /* Initially hide the viewfinder */
        }

        .status {
            background-color: #fff;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('assets/js/qr/qr-scanner.min.js') }}" type="module"></script>
    <script type="module">
        import QrScanner from "{{ asset('assets/js/qr/qr-scanner.min.js') }}";

        const video = document.getElementById('qr-video');
        const camQrResult = document.getElementById('cam-qr-result');
        const qrBox = document.querySelector('.qr-box');
        const viewfinder = document.getElementById('viewfinder');
        const result = document.getElementById('result');

        function setResult(result) {
            scanner.stop();

            fetch("{{ route('api.extras-scan-ticket') }}", {
                    method: "POST",
                    body: JSON.stringify({
                        ticket: result.data,
                        zone: "{{ $zone->id }}",
                        checksum: "{{ Hash::make(env('SECURITY_KEY')) }}",
                    }),
                    headers: {
                        "Content-type": "application/json; charset=UTF-8"
                    }
                }).then((response) => response.json())
                .then((json) => {

                    if (json.status == 'success') {

                        let rows = '';
                        for (const key in json.extras) {
                            if (Object.prototype.hasOwnProperty.call(json.extras, key)) {
                                const element = json.extras[key];
                                rows += `
                                 <tr>
                                        <td>
                                           ${element.name}
                                        </td>
                                        <td>
                                          ${element.qty}
                                        </td>
                                        <td>
                                           ${element.used}
                                        </td>
                                    <td>
                                        <input class="form-control text-center" name="withdraw[${element.id}]" min="0" max="${element.qty - element.used}" type="number">
                                    </td>
                                    </tr>
                                `
                            }
                        }
                        document.getElementById('result').innerHTML = `   <form method="post" action="{{ route('extras-used') }}">
                            
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                            <input type="hidden" value="${json.ticket.ticket}" name="ticket" />
                            <input type="hidden" value="{{ session()->get('enter-extra-zone')['id'] }}" name="session"/>
                            <div class="table-responsive">
                             <table class="table text-light">
                                <thead>
                                    <tr class="text-center ">
                                        <th>{{__('words.extra_product_name')}}</th>
                                        <th>{{__('words.extra_product_quantity')}}</th>
                                        <th>{{__('words.extra_product_taken')}}</th>
                                        <th>{{__('words.extra_product_withdraw')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    ${rows}
                                </tbody>
                                <tfoot class="bg-light">
                                     
                                    <td colspan="4">
                                            <button type="submit" class="btn btn-outline-dark border border-dark" style="float:right">{{__('words.give')}}</button>
                                    </td>    
                                    </tfoot>
                            </table>
                            
                        </div>
                        
                        </form>`;
                    } else {
                        toastr.error('something went wrong')
                    }

                });
            qrBox.style.display = 'flex';
          
            viewfinder.style.display = 'none';

        }

        const scanner = new QrScanner(video, result => setResult(result), {
            highlightScanRegion: true,
            highlightCodeOutline: true,
        });

        document.getElementById('qrbox').addEventListener('click', function() {
            qrBox.style.display = 'none';
            viewfinder.style.display = 'block';
            result.innerHTML = '';
            scanner.start();

        })


        window.addEventListener('unload', () => {
            scanner.stop();
        });
    </script>
@endsection

@section('content')
    <section class="scanner-page">
        <br>
        <br>
        <br>
        <div class="scanner-header">
            <h4 class="event-name">
                {{ $event->name }}
            </h4>
            <h4 class="door-name">
                {{ $zone->name }}
            </h4>
            <a href="{{ route('extraszone.enter') }}" class="add-new-session">
                Add new session
            </a>
            <div id="result" class="container my-3">



            </div>
        </div>

        <div class="scanner-inner">
            <div class="qr-box" id="qrbox">
                <img class="qr-image" src="{{ asset('assets/qr-code.png') }}" alt="">
                <h3>
                    Tap to read code
                </h3>
            </div>

            <div id="viewfinder" class="qr-box">
                <div id="video-container">
                    <video id="qr-video"></video>
                </div>
            </div>
        </div>
    </section>
@endsection