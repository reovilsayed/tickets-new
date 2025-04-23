@extends('layouts.user_dashboard')

@section('styles')
    <!-- Font Awesome 5 (free version) -->

    <style>
        .nav-tabs {
            border-bottom: 1px solid #e9ecef;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            padding: 12px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-tabs .nav-link:hover {
            color: #0d6efd;
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            background-color: transparent;
            border: none;
            border-bottom: 3px solid #0d6efd;
        }

        .order-table th {
            white-space: nowrap;
        }

        .dashboard-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .payinfo td {
            text-align: right;
        }

        @media (max-width: 767.98px) {
            .nav-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }

            .ec-vendor-setting-card {
                padding: 15px;
            }

            .table-responsive {
                border: 0;
            }
        }
    </style>
@endsection


@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12 mt-2">
        <div class="card user-name">
            <div class="card-body">
                <span class="user-dash-font">Hello, {{ Auth::user()->name }}!</span>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="ec-vendor-dashboard-card mb-3">
            <ul class="nav nav-tabs" id="ordersTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" style="color: black !important" id="tickets-tab" data-bs-toggle="tab"
                        data-bs-target="#tickets" type="button" role="tab" aria-controls="tickets"
                        aria-selected="true">
                        <i class="fa fa-ticket-alt me-1"></i> My Tickets
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" style="color: black !important" id="magazines-tab" data-bs-toggle="tab"
                        data-bs-target="#magazines" type="button" role="tab" aria-controls="magazines"
                        aria-selected="false">
                        <i class="fa fa-book me-1"></i> Magazine Subscriptions
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="ordersTabContent">
                <!-- Tickets Tab -->
                <div class="tab-pane fade show active" id="tickets" role="tabpanel" aria-labelledby="tickets-tab">
                    @if ($latest_orders->count() > 0)
                        @foreach ($latest_orders as $order)
                            <div class="ec-vendor-setting-card mb-3 mt-3">
                                <div class="ec-vendor-card-body">
                                    @foreach ($order->tickets->groupBy('product_id') as $id => $tickets)
                                        @php
                                            $model = App\Models\Product::find($id);
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div>
                                                <h4 class="dashboard-title mb-1">
                                                    {{ $model->name }}
                                                </h4>
                                                <small class="text-muted">
                                                    <i class="fa fa-calendar-alt me-1"></i> {{ $model->event->name }}
                                                </small>
                                            </div>
                                            <a target="_blank" class="btn btn-primary btn-sm rounded-pill mt-2 mt-sm-0"
                                                href="{{ route('download.ticket', ['order' => $order, 'product' => $id]) }}">
                                                <i class="fa fa-download me-1"></i>
                                                {{ __('words.download') }}
                                            </a>
                                        </div>

                                        <div class="table-responsive mt-3">
                                            <table class="order-table table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>{{ __('words.ticket_id') }}</th>
                                                        <th>{{ __('words.paymeys_status') }}</th>
                                                        <th>{{ __('words.payment_type') }}</th>
                                                        <th>{{ __('words.status') }}</th>
                                                        <th>{{ __('words.price') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tickets as $ticket)
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="badge bg-light text-dark">{{ $ticket->ticket }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-success">{{ __('words.paid') }}</span>
                                                            </td>
                                                            <td>{{ $order->payment_method_title }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ $ticket->status() === 'Active' ? 'success' : 'secondary' }}">
                                                                    {{ $ticket->status() }}
                                                                </span>
                                                            </td>
                                                            <td>{{ Sohoj::price($ticket->price) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="card-footer bg-transparent p-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <a target="_blank" class="btn btn-outline-primary btn-sm rounded-pill"
                                                href="{{ $order->invoice_url }}">
                                                <i class="fa fa-file-invoice me-1"></i> {{ __('words.invoice') }}
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="payinfo table table-borderless">
                                                    <tr>
                                                        <th style="font-size: 14px">{{ __('words.subtotal') }}</th>
                                                        <td style="font-size: 14px">+ {{ Sohoj::price($order->subtotal) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="font-size: 14px">{{ __('words.tax') }}</th>
                                                        <td style="font-size: 14px">+ {{ Sohoj::price($order->tax) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="font-size: 14px">{{ __('words.discount') }}</th>
                                                        <td style="font-size: 14px">- {{ Sohoj::price($order->discount) }}
                                                        </td>
                                                    </tr>
                                                    <tr class="border-top">
                                                        <th style="font-size: 16px">{{ __('words.total') }}</th>
                                                        <td style="font-size: 16px; font-weight: bold">=
                                                            {{ Sohoj::price($order->total) }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-ticket-alt fa-3x text-muted mb-3"></i>
                            <h5>No ticket orders found</h5>
                            <p class="text-muted">You haven't purchased any tickets yet.</p>
                            <a href="" class="btn btn-primary rounded-pill">Browse Events</a>
                        </div>
                    @endif
                </div>

                <!-- Magazines Tab -->
                <div class="tab-pane fade" id="magazines" role="tabpanel" aria-labelledby="magazines-tab">
                    @if ($latest_magazine_orders->count() > 0)
                        @foreach ($latest_magazine_orders as $order)
                            <div class="ec-vendor-setting-card mb-3 mt-3">
                                <div class="ec-vendor-card-body">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                        <div>
                                            <h4 class="dashboard-title mb-1">
                                                {{ $order->magazine->name ?? '-' }}
                                            </h4>
                                          
                                            @if ($order->magazineOrder)
                                                <span
                                                    class="badge bg-{{ $order->magazineOrder->status == 1 ? 'success' : 'secondary' }}">
                                                    {{ $order->magazineOrder->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">No Order</span>
                                            @endif
                                        </div>
                                        <div class="text-end mt-2 mt-sm-0">
                                            <small class="text-muted d-block">Order #{{ $order->id }}</small>
                                            <small class="text-muted">
                                                <i class="fa fa-calendar-alt me-1"></i>
                                                {{ $order->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <div class="card bg-light">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title text-muted mb-2">Subscription Details</h6>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="mb-1">
                                                            <strong>Type:</strong>
                                                            <span
                                                                class="text-capitalize">{{ $order->subscription_type }}</span>
                                                        </li>
                                                        <li class="mb-1">
                                                            <strong>Period:</strong>
                                                            <span class="text-capitalize">{{ $order->recurring_period }}
                                                                (Month's)
                                                            </span>
                                                        </li>

                                                        <li>
                                                            <strong>Price:</strong>
                                                            {{ Sohoj::price($order->details['price'] ?? 0) }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title text-muted mb-2">Date Range</h6>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="mb-1">
                                                            <strong>Start:</strong>
                                                            {{ $order->start_date->format('M d, Y') }}
                                                        </li>
                                                        <li>
                                                            <strong>End:</strong>
                                                            {{ $order->end_date->format('M d, Y') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            <small>Total Paid</small>
                                            <h5 class="mb-0">{{ Sohoj::price($order->details['price'] ?? 0) }}</h5>
                                        </div>
                                        <a href="#" class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="fa fa-file-invoice me-1"></i> Invoice
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-book fa-3x text-muted mb-3"></i>
                            <h5>No magazine subscriptions</h5>
                            <p class="text-muted">You haven't subscribed to any magazines yet.</p>
                            <a href="{{ route('magazines') }}" class="btn btn-primary rounded-pill">Browse Magazines</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedback" tabindex="-1" aria-labelledby="feedback" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('words.give_feedback') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.feedback.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="feedbackInput">{{ __('words.feedback') }}</label>
                                <textarea name="feedback" required class="form-control mb-2 @error('feedback') is-invalid @enderror"
                                    id="feedbackInput" rows="5"></textarea>
                                @error('feedback')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input type="hidden" name="order_id" value="" id="order_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('words.close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('words.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var recipient = button.getAttribute('data-bs-id')
            var modalBodyInput = exampleModal.querySelector('#orderId')

            modalBodyInput.value = recipient
        })
    </script>

    <script>
        $(document).ready(function() {
            $(".feedback-btn").click(function() {
                $('#order_id').val($(this).data('id'));
                var feedback = $('#feedbackInput').val($(this).data('feedback'));
                console.log(feedback);
                $('#addBookDialog').modal('show');
            });
        });
    </script>
@endsection
