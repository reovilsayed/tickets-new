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
      font-size: 30px;
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
    .btn-sm{
      padding: 0px 5px;
    }
  </style>
  <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
  <div class="container">
    <h1>
      {{ $event->name }} - Orders
    </h1>

    <hr>
    @include('vendor.voyager.events.partial.buttons')
    <hr>
    <div class="container">
      <div class="panel">
        <div class="panel-body">
          <div id="" class="">
            <form action="">
              <label>Search:<input type="search" class="form-control input-sm" placeholder="" name="search" value="{{request('search')}}"></label>
            </form>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr class="text-center">
                  <th>Order Id</th>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th style="width: 120px;">Status</th>
                  <th>Discount</th>
                  <th>Total</th>
                  <th>Tax</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($orders as $order)
                  <tr>
                    <td scope="row">{{ $order->id }}</td>
                    <td scope="row">{{ $order->user->name }} {{ $order->user->l_name }}</td>
                    <td scope="row">{{ $order->user->email }} </td>
                    <td>{{ $order->getStatus() }}</td>
                    <td>{{ Sohoj::price($order->discount) }}</td>
                    <td>{{ Sohoj::price($order->total) }}</td>
                    <td>{{ Sohoj::price($order->tax) }}</td>
                    {{-- <td>{{ Sohoj::price($order->refund_amount) }}</td>
                    <td>{{ optional($order->date_paid)->format('d F, Y') ?? 'N/A' }}</td>
                    <td>{{ optional($order->date_completed)->format('d F, Y') ?? 'N/A' }}</td> --}}
                    <td>{{ $order->created_at->format(' d F, Y') }}</td>
                    <td class="align-center" style="display: flex">
                      @if ($order->status !== 3 || $order->status == 1)
                        <a href="{{ route('order.refund', $order) }}" class="btn btn-dark pull-right btn-sm" style="margin-right:7px;"><i class="voyager-wallet" style="margin-right:5px;"></i>Refund</a>
                      @endif
                      <a style="margin-right: 5px;"href="{{ route('voyager.orders.show', $order) }}" class="btn btn-sm btn-warning pull-right">
                        <i class="voyager-eye"></i> View
                      </a>
                      <a style="margin-right: 5px;" href="{{ route('download.ticket', ['order' => $order]) }}" class="btn btn-sm btn-info pull-left">
                        <i class="voyager-download"></i> Tickets
                      </a>

                      <a href="{{ route('send.email', ['order' => $order]) }}" class="btn btn-sm btn-warning pull-left">
                        <i class="voyager-mail"></i> Send Mail
                      </a>
                      @if (isset($order->billing->phone) || $order->user?->contact_number)
                        <a href="{{ route('order.sms', $order) }}" onclick="askForConfirmation(this)" class="btn btn-sm btn-success pull-left">
                          <i class="voyager-mail"></i> Send Sms
                        </a>
                      @endif
                      @if ($order->payment_status != 1)
                      <br>
                                <a href="{{route('order.mark.pay',$order)}}" class="btn btn-info pull-right btn-sm" style="margin-right:7px;"><i
                                    class="voyager-wallet" style="margin-right:5px;"></i>Mark As Pay</a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            {{ $orders->links() }}
          </div>

        </div>
      </div>
    </div>
  </div>
  <form action="" method="post" id="send-sms-form">
    @csrf
    @method('put')
  </form>

@endsection

@section('javascript')
  <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
  <script>
    var table = $('#dataTable').DataTable();

    function askForConfirmation(el) {
      const csk = confirm('Are you sure?');

      event.preventDefault();

      if (!csk) {
        return;
      }

      const formEl = document.getElementById('send-sms-form');

      formEl.action = el.href

      formEl.submit();
    }
  </script>
@endsection
