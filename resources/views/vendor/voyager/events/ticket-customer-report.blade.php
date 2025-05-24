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
                    <a href="{{ route('voyager.events.customer.analytics', $event) }}"   class="btn btn-custom"><i
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
                                    <a href="{{ route('update-uniqid', ['user_id' => $user->id]) }}" class="btn btn-custom ">
                                        Generate QR Code
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
    <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">QR Code for <span id="qrUserName" style="color: #EF5927"></span></h4>
                </div>
                <div class="modal-body">
                    <div id="qrCode" class="d-flex justify-content-center mb-3"></div>
                    <p id="uniqidText" class="font-weight-bold text-primary"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 3 JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function generateUniqid27() {
            const prefix = '01'; // fixed start
            const randomLength = 27 - prefix.length;

            const randomPart = Array.from(crypto.getRandomValues(new Uint8Array(32)))
                .map(b => b.toString(36).padStart(2, '0'))
                .join('')
                .substring(0, randomLength);

            return prefix + randomPart;
        }

        $(document).ready(function() {
            $('#qrCodeModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                var userName = button.data('user-name');

                var newUniqid = generateUniqid27();

                $.ajax({
                    url: "{{ route('update-uniqid') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        uniqid: newUniqid
                    },
                    success: function() {
                        $('#qrUserName').text(userName);
                        var qrContainer = $('#qrCode');
                        qrContainer.empty();

                        new QRCode(qrContainer[0], {
                            text: newUniqid,
                            width: 200,
                            height: 200
                        });
                    }
                });
            });
        });
    </script>

@endsection
