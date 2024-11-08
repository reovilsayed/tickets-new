<!doctype html>
<html lang="en">

<head>
    <title>Pos User analytics</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />


        {{-- <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}"> --}}


        <style>
            .card {
                text-align: center;
                padding: 20px;
                width: 100%;
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
                font-size: 24px;
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
        </style>
    </head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>


        

        {{-- @section('javascript')
            <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
            <script>
                var table = $('#dataTable').DataTable()
            </script>
        @endsection --}}

        <div class="container mt-4">
            <h1>
                Pos Report - <span style="color: #EF5927">User Name</span>
            </h1>
            <div class="row ">
                <div class="col-md-2">
                    <select class="form-select" aria-label="Default select example" style="color: #EF5927">
                        <option selected class="fw-bold">SELECT DATE</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" aria-label="Default select example" style="color: #EF5927">
                        <option selected class="fw-bold">Select Pos</option>
                        <option value="">ALERT</option>
                        <option value="">Unmarked</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" aria-label="Default select example" style="color: #EF5927">
                        <option value="">ALERT</option>
                        <option value="">Unmarked</option>
                    </select>
                </div>
                
               
            </div>

            {{-- @include('vendor.voyager.events.partial.buttons') --}}
            <hr>
            {{-- <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Digital Sales',
                        'value' => $event->digitalTickets->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Physical Tickets',
                        'value' => $event->physicalTickets->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Pos SAles',
                        'value' => 000,
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Invites Send',
                        'value' => $event->inviteTickets->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Total',
                        'value' => $event->tickets->count(),
                    ])
                </div>

                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Tickets',
                        'value' => $event->products->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Invites',
                        'value' => $event->invites->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Customer',
                        'value' => $event->tickets()->distinct('user_id')->pluck('user_id')->count(),
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Product',
                        'value' => $event->extras->count(),
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Digital Sales Money',
                        // 'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                        'value' => 0,
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Pos Sales Money',
                        // 'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                        'value' => 0,
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Total Sales Money',
                        'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                    ])

                </div>
            </div>
        </div> --}}
            <div class="container">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                total sell
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                quantity tickets 1
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                quantity tickets 2
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                total tickets quantity
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                quantity product 1
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                quantity product 2
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                total product quantity
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                product sell
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <h3>
                                tickets sell
                            </h3>
                            <h1>
                                000
                            </h1>
                        </div>
                    </div>

                </div>
            </div>
            <div class="table-responsive mt-3">

                <table class="table table-hover" id="dataTable">
                    <thead style="text-transform: uppercase;">
                        <tr class="text-center">
                            <th>name</th>
                            <th>email</th>
                            <th>Phone Number</th>
                            <th>invoice</th>
                            <th>Alert</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="text-center">
                            <td>Lorem, ipsum.</td>
                            <td>Lorem@gmail.com</td>
                            <td>+987656789</td>
                            <td>link</td>
                            <td>mark alert</td>
                        </tr>
                        <tr class="text-center">
                            <td>Lorem, ipsum.</td>
                            <td>Lorem@gmail.com</td>
                            <td>+987656789</td>
                            <td>link</td>
                            <td>mark alert</td>
                        </tr>
                        <tr class="text-center">
                            <td>Lorem, ipsum.</td>
                            <td>Lorem@gmail.com</td>
                            <td>+987656789</td>
                            <td>link</td>
                            <td>mark alert</td>
                        </tr>
                        <tr class="text-center">
                            <td>Lorem, ipsum.</td>
                            <td>Lorem@gmail.com</td>
                            <td>+987656789</td>
                            <td>link</td>
                            <td>mark alert</td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>


    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
