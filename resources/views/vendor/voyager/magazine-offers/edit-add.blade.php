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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .subscription-card.selected {
            border-color: #3490dc;
            background-color: #f8fafc;
        }

        .subscription-radio {
            position: absolute;
            opacity: 0;
        }

        .subscription-radio:checked+label .subscription-card {
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
        }

        .form-section-title {
            font-size: 1.1rem;
            color: #3490dc;
            margin-bottom: 15px;
        }

        .subscription-title {
            font-size: 1.1rem;
            color: #3490dc;
            margin-bottom: 15px;
            padding: 15px;
        }

        .subscription-card h5 {
            padding: 10px 0;
            /* Add padding above and below the title */
            margin-bottom: 5px;
        }

        #shipping-info {
            padding: 15px;
            /* Add padding around the shipping info section */
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f8fafc;
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
                    <form role="form" class="form-edit-add" id="magazine-offer-form"
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
                                    <div class="form-group col-md-12">
                                        <label for="user_filter">Filter by Name, Email, or Contact Number</label>
                                        <input type="text" class="form-control" id="user_filter"
                                            placeholder="Type name, email, or contact number...">
                                        <div id="suggestions" class="list-group mt-1"></div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="user_id">User Name</label>
                                        <div class="input-group">
                                            <select class="form-control" id="user_id" name="user_id">
                                                <option value="">-- Select User --</option>
                                                @foreach (\App\Models\User::where('role_id', 2)->get() as $user)
                                                    <option value="{{ $user->id }}" data-name="{{ $user->name }}"
                                                        data-email="{{ $user->email }}"
                                                        data-phone="{{ $user->contact_number }}"
                                                        @if (old('user_id', $dataTypeContent->user_id ?? '') == $user->id) selected @endif>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="clear-user-btn">Clear</button>
                                            </div>
                                        </div>
                                    </div>
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
                                    <small class="form-text text-muted">Select a magazine to view available
                                        subscriptions</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-section">
                                    <h3 class="subscription-title">Subscription Options</h3>
                                    <div id="subscriptionList">
                                        <div class="no-subscriptions">
                                            Please select a magazine first to view available subscriptions
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $shippingInfo = $dataTypeContent->shipping_info;
                        @endphp
                        <div class="form-section" id="shipping-info" style="display:none;">
                            <h3 class="form-section-title">Shipping Information</h3>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="street_address" class="form-label">{{ __('words.street_address') }}</label>
                                    <input type="text" name="shipping_info[street_address]" class="form-control"
                                        placeholder="{{ __('words.street_address') }}"
                                        value="{{ old('shipping_info.street_address', $shippingInfo['street_address'] ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="apartment" class="form-label">{{ __('words.apartment_suite') }}
                                        ({{ __('words.optional') }})</label>
                                    <input type="text" name="shipping_info[apartment]" class="form-control"
                                        placeholder="{{ __('words.apartment_suite') }}"
                                        value="{{ old('shipping_info.apartment', $shippingInfo['apartment'] ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label">{{ __('words.city') }}</label>
                                    <input type="text" name="shipping_info[city]" class="form-control"
                                        placeholder="{{ __('words.city') }}"
                                        value="{{ old('shipping_info.city', $shippingInfo['city'] ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="state_province"
                                        class="form-label">{{ __('words.state_province') }}</label>
                                    <input type="text" name="shipping_info[state_province]" class="form-control"
                                        placeholder="{{ __('words.state_province') }}"
                                        value="{{ old('shipping_info.state_province', $shippingInfo['state_province'] ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="postal_code" class="form-label">{{ __('words.postal_code') }}</label>
                                    <input type="text" name="shipping_info[postal_code]" class="form-control"
                                        placeholder="{{ __('words.postal_code') }}"
                                        value="{{ old('shipping_info.postal_code', $shippingInfo['postal_code'] ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="shipping_country" class="form-label">{{ __('words.country') }}</label>
                                    <select class="form-control" name="shipping_info[country]">
                                        <option value="">-- Select Country --</option>
                                        @foreach (Sohoj::getCountries() as $code => $name)
                                            <option value="{{ $code }}"
                                                {{ old('shipping_info.country', $shippingInfo['country'] ?? '') == $code ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
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
            $('#user_filter').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('admin.user.search') }}",
                        type: "GET",
                        data: {
                            q: query
                        },
                        success: function(data) {
                            let suggestions = $('#suggestions');
                            suggestions.empty();

                            if (data.length > 0) {
                                data.forEach(user => {
                                    suggestions.append(`
                                <a href="#" class="list-group-item list-group-item-action suggestion-item"
                                   data-id="${user.id}"
                                   data-name="${user.name}"
                                   data-email="${user.email ?? ''}"
                                   data-phone="${user.contact_number ?? ''}">
                                   ${user.name} (${user.email ?? ''}) - ${user.contact_number ?? ''}
                                </a>
                            `);
                                });
                            } else {
                                suggestions.append(
                                    `<div class="list-group-item">No results found</div>`);
                            }
                        }
                    });
                } else {
                    $('#suggestions').empty();
                }
            });

            // On selecting a suggestion
            $(document).on('click', '.suggestion-item', function(e) {
                e.preventDefault();

                let userId = $(this).data('id');
                let name = $(this).data('name');
                let email = $(this).data('email');
                let phone = $(this).data('phone');

                // Fill filter input
                $('#user_filter').val(name);
                $('#suggestions').empty();

                // Select user in dropdown
                $('#user_id').val(userId);

                // Autofill receiver fields
                $('#receiver_name').val(name);
                $('#receiver_email').val(email);
                $('#receiver_phone').val(phone);
            });

            // Clear user button
            $('#clear-user-btn').on('click', function() {
                $('#user_filter').val('');
                $('#user_id').val('');
                $('#receiver_name').val('');
                $('#receiver_email').val('');
                $('#receiver_phone').val('');
                $('#suggestions').empty();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('user_id');
            const clearBtn = document.getElementById('clear-user-btn');

            userSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (selectedOption.value) {
                    const name = selectedOption.getAttribute('data-name') || '';
                    const email = selectedOption.getAttribute('data-email') || '';
                    const phone = selectedOption.getAttribute('data-phone') || '';

                    document.getElementById('receiver_name').value = name;
                    document.getElementById('receiver_email').value = email;
                    document.getElementById('receiver_phone').value = phone;
                } else {
                    clearFields();
                }
            });

            clearBtn.addEventListener('click', function() {
                userSelect.value = '';
                clearFields();
            });

            function clearFields() {
                document.getElementById('receiver_name').value = '';
                document.getElementById('receiver_email').value = '';
                document.getElementById('receiver_phone').value = '';
            }
        });
    </script>
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
                    subscriptionList.html(
                        '<div class="text-center py-4"><i class="voyager-loading voyager-refresh-animate"></i> Loading subscriptions...</div>'
                    );

                    $.ajax({
                        url: '{{ url('get/magazine-subscriptions') }}' + '?id=' + magazineId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            subscriptionList.empty();

                            if (data.length > 0) {
                                $.each(data, function(key, subscription) {
                                    const formatText = (text) => {
                                        if (!text) return '';
                                        return text.charAt(0).toUpperCase() + text
                                            .slice(1);
                                    };

                                    const subscriptionType = subscription
                                        .subscription_type === 'digital' ? 'Digital' :
                                        subscription.subscription_type === 'physical' ?
                                        'Physical' :
                                        formatText(subscription.subscription_type);

                                    const recurringPeriod = formatText(subscription
                                        .recurring_period);
                                    const description = subscription.description ?
                                        formatText(subscription.description) : '';

                                    subscriptionList.append(`
    <div class="col-md-6 mb-3">
        <input type="radio" 
               class="subscription-radio" 
               name="subscription_magazine_details_id" 
               value="${subscription.id}" 
               id="subscription_${subscription.id}"
               data-type="${subscription.subscription_type}"
               ${'{{ old('subscription_magazine_details_id', $dataTypeContent->subscription_magazine_details_id ?? '') }}' == subscription.id ? 'checked' : ''}>
        <label class="subscription-label" for="subscription_${subscription.id}">
            <div class="subscription-card">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="voyager-check-circle" style="font-size: 24px; color: #3490dc;"></i>
                    </div>
                    <div class="subscription-details">
                        <h5 class="mb-1">${subscriptionType} Subscription</h5>
                        <p class="mb-1 text-muted">Duration: ${recurringPeriod}</p>
                        <p class="mb-1 text-muted">Price: $${subscription.price}</p>
                        ${description ? `<p class="mb-0">${description}</p>` : ''}
                    </div>
                </div>
            </div>
        </label>
    </div>
`);

                                });
                            } else {
                                subscriptionList.html(
                                    '<div class="no-subscriptions">No subscriptions available for this magazine.</div>'
                                );
                            }
                        },
                        error: function() {
                            subscriptionList.html(
                                '<div class="alert alert-danger">Error loading subscriptions. Please try again later.</div>'
                            );
                        }
                    });
                } else {
                    subscriptionList.html(
                        '<div class="no-subscriptions">Please select a magazine first to view available subscriptions</div>'
                    );
                }
            });
            // Trigger change if magazine is pre-selected (edit mode)
            @if (old('magazine_id', $dataTypeContent->magazine_id ?? false))
                $('#magazine_id').trigger('change');
            @endif
        });
    </script>
    <script>
        $(document).ready(function() {
            // Show shipping info if a physical subscription is selected on page load
            let selectedType = $('.subscription-radio:checked').data('type');
            if (selectedType === 'physical') {
                $('#shipping-info').show();
            }

            // Handle selection changes
            $(document).on('change', '.subscription-radio', function() {
                let type = $(this).data('type');
                if (type === 'physical') {
                    $('#shipping-info').slideDown();
                } else {
                    $('#shipping-info').slideUp();
                }
            });
        });
    </script>
    <script>
        $('#magazine-offer-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    let userId = form.find('#user_id').val();
                    let receiverEmail = form.find('#receiver_email').val();

                    if (userId || receiverEmail) {
                        $.ajax({
                            url: "{{ route('admin.magazine-offer.send-email') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                user_id: userId,
                                email: receiverEmail
                            },
                            success: function(mailResponse) {
                                alert("✅ Email sent successfully!");
                                window.location.href =
                                    "{{ route('voyager.magazine-offers.index') }}";
                            },
                            error: function(err) {
                                if (err.responseJSON && err.responseJSON.message) {
                                    alert("❌ " + err.responseJSON.message);
                                    $('#receiver_email').addClass('is-invalid');
                                } else {
                                    alert("❌ Failed to send email.");
                                }
                            }
                        });
                    } else {
                        alert("❌ Please select a user or enter an email!");
                    }
                },
                error: function(err) {
                    console.error('Failed to save magazine offer', err);
                    alert('Something went wrong while saving!');
                }
            });
        });
    </script>

@stop
