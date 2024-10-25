<!DOCTYPE html>
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

</html>
