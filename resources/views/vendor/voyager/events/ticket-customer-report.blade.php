@extends('voyager::master')

@section('page_title', $event->title . ' Customer')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .search-group {
            display: flex;
            margin-bottom: 20px;
        }

        .search-group input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
        }

        .search-group button {
            border-radius: 0 4px 4px 0;
        }

        .card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #qr-code-container {
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #eee;
            display: inline-block;
        }

        .btn-custom {
            margin: 0 5px;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            height: 60%;
            max-height: 500px;
            max-width: 500px;
        }

        .close {
            color: #ff0000 !important;
            float: right;
            font-size: 28px;
        }

        .close:hover {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #qrCode {
            display: flex;
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>{{ $event->name }} - Analytics</h1>
        <hr>
        @include('vendor.voyager.events.partial.buttons')
        <hr>

        <div class="container">
            <form action="{{ route('voyager.events.customer.analytics', $event) }}" method="get">
                <div class="search-group">
                    <input type="text" name="q" placeholder="Search" value="{{ request()->q }}">
                    <button class="btn btn-custom"><i class="voyager-search"></i></button>
                    <a href="{{ route('voyager.events.customer.analytics', $event) }}" class="btn btn-custom"><i
                            class="voyager-refresh"></i></a>
                </div>
            </form>

            @if ($users->isNotEmpty())
                @foreach ($users as $user)
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div
                                    style="display: flex;flex-direction:column;gap:10px;align-items:center;justify-content;center">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ $user->uniqid }}&color=ef5927"
                                        alt="" height="80" width="80">
                                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $user->uniqid }}&color=ef5927"
                                        class="btn btn-custom" download="{{ $user->id }}_{{ $user->name }}_qr"
                                        target="">
                                        Download QR Code
                                    </a>
                                </div>
                                <div>
                                    <h3>{{ $user->name . ' ' . $user->l_name }}</h3>
                                    <p style="margin: 0px;">{{ $user->email }}</p>
                                    <p style="margin: 0px;">{{ $user->contact_number }}</p>
                                    <p style="margin: 0px;">{{ $user->vatNumber }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('voyager.events.customer.analytics.orders', ['event' => $event, 'user' => $user]) }}"
                                        class="btn btn-custom">
                                        View Orders
                                    </a>
                                    <a href="{{ route('voyager.events.customer.analytics.tickets', ['event' => $event, 'user' => $user]) }}"
                                        class="btn btn-custom">
                                        View Tickets
                                    </a>
                                    <a href="{{ route('digital-wallet', $user) }}" class="btn btn-custom">
                                        Wallet Link
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#scanQrModal"
                                        data-user-id="{{ $user->id }}" class="btn btn-custom">
                                        Scan QR Code
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $users->links() }}
            @else
                <div class="text-center">
                    <h3>Nothing found</h3>
                    <a class="text-primary" href="{{ route('voyager.events.customer.analytics', $event) }}">Go back</a>
                </div>
            @endif
        </div>
    </div>

    <!-- QR Code Modal -->
    <div class="modal fade" id="scanQrModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Scan QR Code</h4>
                </div>
                <div class="modal-body">
                    <div id="reader" style="width: 100%; height: auto;"></div>

                    <p id="scanResult" class="text-success mt-3"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    <!-- Bootstrap 3 JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>


    <script>
        var html5QrCode;
        var userIdToAssign = null;

        $('#scanQrModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            userIdToAssign = button.data('user-id');
        });

        $('#scanQrModal').on('shown.bs.modal', function() {
            html5QrCode = new Html5Qrcode("reader");

            // Slight delay to make sure the modal is rendered fully
            setTimeout(function() {
                html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeMessage => {
                        $('#scanResult').text("Scanned: " + qrCodeMessage);

                        // Stop scanning after successful read
                        html5QrCode.stop().then(() => {
                            // Assign uniqid via AJAX
                            $.ajax({
                                url: "{{ route('update-uniqid') }}",
                                method: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    user_id: userIdToAssign,
                                    uniqid: qrCodeMessage
                                },
                                success: function() {
                                    alert("Uniqid assigned successfully!");
                                    $('#scanQrModal').modal('hide');
                                },
                                error: function() {
                                    alert("Failed to assign uniqid.");
                                }
                            });
                        });
                    },
                    error => {
                        // Optional error callback
                    }
                ).catch(err => {
                    console.error("Camera init error:", err);
                    alert("Camera error: " + err);
                });
            }, 1000); // Delay slightly for Bootstrap 3
        });

        $('#scanQrModal').on('hide.bs.modal', function() {
            if (html5QrCode) {
                html5QrCode.stop().catch(err => {
                    console.error("Stop failed", err);
                });
            }
        });
    </script>

@endsection
