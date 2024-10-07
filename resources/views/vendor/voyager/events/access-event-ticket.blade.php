@extends('voyager::master')
@section('page_title', $event->title . ' Tickets')
@section('css')
    <style>
        /* Your existing CSS styles */
        .pill {
            border-radius: 8px;
            padding: 4px 10px;
        }

        .pill-success {
            color: rgb(5, 202, 38);
            background-color: rgba(172, 255, 47, 0.325);
        }

        .pill-secondary {
            color: rgb(59, 59, 59);
            background-color: rgba(27, 27, 27, 0.325);
        }

        .pill-danger {
            color: rgb(160, 0, 0);
            background-color: rgba(251, 1, 1, 0.325);
        }

        .pill-warning {
            color: rgb(160, 56, 0);
            background-color: rgba(160, 56, 0, 0.343);
        }

        .card {
            text-align: center;
            padding: 20px;
            width: 100%;
            border-radius: 10px;
            border: 2px solid #EF5927 !important;
            transition: .2s ease-in;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            box-shadow: 5px 5px #EF5927;
        }

        .card h3 {
            text-transform: uppercase;
            font-weight: bold;
            margin: 0px;
            font-size: 30px;
            color: #EF5927;
            font-family: Arial, Helvetica, sans-serif;
        }

        .card h1 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #4A4A4A;
        }

        .card p {
            color: #777;
            margin: 5px 0;
        }

        .quantity-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 15px 0;
        }

        .quantity-controls button {
            background-color: #EF5927;
            border: none;
            border-radius: 5px;
            padding: 0px;
            color: white;
            font-size: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 40px;
        }


        .quantity-controls span {
            margin: 0 10px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endsection

@section('javascript')
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script>
        var table = $('#dataTable').DataTable();
    </script>
@endsection

@section('content')
    <div class="container">
        <h1>
            {{ $event->name }} - Analytics
        </h1>

        <hr>
        @include('vendor.voyager.events.partial.buttons')
        <hr>
        <div class="container">
            <div class="panel">
                <div class="panel-body">
                    <form action="{{ route('voyager.events.customer.analytics.tickets.access-ticket-submit',[$event,$user]) }}"
                        method="post">
                        @csrf
                        <input type="hidden" name="name" value="{{$user->name}} {{$user->l_name}}">
                        <input type="hidden" name="vatNumber" value="">
                        <input type="hidden" name="address" value="">
                        <div class="row">
                            @foreach ($tickets as $index => $ticket)
                                <div class="col-md-4">
                                    <div class="card" style="margin-bottom: 25px !important">
                                        <h1>{{ $ticket->name }}</h1>
                                        <h5 style="display: inline">{{ $ticket->start_date->format('d M') }} - </h5>
                                        <h5 style="display: inline">{{ $ticket->end_date->format('d M') }}</h5>

                                        <div class="quantity-controls">
                                            <select  name="tickets[{{ $ticket->id }}]"
                                                @if ($ticket->sold_out) disabled @endif
                                                data-price="{{ $ticket->currentPrice() }}"
                                                min="0" max="{{ $ticket->quantity }}"
                                                class="ticket-select" >
                                                <option value="">0</option>
                                                @for ($i = 1; $i <= 30; $i++)
                                                    <option value="{{ $i }}">
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-custom">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Filter and Search Form -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.increase').forEach(function(button) {
                button.addEventListener('click', function() {
                    const index = button.getAttribute('data-index');
                    let quantityDisplay = document.getElementById('quantity-' + index);
                    let hiddenQuantityInput = document.getElementById('hidden-quantity-' + index);
                    let quantity = parseInt(quantityDisplay.textContent);
                    quantity++;
                    quantityDisplay.textContent = quantity;
                    hiddenQuantityInput.value = quantity;
                });
            });

            document.querySelectorAll('.decrease').forEach(function(button) {
                button.addEventListener('click', function() {
                    const index = button.getAttribute('data-index');
                    let quantityDisplay = document.getElementById('quantity-' + index);
                    let hiddenQuantityInput = document.getElementById('hidden-quantity-' + index);
                    let quantity = parseInt(quantityDisplay.textContent);
                    if (quantity > 1) {
                        quantity--;
                        quantityDisplay.textContent = quantity;
                        hiddenQuantityInput.value = quantity;
                    }
                });
            });
        });
    </script>
@endsection
