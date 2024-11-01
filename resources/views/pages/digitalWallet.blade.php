{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ setting('site.title') }}" />
    <meta property="og:description" content="{{ setting('site.description') }}" />
    <meta property="og:image" content="{{ Voyager::image(setting('site.facebook_image')) }}" />
    <meta name="description" content="{{ setting('site.description') }}">
    <title>{{ setting('site.title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Montserrat';
            background: #f36a30;
        }

        .btn-outline-primary:hover {
            color: #fff;
            background-color: #f36a30;
            border-color: #f36a30;
            box-shadow: 10px 10px 10px rgba(122, 43, 9, 0.501);
        }

        .btn-outline-primary {
            background-color: #fff;
            border-color: #f36a30;
            color: #f36a30;

        }

        a {
            letter-spacing: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <h3 class="text-center text-secondary fs-6" style="letter-spacing: 10px">{{ __('words.welcome') }}
                    {{ $order->billing->name }}</h3>
                <h1 class="fw-thin text-center " style="letter-spacing: 10px">{{ __('words.digital_wallet') }}</h1>

                <div class="d-grid ">
                    <a href="{{ route('download.ticket', $order) }}"
                        class="btn btn-lg btn-outline-primary my-2 d-flex justify-content-center align-items-center"
                        style="height:100px" href=""><span>{{ __('words.my_tickets') }}</span></a>
                    @if ($order->invoice_url)
                        <a href="{{ $order->invoice_url }}"
                            class="btn btn-lg btn-outline-primary my-2 d-flex justify-content-center align-items-center"
                            style="height:100px" href=""><span>{{ __('words.my_invoice') }}</span></a>
                    @endif
                </div>

                @if (count($order->tickets->pluck('extras')->flatMap(fn($extra) => $extra)->groupBy('name')))
                    <h3 class="text-center fw-thin my-3" style="letter-spacing: 10px">
                        {{ __('words.my_products') }}
                    </h3>


                    <table class="table  table-bordered w-50 mx-auto text-center">

                        <tr>
                            <th>
                                {{ __('words.name') }}
                            </th>
                            <th>
                                {{ __('words.total_used') }}
                            </th>
                        </tr>

                        @foreach ($order->tickets->pluck('extras')->flatMap(fn($extra) => $extra)->groupBy('name') as $name => $extras)
                            <tr>
                                <td>
                                    {{ $name }}
                                </td>
                                <td>
                                    {{ $extras->sum('qty') }} / {{ $extras->sum('used') }}
                                </td>

                            </tr>
                        @endforeach


                    </table>
                @endif

            </div>
        </div>
    </div>
</body>

</html> --}}





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ setting('site.title') }}" />
    <meta property="og:description" content="{{ setting('site.description') }}" />
    <meta property="og:image" content="{{ Voyager::image(setting('site.facebook_image')) }}" />
    <meta name="description" content="{{ setting('site.description') }}">
    <title>{{ setting('site.title') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #cbe5e8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .wallet-container {
            background-color: #fff;
            border-radius: 15px;
            width: 360px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .event-header .event-image {
            width: 60%;
        }

        .user-info h2 {
            margin: 30px 0 20px 0;
            font-size: 1.2em;
        }

        .tab {
            background-color: white;
            border: 2px solid #f2f4f8;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.9em;
            margin: 0 2px;
            color: #555;
        }

        .tab.active {
            background-color: #f9f5ff;
            color: #6941c6;
        }

        .tab-content {
            margin: 20px 0;
            text-align: left;
        }

        .tab-item {
            display: none;
        }

        .tab-item.active {
            display: block;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .info-item span {
            font-size: 1.2em;
            margin-right: 10px;
        }

        .info-item a {
            color: #623cea;
            text-decoration: none;
        }

        .info-item a:hover {
            text-decoration: underline;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #eaf1f8;
        }

        .wallet-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .event-header img {
            width: 100%;
            border-radius: 10px;
        }

        .user-info h2 {
            font-size: 24px;
            color: #333;
            margin: 10px 0;
        }

        .tab-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px 0;
        }

        .arrow {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 5px;
        }

        .tabs {
            display: flex;
            overflow-x: hidden;
            max-width: 320px;
            margin: 10px 0;
            flex-shrink: 0;
            padding: 8px 0;
            background-color: #f9fafb;
        }

        .tab {
            padding: 10px 20px;
            border: 1px solid #e5e6e6;
            margin: 0 5px;
            cursor: pointer;
            background-color: white;
            color: #333;
        }

        .tab.active {
            background-color: #f9f5ff;
            color: #6a0dad;
        }

        .tab-content {
            margin-top: 15px;
            color: #333;
        }

        .offer-card {
            width: 300px;
            background-color: #f5f8fc;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            color: #555;
        }

        .offer-card h3 {
            margin-top: 0;
            color: #333;
            font-size: 1.1em;
        }

        .offer-card p {
            font-size: 0.95em;
            line-height: 1.4;
        }

        .offer-card p strong {
            color: #6c7293;
            font-weight: bold;
        }

        .offer-card .icon {
            float: right;
            font-size: 1.5em;
            color: #a3a8c0;
        }

        #qr-code {
            text-align: center;
            align-items: center;
            height: 300px;
        }

        #qr-code i {
            font-size: 200px;
            color: #555;
        }
    </style>
</head>

<body>
    @foreach ($events as $id => $tickets)
        @php
            $model = App\Models\Event::find($id);

        @endphp
        <div class="wallet-container">
            <div class="event-header">
                <img src="{{ Storage::url($model->thumbnail) }}" alt="{{ $model->name }}" class="event-image" />
            </div>
            <div class="user-info">
                <h2>{{ $model->name }}</h2>
            </div>
            <div class="tab-navigation">
                <button class="arrow left-arrow" onclick="slideTabs(-1)">
                    &#9664;
                </button>
                <div class="tabs">
                    <button class="tab active" onclick="showTab('qr-code')">
                        <i class="fa-solid fa-qrcode"></i>
                    </button>

                    <a class="tab" target="__blank" href="{{ $order->invoice_url }}">
                        Transações
                    </a>
                    <button class="tab" onclick="showTab('informacoes')">
                        Informações
                    </button>
                </div>
                <button class="arrow right-arrow" onclick="slideTabs(1)">
                    &#9654;
                </button>
            </div>

            <div class="tab-content " style="overflow: scroll">
                <div id="qr-code" class="tab-item active">
                    <div style="display: flex;flex-direction:column;gap:10px;align-items:center;justify-content;center">

                        @foreach ($tickets as $ticket)
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $ticket->ticket }}&color=ef5927"
                                alt="" height="250" width="250">
                            <p>
                                {{ $ticket->ticket }}
                            </p>
                            <hr>
                        @endforeach
                    </div>


                </div>



                <div id="informacoes" class="tab-item"  style="overflow: scroll;height:350px;">
                    <div class="info-item">
             
                        <div>
                            <p>{{ __('words.location') }}</p>
                            <p>
                                {{ $model->location }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="info-item">
                        <span>📅</span>
                        <div>
                            <p>
                                {{ __('words.start_in') }}
                            </p>
                            <p>
                                {{ $model->start_at->diffForHumans() }}
                                <br>
                                {{ $model->start_at->format('d M') }} - {{ $model->start_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <p><strong>{{__('words.website')}}</strong></p>
                    <a href="{{$model->website}}" target="_blank">{{$model->website}}</a>
                    <hr>
                    <p><strong>{{__('words.description')}}</strong></p>
                    <hr>
                <p>
                    {!!$model->description!!}
                </p>
                </div>
            </div>
        </div>
        
    @endforeach
    <script>
        function showTab(tabId) {
            document
                .querySelectorAll(".tab-item")
                .forEach((item) => item.classList.remove("active"));
            document
                .querySelectorAll(".tab")
                .forEach((tab) => tab.classList.remove("active"));
            document.getElementById(tabId).classList.add("active");
            document
                .querySelector(`[onclick="showTab('${tabId}')"]`)
                .classList.add("active");
        }

        function slideTabs(direction) {
            const tabsContainer = document.querySelector(".tabs");
            const scrollAmount = 100;
            tabsContainer.scrollBy({
                left: direction * scrollAmount,
                behavior: "smooth",
            });
        }
    </script>
</body>

</html>
