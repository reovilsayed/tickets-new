@extends('voyager::master')

@section('page_title', __('voyager::generic.view') . ' ' . $dataType->getTranslatedAttribute('display_name_singular'))

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
    </style>
@endsection

@section('page_header')
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    @php
        // Decode shipping info safely
        $shipping = json_decode($dataTypeContent->shipping_info, true) ?: [];
        $user = $dataTypeContent->user;
    @endphp

    <div class="container">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <h1 style="color:#000;font-weight:700;">
                            Subscription #{{ $dataTypeContent->id }}
                        </h1>
                        <span class="pill pill-{{ $dataTypeContent->getStatus() ?? 'secondary' }}">
                            {{ $dataTypeContent->getStatus() ?? 'N/A' }}
                        </span>
                        <br><br>
                        <div style="display: flex; gap:10px;">
                            <span class="pill pill-secondary">
                                Start Date: {{ $dataTypeContent->start_date ?? 'N/A' }}
                            </span>
                            <span class="pill pill-secondary">
                                End Date: {{ $dataTypeContent->end_date ?? 'N/A' }}
                            </span>
                            <span class="pill pill-secondary">
                                Created: {{ $dataTypeContent->created_at?->format('d F, Y') ?? 'N/A' }}
                            </span>
                            <span class="pill pill-secondary">
                                Updated: {{ $dataTypeContent->updated_at?->format('d F, Y') ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Subscription Info --}}
        <div class="panel panel-bordered">
            <div class="panel-body">
                <h3 style="color:#000;font-weight:700;">Subscription Information</h3>
                <hr>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $dataTypeContent->id }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-{{ $dataTypeContent->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($dataTypeContent->status ?? 'N/A') }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Subscription Type</th>
                        <td>{{ ucfirst($dataTypeContent->subscription_type ?? 'N/A') }}</td>
                    </tr>
                    <tr>
                        <th>Recurring Period</th>
                        <td>{{ $dataTypeContent->recurring_period ?? 'N/A' }} months</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- User Info --}}
        <div class="panel panel-bordered">
            <div class="panel-body">
                <h3 style="color:#000;font-weight:700;">User Information</h3>
                <hr>
                <ul>
                    <li><strong>Name:</strong> {{ $user?->name ?? ($dataTypeContent->billing_name ?? 'N/A') }}</li>
                    <li><strong>Email:</strong> {{ $user?->email ?? ($dataTypeContent->billing_email ?? 'N/A') }}</li>
                    @if (!empty($user?->getCountry()))
                        <li><strong>Country:</strong> {{ $user->getCountry() }}</li>
                    @else
                        <li><strong>Country:</strong> N/A</li>
                    @endif
                    <li><strong>VAT Number:</strong> {{ $user?->vatNumber ?? 'N/A' }}</li>
                    <li><strong>Address:</strong> {{ $user?->address ?? 'N/A' }}</li>
                </ul>
            </div>
        </div>

        {{-- Shipping Info --}}
        @if (!empty($shipping))
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <h3 style="color:#000;font-weight:700;">Shipping Information</h3>
                    <hr>
                    <ul>
                        <li><strong>Recipient:</strong> {{ $shipping['recipient_name'] ?? 'N/A' }}</li>
                        <li><strong>Company:</strong> {{ $shipping['company'] ?? 'N/A' }}</li>
                        <li><strong>Street:</strong>
                            {{ ($shipping['street_address'] ?? '') . ' ' . ($shipping['apartment'] ?? '') }}</li>
                        <li><strong>City:</strong> {{ $shipping['city'] ?? 'N/A' }}</li>
                        <li><strong>State:</strong> {{ $shipping['state_province'] ?? 'N/A' }}</li>
                        <li><strong>Postal Code:</strong> {{ $shipping['postal_code'] ?? 'N/A' }}</li>
                        <li><strong>Phone:</strong> {{ $shipping['phone'] ?? 'N/A' }}</li>
                    </ul>
                </div>
            </div>
        @endif
    </div>

@stop

@section('javascript')
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function() {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function(e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) {
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/) ?
                deleteFormAction.replace(/([0-9]+$)/, $(this).data('id')) :
                deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });
    </script>
@stop
