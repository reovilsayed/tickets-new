@extends('voyager::master')
@section('page_title', $event->title . 'Orders')
@section('css')
    <style>
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
            widtd: 100%;
            border-radius: 10px;

            border: 2px solid #EF5927 !important;
            transition: .2s ease-in;
        }

        .card:hover {
            box-shadow: 5px 5px #EF5927;
        }

        .card h3 {
            text-transform: uppercase;
            font-weight: bold;
            margin: 0px;
            font-size: 20px;
            color: #EF5927;
            font-family: Arial, Helvetica, sans-serif;
        }

        .card h1 {
            font-size: 50px;
            font-weight: bold;
            color: #000;
        }

        h1 {
            font-size: 40px;
            font-weight: bold;
            color: #000;
        }

        .search-group {
            align-items: center;
            display: grid;
            grid-template-columns: 8fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        .search-group input,
        .form-control {
            padding: 0px 20px;
            height: 40px;
            border-radius: 20px;
            outline: none;
            box-shadow: none;
            border: 1px solid #EF5927;
            color: #000;
            font-weight: bold;
        }

        .search-group button {
            height: 40px;
            border-radius: 20px;
        }

        .content-wrapper {
            max-height: 100px;
            overflow: scroll;
            transition: max-height 0.3s ease;
            overflow-x: hidden;
        }

    </style>
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endsection
@section('javascript')
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script>
        var table = $('#dataTable').DataTable()
    </script>
@endsection
@section('content')
    <div class="container">
        <h1>{{ $event->name }} - Analytics</h1>
        <hr>
        @include('vendor.voyager.events.partial.buttons')
        <hr>
        <form action="">
            <div class="row">
                <div class="col-md-4">

                    <div class="form-group">
                        <input value="{{ request()->date }}" name="date" type="date" id="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="staff" id="staff" class="form-control">
                            <option value="">Select Staff</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}" @selected($staff->id == request('staff'))>{{ $staff->fullName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="search-group">
                        <button class="btn btn-custom"><i class="voyager-search"></i></button>
                    </div>
                </div>

            </div>
        </form>
        <div class="panel">
            <div class="panel-body">

                <h1 class="p-3">Zone Summary</h1>
                <div class="row mb-5">

                    @foreach ($zones as $zone)
                        <div class="col-md-3">
                            @include('vendor.voyager.events.partial.card', [
                                'label' => $zone->zone->name,
                                'value' => $zone->total,
                            ])
                        </div>
                    @endforeach
                </div>

                <h1 class="p-3">Product Summary</h1>
                <div class="row">

                    @foreach ($products as $product)
                        <div class="col-md-3">
                            @include('vendor.voyager.events.partial.card', [
                                'label' => $product->name,
                                'value' => $product->total,
                            ])
                        </div>
                    @endforeach
                </div>



                <form action="{{ route('voyager.events.checkinReport.analytics', $event) }}" method="get">

                    <div class="search-group">
                        <input type="text" name="q" placeholder="Search" value="{{ request()->q }}">
                        <button class="btn btn-custom"><i class="voyager-search"></i></button>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <select name="ticket" class="form-control">
                                <option value="">Select Ticket</option>
                                @foreach ($event->products as $product)
                                    <option value="{{ $product->id }}" @if ($product->id == request()->ticket) selected @endif>
                                        {{ $product->internal_name ?? $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="zone" class="form-control">
                                <option value="">Select Zone</option>
                                @foreach ($event->zones as $zone)
                                    <option value="{{ $zone->id }}" @if ($zone->id == request()->zone) selected @endif>
                                        {{ $zone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="1" @selected(request('status') === '1')>Checked In</option>
                                <option value="2" @selected(request('status') === '2')>Not Checked In</option>
                            </select>
                        </div>
                    </div>
                </form>
                @if ($tickets->count())
                    <table class="table table-primary">
                        <thead>
                            <tr style="background-color:#EF5927">
                                <td class="text-center">Name</td>
                                <td class="text-center">Email</td>
                                <td class="text-center">Phone Number</td>
                                <td class="text-center">ID</td>
                                <td class="text-center">Ticket</td>
                                <td class="text-center">Extra</td>
                                <td class="text-center">Logs</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr class="text-center">
                                    <td>
                                        @if (isset($ticket->owner->name))
                                            {{ $ticket?->owner?->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($ticket->owner->email))
                                            {{ $ticket?->owner->email }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($ticket->owner->phone))
                                            {{ $ticket?->owner->phone }}
                                        @endif
                                    </td>
                                    <td>{{ $ticket->ticket }}</td>
                                    <td>{{ $ticket->product->name }}</td>
                                    <td>{{ $ticket->extra_info }}</td>
                                    <td>
                                        <div class="content-wrapper">
                                            @foreach ($ticket->scans as $scan)
                                                <p class="mb-1 text-{{ $scan->isCheckedIn() ? 'success' : 'danger' }}">
                                                    {{ $scan->action }} - {{ $scan->created_at->format('d M y g:i A') }}
                                                </p>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">
                        <h3>Nothing found</h3>
                        <a class="text-primary" href="{{ route('voyager.events.checkinReport.analytics', $event) }}">
                            Go back
                        </a>
                    </div>
                @endif

                {{ $tickets->appends(request()->query())->render('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
