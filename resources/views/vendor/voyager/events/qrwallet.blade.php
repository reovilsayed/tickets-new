@extends('voyager::master')

@section('page_title', 'QR Wallet Report')

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
                {{-- Summary Cards --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Deposit (Cash In)',
                            'value' => Sohoj::price($overallDeposit),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Refund (Cash Out)',
                            'value' => Sohoj::price($overallRefund),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Total Balance',
                            'value' => Sohoj::price($overallTotal),
                        ])
                    </div>
                </div>

                {{-- Staff-wise Summary Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Deposit (Cash In)</th>
                                <th>Refund (Cash Out)</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($walletUserSummaries as $summary)
                                <tr>
                                    <td>{{ $summary['user']->name }} {{ $summary['user']->l_name }}</td>
                                    <td><span class="pill pill-success">+ {{ Sohoj::price($summary['deposit']) }}</span>
                                    </td>
                                    <td><span class="pill pill-danger">- {{ Sohoj::price($summary['refund']) }}</span></td>
                                    <td><strong>{{ Sohoj::price($summary['total']) }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
