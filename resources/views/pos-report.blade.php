@php
  $productsellamount = 0;
  foreach ($extras as $extra) {
      $productsellamount += $extra->qty * $extra->price;
  }
@endphp

<!doctype html>
<html lang="en">

<head>
  <title>Pos User analytics</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
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
  <header></header>
  <main>
    {{-- @section('javascript')
            <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
            <script>
                var table = $('#dataTable').DataTable()
            </script>
        @endsection --}}
    <form action="{{ url()->current() }}" method="get" id="form1">
      <div class="container mt-4 mb-5">
        <h1>
          Pos Report - <span style="color: #EF5927">{{ $user->email }} </span>
        </h1>

        <div class="row">
          <div class="col-md-3">

            <div class="form-group">
              <label for="date">Select Date</label>
              <input value="{{ request()->date }}" onchange="document.getElementById('form1').submit()" name="date" type="date" id="date" class="form-control">
            </div>
          </div>
          <div class="col-md-3">

            <div class="form-group">
              <label for="event">Select Event</label>
              <select onchange="document.getElementById('form1').submit()" name="event" id="event" class="form-control">
                <option value="">
                  All</option>
                @foreach ($events as $event)
                  <option @if ($event->id == request()->event) selected @endif value="{{ $event->id }}">
                    {{ $event->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div>


        <hr>

        <div class="container">
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              @include('vendor.voyager.events.partial.card', [
                  'label' => 'Total Amount',
                  'value' => Sohoj::price($orders->sum('total')),
              ])

            </div>
            <div class="col-md-4">
              @include('vendor.voyager.events.partial.card', [
                  'label' => 'Total Ticket Sell',
                  'value' => $tickets->count(),
              ])

            </div>
            <div class="col-md-4">
              @include('vendor.voyager.events.partial.card', [
                  'label' => 'Total Product sell',
                  'value' => $extras->sum('qty'),
              ])
            </div>
            <div class="col-md-4">
              @include('vendor.voyager.events.partial.card', [
                  'label' => 'Product sell Amount',
                  'value' => Sohoj::price($productsellamount),
              ])

            </div>
            <div class="col-md-4">
              @include('vendor.voyager.events.partial.card', [
                  'label' => 'Ticket sell Amount',
                  'value' => Sohoj::price($orders->sum('total') - $productsellamount),
              ])
            </div>


            @foreach ($tickets->groupBy(fn($ticket) => $ticket->product->name) as $product => $tickets)
              <div class="col-md-4">
                <div class="card">
                  <h3>
                    {{ $product }}
                  </h3>
                  <h1>
                    {{ count($tickets) }}
                  </h1>
                </div>
              </div>
            @endforeach

            @foreach ($extras->groupBy('name') as $name => $data)
              <div class="col-md-4">
                <div class="card">
                  <h3>
                    {{ $name }}
                  </h3>
                  <h1>
                    {{ $data->sum('qty') }}
                  </h1>
                </div>
              </div>
            @endforeach

          </div>

          <div class="card">

            <div class="row text-left mb-0">
              <div class="col-md-4">
                <div class="form-group ">

                  <input value="{{ request()->search }}" onchange="document.getElementById('form1').submit()" type="text" id="search" name="search" class="form-control" placeholder="Search here">
                </div>
              </div>
              <div class="col-md-3">

                <div class="form-group m-0">
                  <select onchange="document.getElementById('form1').submit()" name="alert" id="alert" class="form-control">
                    <option value="">Alert</option>
                    <option @if (request()->alert == 'marked') selected @endif value="marked">Marked
                    </option>
                    <option @if (request()->alert == 'unmarked') selected @endif value="unmarked">Not
                      marked
                    </option>
                    <option @if (request()->alert == 'resolved') selected @endif value="resolved">
                      Resolved
                    </option>
                  </select>
                </div>
              </div>

            </div>

            <div class="table-responsive">

              <table class="table table-hover">
                <thead>
                  <tr class="">
                    <th>
                      #
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Description</th>
                    <th>Invoice</th>
                    <th>Note</th>
                    <th>Alert</th>
                  </tr>
                </thead>
                <tbody id="ticket-table-body">
                  @foreach ($allorders as $order)
                    <tr>
                      <td>
                        {{ $order->id }}
                      </td>
                      <td>{{ $order->user->name }}</td>
                      <td>{{ $order->user->email }}</td>
                      <td>{{ $order->user->contact_number }}</td>
                      <td>
                        <ul>
                          @foreach ($order->getDescription() as $line)
                            <li>
                              {{ $line }}
                            </li>
                          @endforeach
                        </ul>
                      </td>
                      <td>
                        @if (!empty($order->invoice_url) && !empty($order->invoice_id))
                          <a href="{{ $order->invoice_url }}">Invoice
                            #{{ $order->invoice_id }}</a>
                        @else
                          N/A
                        @endif
                      </td>
                      <td>{{ $order->note }}</td>
                      <td>
                        @if ($order->alert == 'unmarked')
                          {{-- <a href="{{ route('order.marked', $order) }}" class="btn btn-primary">Mark</a> --}}
                          <button type="button" class="btn btn-primary ticket-marked-button" data-url="{{ route('order.marked', $order) }}" data-bs-toggle="modal" data-bs-target="#ticket-marked">
                            Mark
                          </button>
                        @elseif($order->alert == 'resolved')
                          <button class="btn btn-success">Resolved</button>
                        @else
                          <button class="btn btn-danger">Marked</button>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $allorders->withQueryString()->links('pagination::bootstrap-4') }}

            </div>
          </div>
        </div>
      </div>

    </form>

  </main>
  <footer>
    <!-- place footer here -->
  </footer>

  <div class="modal fade" tabindex="-1" id="ticket-marked">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tell us why you marked this?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" id="ticket-marked-form">
          <div class="modal-body">
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Note:</label>
              <textarea class="form-control" rows="10" name="note" id="message-text"></textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script>
    const ticketTableBody = document.getElementById("ticket-table-body");
    ticketTableBody.addEventListener('click', (e) => {
      const el = e.target;
      if (!el.classList.contains('ticket-marked-button')) {
        return;
      }
      const url = el.dataset.url;
      const formEl = document.getElementById('ticket-marked-form');

      formEl.action = url;

    });
  </script>
</body>

</html>
