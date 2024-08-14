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
        const statusBox = document.getElementById('statusBox');

        function setResult(result) {
            scanner.stop();
            statusBox.style.display = 'block';

            fetch("{{ route('api.scan-ticket') }}", {
                    method: "POST",
                    body: JSON.stringify({
                        ticket: result.data,
                        zone: "{{ $zone->id }}",
                        mode: document.getElementById('mode').value,
                        checksum: "{{ Hash::make(env('SECURITY_KEY')) }}",
                    }),
                    headers: {
                        "Content-type": "application/json; charset=UTF-8"
                    }
                }).then((response) => response.json())
                .then((json) => {

                    if (json.status == 'success') {
                        statusBox.innerHTML = `
             <div class="box" id="log-success">
                    <img src="{{ asset('assets/green-light.png') }}" alt="">
                  
                </div>
            `;
                    } else {
                        statusBox.innerHTML = `
             <div class="box" id="log-error">
                    <img src="{{ asset('assets/red-light.png') }}" alt="">
                    <h5>
                        ${json.message}
                    </h5>
                </div>
            `;
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
            statusBox.style.display = 'none';
            scanner._updateOverlay()
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
            <a href="{{ route('zone.enter') }}" class="add-new-session">
                Add new session
            </a>
            <div class="form-group">
                <select class="form-control text-center w-50 mx-auto" name="mode" id="mode">
                    <option value="1">
                        {{ __('words.check_in') }}
                    </option>
                    <option value="2">
                        {{ __('words.check_out') }}
                    </option>
                </select>
            </div>
            <div id="statusBox" style="display: none;" class="status">


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
