@extends('layouts.seller-dashboard')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card space-bottom-30 shadow-sm" style="border-radius: 12px !important;">
            <div class="ec-vendor-card-header">
                <h4>Tickets</h4>
                <div class="d-flex">

                    <div class="ec-header-btn">
                        <a class="butn-dark2" href="{{ route('vendor.ticket.create') }}"><i
                                class="fas fa-plus"></i><span>New tickets</span></a>
                    </div>


                </div>

            </div>
            <div class="ec-vendor-card-body">
                <div class="ec-vendor-card-table">
                    <table class="table ec-table table table-hover">
                        <thead>
                            <tr>

                                <th scope="col">Subject</th>
                                <th scope="col">image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action Massage</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Action</th>

                            <tr>



                        </thead>
                        <tbody>
                            @if ($tickets->count() > 0)
                                @foreach ($tickets as $ticket)
                                    <tr>

                                        <td>
                                            {{ $ticket->subject }}
                                        </td>
                                        <td>
                                            <img src=" {{ $ticket->image ? Voyager::image($ticket->image) : asset('assets/img/no-found.png') }}"
                                                alt=""  style="height: 60px">
                                        </td>

                                        <td>
                                            @if ($ticket->status == false)
                                                <a class="btn btn-sm btn-warning p-0">Closed</a>
                                            @else
                                                <a class="btn btn-sm  btn-dark text-white p-0">Open</a>
                                            @endif
                                        </td>
                                        <td style="width:20px">

                                            @if ($ticket->action == false)
                                                <p class="text-success ">
                                                    <!-- Awaiting response from the admin -->
                                                    Waiting for admin to reply .
                                                </p>
                                            @else
                                                <p class="text-warning">
                                                    Waiting for you reply.
                                                </p>
                                            @endif

                                        </td>
                                        <td>
                                            {{ $ticket->created_at->format('d.M.Y') }}
                                        </td>
                                        <td>
                                            <a href="{{route('ticket.show',$ticket)}}" class="btn btn-info text-white">Reply</a>
                                            @if ($ticket->status==1)
                                                
                                            <a href="{{route('ticket.close',$ticket)}}" class="btn bg-danger text-white">Close</a>
                                            @else
                                            <a href="{{route('ticket.close',$ticket)}}" class="btn btn-success">Open</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p>No tickets here</p>
                            @endif
                        </tbody>



                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
