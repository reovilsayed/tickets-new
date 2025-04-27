@php
    $edit = !is_null($dataTypeContent->getKey());
    $add = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .subscription-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .subscription-card:hover {
            border-color: #3490dc;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .subscription-card.selected {
            border-color: #3490dc;
            background-color: #f8fafc;
        }
        .subscription-radio {
            position: absolute;
            opacity: 0;
        }
        .subscription-radio:checked + label .subscription-card {
            border-color: #3490dc;
            background-color: #f0f7ff;
        }
        .subscription-label {
            cursor: pointer;
            width: 100%;
            margin-bottom: 0;
        }
        .subscription-details {
            margin-left: 30px;
        }
        .no-subscriptions {
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-style: italic;
        }
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .form-section-title {
            font-size: 1.1rem;
            color: #3490dc;
            margin-bottom: 15px;
        }
    </style>
@stop

@section('page_title', __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' Magazine Offer')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-gift"></i>
        {{ __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' Magazine Offer' }}
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <form role="form" class="form-edit-add"
                        action="{{ $edit ? route('voyager.magazine-offers.update', $dataTypeContent->getKey()) : route('voyager.magazine-offers.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @if ($edit)
                            {{ method_field('PUT') }}
                        @endif
                        {{ csrf_field() }}

                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-section">
                                <h3 class="form-section-title">Receiver Information</h3>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="receiver_name">Receiver Name</label>
                                        <input type="text" class="form-control" id="receiver_name" name="receiver_name"
                                            placeholder="Enter receiver's name"
                                            value="{{ old('receiver_name', $dataTypeContent->receiver_name ?? '') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="receiver_email">Receiver Email</label>
                                        <input type="email" class="form-control" id="receiver_email" name="receiver_email"
                                            placeholder="Enter receiver's email"
                                            value="{{ old('receiver_email', $dataTypeContent->receiver_email ?? '') }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="receiver_phone">Receiver Phone</label>
                                        <input type="text" class="form-control" id="receiver_phone" name="receiver_phone"
                                            placeholder="Enter receiver's phone"
                                            value="{{ old('receiver_phone', $dataTypeContent->receiver_phone ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="form-section-title">Magazine Selection</h3>
                                <div class="form-group">
                                    <label for="magazine_id">Select Magazine</label>
                                    <select class="form-control select2" name="magazine_id" id="magazine_id" required>
                                        <option value="">-- Select a Magazine --</option>
                                        @foreach (\App\Models\Magazine::all() as $magazine)
                                            <option value="{{ $magazine->id }}"
                                                {{ old('magazine_id', $dataTypeContent->magazine_id ?? '') == $magazine->id ? 'selected' : '' }}>
                                                {{ $magazine->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Select a magazine to view available subscriptions</small>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="form-section-title">Subscription Options</h3>
                                <div id="subscriptionList">
                                    <div class="no-subscriptions">
                                        Please select a magazine first to view available subscriptions
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">
                                <i class="voyager-check"></i> {{ __('voyager::generic.save') }}
                            </button>
                            <a href="{{ route('voyager.magazine-offers.index') }}" class="btn btn-default">
                                <i class="voyager-x"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap',
                width: '100%'
            });

            $('#magazine_id').on('change', function() {
    var magazineId = $(this).val();
    var subscriptionList = $('#subscriptionList');

    if (magazineId) {
        subscriptionList.html('<div class="text-center py-4"><i class="voyager-loading voyager-refresh-animate"></i> Loading subscriptions...</div>');
        
        $.ajax({
            url: '{{ url('get/magazine-subscriptions') }}' + '?id=' + magazineId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                subscriptionList.empty();

                if (data.length > 0) {
                    $.each(data, function(key, subscription) {
                        // Format text to capitalize first letter
                        const formatText = (text) => {
                            if (!text) return '';
                            return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
                        };

                        const subscriptionType = formatText(subscription.subscription_type);
                        const recurringPeriod = formatText(subscription.recurring_period);
                        const description = subscription.description ? formatText(subscription.description) : '';

                        subscriptionList.append(`
                            <div class="mb-3">
                                <input type="radio" 
                                       class="subscription-radio" 
                                       name="subscription_magazine_details_id" 
                                       value="${subscription.id}" 
                                       id="subscription_${subscription.id}"
                                       ${'{{ old("subscription_magazine_details_id", $dataTypeContent->subscription_magazine_details_id ?? "") }}' == subscription.id ? 'checked' : ''}>
                                <label class="subscription-label" for="subscription_${subscription.id}">
                                    <div class="subscription-card">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <i class="voyager-check-circle" style="font-size: 24px; color: #3490dc;"></i>
                                            </div>
                                            <div class="subscription-details">
                                                <h5 class="mb-1">${subscriptionType}</h5>
                                                <p class="mb-1 text-muted">Duration: ${recurringPeriod}</p>
                                                ${description ? `<p class="mb-0">${description}</p>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        `);
                    });
                } else {
                    subscriptionList.html('<div class="no-subscriptions">No subscriptions available for this magazine.</div>');
                }
            },
            error: function() {
                subscriptionList.html('<div class="alert alert-danger">Error loading subscriptions. Please try again later.</div>');
            }
        });
    } else {
        subscriptionList.html('<div class="no-subscriptions">Please select a magazine first to view available subscriptions</div>');
    }
});
            // Trigger change if magazine is pre-selected (edit mode)
            @if(old('magazine_id', $dataTypeContent->magazine_id ?? false))
                $('#magazine_id').trigger('change');
            @endif
        });
    </script>
@stop