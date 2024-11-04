<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Lato", serif;
            background-color: #001232;
        }

        .cus-card {
            overflow: scroll;
            margin: 0px auto;
            max-width: 500px;
            height: 80vh;
            background-color: #e0e0e0;

            box-shadow: 5px 5px 1px #f3510b;
        }

        .cus-card-header {
            background: rgb(243, 81, 11);
            background: -moz-linear-gradient(10deg, rgba(243, 81, 11, 0.7019140419839811) 0%, rgba(243, 81, 11, 0.17250227727809875) 60%);
            background: -webkit-linear-gradient(10deg, rgba(243, 81, 11, 0.7019140419839811) 0%, rgba(243, 81, 11, 0.17250227727809875) 60%);
            background: linear-gradient(10deg, rgba(243, 81, 11, 0.7019140419839811) 0%, rgba(243, 81, 11, 0.17250227727809875) 60%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#f3510b", endColorstr="#f3510b", GradientType=1);
        }

        .event-thumbnail {

            text-align: center;
        }

        .event-thumbnail>img {

            width: 100%;
            height: 250px;
            object-fit: cover;


        }

        .cus-btn-bar {
            display: flex;
            gap: 10px;
            cursor: all-scroll;
            padding: 15px;
            overflow: scroll;
            text-align: center;

            scrollbar-width: none;
        }

        .cus-btn-bar::-webkit-scrollbar {
            display: none;
        }

        .cus-btn {
            flex-shrink: 0;
            font-size: 15px;
            color: #e0e0e0;
            background-color: #f3510b;
            padding: 10px 10px;

            text-decoration: none;
            transition: background-color .2s ease-in, color .2s ease-in;
        }

        .cus-btn:hover {
            background-color: #e0e0e0;
            color: #f3510b;
        }

        .bdr {
            height: 2px;
            background-color: #f3510b;
            width: 50%;
        }
    </style>
    <title>My Digital Wallet</title>
</head>

<body>
    <main class="py-5">



        <select id="eventFilter" class="form-select mt-2 mx-auto  mb-3" style="max-width: 500px">
            @foreach ($events as $data)
                <option value="{{ $data->id }}" {{ request()->event_id == $data->id ? 'selected' : '' }}>
                    {{ $data->name }}
                </option>
            @endforeach
        </select>




        <div class="cus-card">
            <div class="cus-card-header">
                <div class="event-thumbnail">
                    <img src="{{ Storage::url($event->thumbnail) }}" alt="">
                </div>
                <h3 class="my-2 text-center text-light fw-light">
                    {{ $event->name }}
                </h3>
                <div class="cus-btn-bar">
                    <a class="cus-btn" href="{{ route('digital-wallet', $user) }}"><i class="fa-solid fa-qrcode"></i>
                        {{ __('words.tickets') }}</a>

                    <a class="cus-btn" href="{{ route('digital-wallet', ['user' => $user, 'tab' => 'invoice']) }}"><i
                            class="fa-solid fa-file-invoice"></i>
                        {{ __('words.invoice') }}</a>

                    <a class="cus-btn" href="{{ route('digital-wallet', ['user' => $user, 'tab' => 'info']) }}"><i
                            class="fa-solid fa-circle-info"></i>
                        {{ __('words.information') }}</a>
                    <a class="cus-btn" href="{{ route('digital-wallet', ['user' => $user, 'tab' => 'products']) }}"><i
                            class="fa-solid fa-box"></i>
                        {{ __('words.products') }}</a>
                </div>
            </div>

            @if (request()->tab == 'info')
                <div class="cus-card-body p-2">

                    <div class="card mb-2">
                        <div class="card-body">
                            <p class="p-0 m-0 fs-6">
                                {{ $event->start_at->diffForHumans() }}
                            </p>
                            <p class="fs-4 fw-bold">
                                {{ $event->start_at->format('d M - H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <p class="p-0 m-0 fs-6">
                                {{ __('words.location') }}
                            </p>
                            <p class="p-0 m-0 fs-4">
                                {{ $event->location }}
                            </p>

                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <p class="p-0 m-0 fs-6">
                                {{ __('words.website') }}
                            </p>
                            <a href="{{ $event->website }}" style="text-decoration: none" class="p-0 m-0 fs-4">
                                {{ __('words.visit_website') }}
                            </a>

                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <p class="p-0 m-0 fs-6 fw-bold">
                                {{ __('words.description') }}
                            </p>
                            <hr>
                            <p class="p-0 m-0 fs-4">
                                {!! $event->description !!}
                            </p>

                        </div>
                    </div>
                </div>
            @elseif(request()->tab == 'products')
                <div class="cus-card-body p-2">

                    <table class="table  table-bordered w-50 mx-auto text-center">

                        @foreach ($tickets->pluck('extras')->flatMap(fn($extra) => $extra)->groupBy('name') as $name => $extras)
                            <div class="card  mb-3  shadow-sm " style="border:1px solid #f3510b;">
                                <div class="card-body">
                                    <h4>
                                        {{ $name }}
                                    </h4>
                                    <p>
                                        {{ __('words.remaining') }} :
                                        {{ $extras->sum('qty') - $extras->sum('used') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        <h3 class="text-center p-5">
                            <i class="fa fa-box"></i> {{ __('words.no_product_found') }}
                        </h3>

                </div>
            @elseif(request()->tab == 'invoice')
                <div class="cus-card-body p-2">


                    @foreach ($orders as $order)
                     
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-light fs-6 mb-0">
                                        {{ __('words.toc_online_id') }} :
                                    </p>
                                    <div class="d-flex justify-content-between">

                                        <p class="fw-bold fs-4 mb-0">
                                            #{{ $order->invoice_id ?? 'N/A' }}
                                        </p>
                                        <a class="fw-bold fs-5 mb-0" style="text-decoration: none"
                                        href="
                                        {{ $order->invoice_url }}">{{ __('words.view_invoice') }}</a>
                                    </div>
                                </div>
                            </div>
                    
                    @endforeach




                </div>
            @else
                <div class="cus-card-body p-2">
                    @foreach ($tickets->groupBy('product_id') as $id => $tickets)
                        @php
                            $product = App\Models\Product::find($id);
                        @endphp

                        <div class="card mb-3  shadow-sm " style="border:1px solid #f3510b;">




                            <div class="card-body">
                                <a style="text-decoration:none;color: #f3510b;" class="float-end"
                                    data-bs-toggle="collapse" href="#seeDetails{{ $product->id }}" role="button"
                                    aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                                <p class="fw-normal mb-1 fs-4">
                                    {{ $product->name }} &nbsp;<span style="font-size: 14px"
                                        class=" badge bg-secondary px-2 py-1 ">X
                                        {{ $tickets->count() }}</span>
                                </p>
                                <p class=" text-secondary" style="font-size: 14px">
                                    <i class="far fa-calendar"></i> &nbsp;
                                    {{ $product->start_date->format(' d F H:i') }}
                                </p>
                                <p>

                                    <a style="color:  #f3510b;text-decoration:none"
                                        href="{{ route('download.ticket', ['order' => $tickets[0]->order, 'p' => $product->id]) }}">{{ __('words.view_tickets') }}</a>
                                </p>

                                <div class="collapse" id="seeDetails{{ $product->id }}">

                                    {!! $product->description !!}

                                </div>

                            </div>

                        </div>
                        @endforeach
                    @endif

                </div>



    </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.getElementById('eventFilter').addEventListener('change', function() {
            const selectedEventId = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('event_id', selectedEventId);
            window.location.href = currentUrl;
        });
    </script>

</body>

</html>
