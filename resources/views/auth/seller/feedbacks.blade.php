@extends('layouts.seller-dashboar')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card space-bottom-30">
            <div class="ec-vendor-card-header">
                <h5>Feedbacks</h5>


            </div>

            @if (count($feedbacks) == !0)
                <div class="ec-vendor-card-body">

                    <div class="ec-vendor-card-table">



                        <table class="table ec-table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Feedback</th>
                                    <th scope="col">Created at</th>
                              

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedbacks as $feedback)
                              
                                    <tr>
                                        <th scope="row"><span>{{ $loop->index + 1 }}</span></th>
                                        <td><span>{{ $feedback->order->user->name }}</span></td>
                                        <td><span>{{ $feedback->order->user->email }}</span></td>
                                        <td><span>{{ $feedback->feedback }}</span></td>
                                        <td><span>{{ $feedback->created_at->format('M-d-Y') }}</span></td>


                                    </tr>
                                @endforeach


                            </tbody>
                        </table>

                    </div>

                </div>
            @else
                <h3 class="text-center text-danger">No Items Found</h3>
            @endif
        </div>
    </div>

@endsection
