<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Digital Wallet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #eventFilter {
            border-radius: 30px;
            width: 95%;
        }

        .event-card {
    width: 95%;
    height: 650px;
    border-radius: 30px;
    overflow-y: scroll;
    scrollbar-width: none; /* Firefox */
}

/* Hide scrollbar for Webkit browsers (Chrome, Safari) */
.event-card::-webkit-scrollbar {
    display: none;
}

      

        .qr {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            padding: 15px;
        }

        .qr img {
            height: 200px;
            width: 200px;
            border-radius: 8px;
            object-fit: cover;
        }

        .qr p {
            margin-top: 10px;
            font-size: 1rem;
            color: #333;
        }

        @media (min-width: 1024px) {

            #eventFilter {
                width: 45%;
            }

            /* Adjust 1024px to your preferred large display breakpoint */
            .event-card {
                width: 45%;
            }
        }

        .accordins {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
           
        }

        .accordin-item {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .accordin-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .accordin-title {
            font-size: 1.2rem;
            color: #333;
        }

        .accordin-subtitle {
            font-size: 0.9rem;
            color: #666;
        }

        .accordin-location {
            font-size: 1.3rem;
            color: #444;
            font-weight: 600;
        }

        .accordin-text {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
            margin-top: 10px;
        }

        .icon-header i {
            color: #3a77f0;
        }

        .icon-header .accordin-title {
            margin: 0;
            font-weight: bold;
        }

        .accordin-header i {
            margin-right: 10px;
        }
    </style>
</head>

<body class="bg-secondary">


    <div class="container vh-100 d-flex justify-content-center flex-column align-items-center">
        <select id="eventFilter" class="form-select mt-2  mb-3">
            @foreach ($events as $id => $tickets)
                <option value="{{ $id }}" {{ $id == $selectedEventId ? 'selected' : '' }}>
                    {{ App\Models\Event::find($id)->name }}
                </option>
            @endforeach
        </select>
        @foreach ($events as $id => $tickets)
            @if ($id == $selectedEventId)
                @php
                    $model = App\Models\Event::find($id);
                @endphp
                <div class="card event-card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ Storage::url($model->thumbnail) }}" class="img-fluid w-50" alt="">
                            <h4 class="mt-3">
                                {{ $model->name }}
                            </h4>
                        </div>
                        <div class="d-flex  gap-2 p-2" style="overflow: scroll">
                            <a href="{{ url()->current() }}?tab=qr" class="btn btn-primary"> <i
                                    class="fa-solid fa-qrcode"></i></a>
                            @if ($order->invoice_url)
                                <a href="{{ $order->invoice_url }}" class="btn btn-primary">
                                    {{ __('words.invoice') }}</a>
                            @endif
                            <a href="{{ url()->current() }}?tab=products" class="btn btn-primary">
                                {{ __('words.products') }}</a>
                            <a href="{{ url()->current() }}?tab=information" class="btn btn-primary">
                                {{ __('words.information') }}</a>
                        </div>
                        @if (request()->tab == 'information')
                            <div class="tab">

                                <div class="accordins">
                                    <div class="accordin-item mt-3">
                                        <div class="accordin-header">
                                            <h5 class="accordin-title">
                                                {{ __('words.start_in') }} {{ $model->start_at->diffForHumans() }}
                                            </h5>
                                            <h6 class="accordin-subtitle">
                                                {{ $model->start_at->format('d M') }} -
                                                {{ $model->start_at->format('H:i') }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="accordin-item">
                                        <div class="accordin-header">
                                            <h4 class="accordin-location">
                                                {{ $model->location }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="accordin-item">
                                        <div class="accordin-header icon-header">
                                            <i class="fa fa-info-circle fa-2x"></i>
                                            <h5 class="accordin-title">{{ __('words.description') }}</h5>
                                        </div>
                                        <p class="accordin-text">
                                            {!! $model->description !!}
                                        </p>
                                    </div>
                                    <div class="accordin-item">
                                        <div class="accordin-header icon-header">
                                            <i class="fa-solid fa-file-contract fa-2x"></i>
                                            <h5 class="accordin-title">{{ __('words.terms') }}</h5>
                                        </div>
                                        <p class="accordin-text">
                                            {!! $model->terms !!}
                                        </p>
                                    </div>
                                </div>


                            </div>
                        @elseif(request()->tab == 'products')
                            <div class="tab">
                                <table class="table mx-auto text-center">

                                    <tr>
                                        <th>
                                            {{ __('words.name') }}
                                        </th>
                                        <th>
                                            {{ __('words.total_used') }}
                                        </th>
                                    </tr>

                                    @foreach ($tickets->pluck('extras')->flatMap(fn($extra) => $extra)->groupBy('name') as $name => $extras)
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
                            </div>
                        @else
                            <div class="tab  ">
                                @foreach ($tickets as $ticket)
                                    <div class="qr text-center">

                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $ticket->ticket }}&color=ef5927"
                                            alt="" height="200" width="200">
                                        <p class="mt-3">
                                            {{ $ticket->ticket }}
                                        </p>

                                    </div>
                                @endforeach

                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
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
