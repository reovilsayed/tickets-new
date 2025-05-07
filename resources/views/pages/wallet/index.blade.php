@extends('layouts.app')

@section('css')
    <style>
        .qr-button {

            outline: none;
            background-color: #F2500B;
            padding: 20px;
            color: #061030ff;
            border-radius: 10px;
            transition: .3s ease-in;
        }

        .btn-check:checked+.qr-button {

            outline: none;
            background-color: #061030ff;
            padding: 20px;
            color: #F2500B;
            border-radius: 10px;
        }

        .qr-button:hover {

            outline: none;
            background-color: #061030ff;
            padding: 20px;
            color: #F2500B;
            border-radius: 10px;
        }

        .card-drop-shadow {
            box-shadow: 5px 5px 0px #F2500B;

        }

        .info-card {
            box-shadow: 5px 5px 0px #F2500B;
            padding: 15px;
            background: #fff;
        }

        .info-card h3 {
            font-size: 20px
        }

        .info-card p {
            margin: 0px;
            text-align: right;
            padding: 0px;
            font-size: 30px;
        }
    </style>
@endsection

@section('content')
    <div class="main rooms1 section-padding ">
        <div class="container">


            <div class="row g-4">
                <div class="col-md-5">

                    @if ($customer)
                        <div class="card card-drop-shadow" style="border-radius: 0px">
                            <div class="card-body text-center">
                                <h3 class="mb-0">
                                    {{ $customer->fullName() }}
                                </h3>
                                <small>
                                    {{ $customer->email }}
                                </small>
                                <br>
                                <small>
                                    {{ $customer->contact_number }}
                                </small>

                                <h3>
                                    {{ Sohoj::price($customer->balance) }}
                                </h3>
                                <form action="{{ route('wallet.withdrawRefund') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">
                                            Amount
                                        </label>
                                        <input type="hidden" name="user" value="{{ $customer->id }}">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">Є</span>
                                            <input type="number" name="amount" min="0" class="form-control">
                                            <div class="btn-group" role="group"
                                                aria-label="Basic checkbox toggle button group">
                                                <input type="radio" name="type" class="btn-check" id="refund"
                                                    value="refund" autocomplete="off">
                                                <label class="qr-button" style="padding: 10px;border-radius:0px"
                                                    for="refund">Refund</label>

                                                <input type="radio" checked name="type" class="btn-check"
                                                    id="deposit" value="deposit" autocomplete="off">
                                                <label class="qr-button" style="padding: 10px;border-radius:0px"
                                                    for="deposit">Deposit</label>

                                            </div>

                                        </div>
                                        <button class="qr-button mt-2" style="padding: 10px;border-radius:0px">
                                            Complete Transaction
                                        </button>
                                        <a href="{{ route('wallet.dashboard') }}" class="qr-button mt-2"
                                            style="padding: 10px;border-radius:0px">
                                            Reset
                                        </a>
                                </form>
                                {{-- <div class="d-flex mt-3 gap-2 justify-content-center">

                                        <button type="submit" class="qr-button" style="padding: 10px;border-radius:0px">
                                            <i class="fa fa-minus"></i> Refund
                                        </button>
                                        <button type="submit" class="qr-button" style="padding: 10px;border-radius:0px">
                                            <i class="fa fa-plus"></i> Deposit
                                        </button>
                                    </div> --}}
                            </div>
                        </div>

                </div>
            @else
                <div class="card card-drop-shadow" style="border-radius: 0px">
                    <div class="card-body text-center">
                        <button class="qr-button" id="qrButton">
                            <i class="fa-solid fa-qrcode fa-6x"></i>
                        </button>
                        <p class="h5 my-3">
                            Or
                        </p>
                        <div class="form-group">
                            <label for="" class="mb-3">
                                Search by email or phone
                            </label>
                            <form action="{{ route('wallet.dashboard') }}" method="get">
                                <div class="input-group">
                                    <input type="text" name="user" placeholder="Enter email or phone"
                                        class="form-control p-1 m-0">
                                    <button class="qr-button p-3">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-7">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">

                        <div class="info-card ">
                            <h3>
                                Today Deposit
                            </h3>
                            <p>
                                {{ Sohoj::price($todayDeposit) }}
                            </p>
                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="info-card ">
                            <h3>
                                Today Refund
                            </h3>
                            <p>
                                {{ Sohoj::price($todayRefund) }}
                            </p>
                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="info-card ">
                            <h3>
                                Total Transaction
                            </h3>
                            <p>
                                {{ Sohoj::price($todayDeposit + $todayRefund) }}
                            </p>
                        </div>

                    </div>


                </div>
                <div class="card card-drop-shadow" style="border-radius: 0px">
                    <div class="card-body">
                        <h3>
                            Transactions
                        </h3>

                        <table class=" table text-center">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>
                                        {{ Sohoj::price($transaction->amount) }}
                                    </td>
                                    <td>
                                        {{ $transaction->transactionalbe->fullName() }} ({{$transaction->transactionalbe->id}})
                                    </td>
                                    <td>
                                        {{ $transaction->description }}
                                    </td>
                                    <td>
                                        {{ $transaction->created_at->format('d M, Y h:i A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $transactions->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan QR Code</h5>
                </div>
                <div class="modal-body">
                    <button class="close-scanner" id="closeScanner">
                        <i class="fas fa-times"></i>
                    </button>
                    <div id="qr-reader"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Include the QR Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            let html5QrCodeScanner;
            const qrScannerModal = new bootstrap.Modal(document.getElementById('qrScannerModal'));

            // Open QR Scanner when button is clicked
            $('#qrButton').click(function() {
                qrScannerModal.show();

                // Delay scanner initialization until modal is fully shown
                setTimeout(() => {
                    initializeQrScanner();
                }, 500);
            });

            // Close scanner when X button is clicked
            $('#closeScanner').click(function() {
                stopQrScanner();
                qrScannerModal.hide();
            });

            // Clean up when modal is closed
            $('#qrScannerModal').on('hidden.bs.modal', function() {
                stopQrScanner();
            });

            function initializeQrScanner() {
                // This method will be called when a QR is successfully scanned
                function onScanSuccess(decodedText) {
                    // Stop the scanner
                    stopQrScanner();

                    // Close the modal
                    qrScannerModal.hide();

                    // Redirect with the scanned data
                    window.location.href = "{{ route('wallet.dashboard') }}?qr=" + encodeURIComponent(decodedText);
                }

                function onScanFailure(error) {
                    // Handle scan failure (optional)
                    console.warn(`QR error = ${error}`);
                }

                // Create new scanner instance
                html5QrCodeScanner = new Html5QrcodeScanner(
                    "qr-reader", {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    /* verbose= */
                    false
                );

                // Render the scanner
                html5QrCodeScanner.render(onScanSuccess, onScanFailure);
            }

            function stopQrScanner() {
                if (html5QrCodeScanner) {
                    html5QrCodeScanner.clear().catch(error => {
                        console.error("Failed to clear QR scanner", error);
                    });
                }
            }
        });
    </script>
@endsection
