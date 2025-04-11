@extends('voyager::master')

@section('page_title', __('voyager::generic.view') . ' ' . $dataType->getTranslatedAttribute('display_name_singular'))
@section('css')

    <style>
        .archive-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: #ddd;
        }

        .description-box img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin: 10px 0;
        }

        .description-box p {
            margin-bottom: 10px;
        }

        .archive-actions .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            left: auto !important;
            right: 0 !important;
            margin-top: 0.125rem !important;
        }
    </style>
@stop
@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }}
        {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.' . $dataType->slug . '.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <i class="glyphicon glyphicon-pencil"></i> <span
                    class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
            </a>
        @endcan
        @can('delete', $dataTypeContent)
            @if ($isSoftDeleted)
                <a href="{{ route('voyager.' . $dataType->slug . '.restore', $dataTypeContent->getKey()) }}"
                    title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore"
                    data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete"
                    data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan
        @can('browse', $dataTypeContent)
            <a href="{{ route('voyager.' . $dataType->slug . '.index') }}" class="btn btn-warning">
                <i class="glyphicon glyphicon-list"></i> <span
                    class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
            </a>
        @endcan
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="panel panel-bordered" style="border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="panel-body" style="padding: 25px;">
                <!-- Header Section -->
                {{-- <div class="row" style="margin-bottom: 30px; border-bottom: 1px solid #f0f0f0; padding-bottom: 20px;">
                    <div class="col-md-3">
                        <img src="{{ Voyager::image($dataTypeContent->image) }}" alt="Magazine Cover"
                            style="max-height: 180px; border-radius: 4px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); border: 1px solid #eaeaea;">


                    </div>
                    <div class="col-md-3">
                        <h2 style="margin: 0; color: #2c3e50; font-weight: 700;">{{ $dataTypeContent->name }}</h2>
                        <div style="margin-top: 10px;">
                            <span class="badge {{ $dataTypeContent->status == 1 ? 'badge-success' : 'badge-danger' }}"
                                style="font-size: 12px; padding: 5px 10px; border-radius: 12px;">
                                {{ $dataTypeContent->status_text }}
                            </span>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 style="color: #7f8c8d; font-weight: 600; margin-bottom: 15px;">Description</h4>
                        <div class="description-box"
                            style="background: #f9f9f9; 
                                padding: 20px; 
                                border-radius: 6px; 
                                border-left: 4px solid #3498db;
                                line-height: 1.6;
                                font-size: 15px;">
                            {!! $dataTypeContent->description !!}
                        </div>
                    </div>
                </div> --}}



                <!-- Archives Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h4 style="color: #7f8c8d; font-weight: 600; margin: 0;">Archives</h4>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#addArchiveModal" style="border-radius: 4px; padding: 8px 16px;">
                                <i class="icon voyager-plus"></i> Add Archive
                            </button>
                        </div>

                        @if ($dataTypeContent->archives && $dataTypeContent->archives->count())
                            <div class="row">
                                @foreach ($dataTypeContent->archives as $archive)
                                    <div class="col-md-4" style="margin-bottom: 20px;">
                                        <div class="archive-card" id="archive-{{ $archive->id }}"
                                            style="background: white; 
                                            border-radius: 6px; 
                                            padding: 20px; 
                                            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                                            border: 1px solid #eee;
                                            height: 100%;
                                            transition: all 0.3s ease;
                                            display: flex;
                                            flex-direction: column;
                                            position: relative;
                                            overflow: visible;">

                                            <!-- Action Dropdown -->
                                            <div class="dropdown archive-actions"
                                                style="position: absolute; right: 15px; top: 15px;">
                                                <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                    id="dropdownMenuButton-{{ $archive->id }}" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon voyager-settings"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton-{{ $archive->id }}">
                                                    <a class="dropdown-item edit-archive"style="margin-left:10px;"
                                                        href="#" data-id="{{ $archive->id }}">
                                                        <i class="icon voyager-edit"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item delete-archive"style="margin-left:10px;"
                                                        href="#" data-id="{{ $archive->id }}">
                                                        <i class="icon voyager-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>

                                            <h5 style="margin-top: 0; color: #2c3e50; font-weight: 600;">
                                                {{ $archive->title }}</h5>

                                            @if ($archive->description)
                                                <div style="margin: 10px 0; flex-grow: 1;">
                                                    <div style="font-size: 12px; color: #7f8c8d; margin-bottom: 5px;">
                                                        Description</div>
                                                    <div
                                                        style="font-size: 13px; color: #34495e; line-height: 1.5; max-height: 100px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; border-left: 2px solid #eee; padding-left: 10px;">
                                                        {{ Str::limit(strip_tags($archive->description), 150) }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div
                                                style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                                <div>
                                                    <span style="font-size: 13px; color: #7f8c8d;">Quantity:</span>
                                                    <span
                                                        style="font-weight: 600; color: #3498db;">{{ $archive->quantity }}</span>
                                                </div>
                                                <div>
                                                    <span style="font-size: 13px; color: #7f8c8d;">Shipping:</span>
                                                    <span
                                                        style="font-weight: 600; color: #e67e22;">${{ number_format($archive->shipping_cost, 2) }}</span>
                                                </div>
                                                <div>
                                                    <span style="font-size: 13px; color: #7f8c8d;">Price:</span>
                                                    <span
                                                        style="font-weight: 600; color: #27ae60;">${{ number_format($archive->price, 2) }}</span>
                                                </div>
                                            </div>

                                            <a href="{{ Voyager::image($archive->pdf_file) }}" target="_blank"
                                                class="btn btn-sm btn-primary"
                                                style="width: 100%; border-radius: 4px; padding: 6px 12px;">
                                                <i class="icon voyager-file-text"></i> View PDF
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Archive Modal -->
    <div class="modal fade" id="addArchiveModal" tabindex="-1" role="dialog" aria-labelledby="addArchiveModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addArchiveModalLabel">Add New Archive</h4>
                </div>
                <form id="archiveForm" action="{{ route('magazines.archives.store', $dataTypeContent->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="title" name="title"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_cost">Shipping Cost</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" id="shipping_cost"
                                            name="shipping_cost"
                                            value="{{ old('shipping_cost', $archive->shipping_cost ?? 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control" id="price"
                                            name="price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                style="min-height: 100px; resize: vertical;" placeholder="Enter archive description (optional)"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="pdf_file">PDF File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="pdf_file" name="pdf_file"
                                    accept=".pdf" required>
                                <label class="custom-file-label" for="pdf_file">Choose PDF file...</label>
                            </div>
                            <small class="form-text text-muted">Max file size: 2MB</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Archive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Archive Modal -->
    <div class="modal fade" id="editArchiveModal" tabindex="-1" role="dialog" aria-labelledby="editArchiveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editArchiveModalLabel">Edit Archive</h4>
                </div>
                <form id="editArchiveForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_title">Title</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_cost">Shipping Cost</label>

                                <input type="number" step="0.01" class="form-control" id="shipping_cost"
                                    name="shipping_cost" required>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_price">Price</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_price"
                                        name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_quantity">Quantity</label>
                                    <input type="number" class="form-control" id="edit_quantity" name="quantity"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" required rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_pdf_file">PDF File (Leave empty to keep current)</label>
                            <input type="file" class="form-control" id="edit_pdf_file" name="pdf_file"
                                accept=".pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Archive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Notification Toast -->
    @if (session('success'))
        <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999; right: 0; bottom: 0;">
            <div id="successToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true"
                data-delay="5000">
                <div class="toast-header bg-success text-white">
                    <strong class="mr-auto">Success</strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <div class="page-content read container-fluid">
        <div class="panel panel-bordered" style="border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="panel-body" style="padding: 25px;">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Subscriptions Section -->
                        <div>
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h4 style="color: #7f8c8d; font-weight: 600; margin: 0;">Subscription Plans</h4>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#addSubscriptionModal" style="border-radius: 4px; padding: 8px 16px;">
                                    <i class="icon voyager-plus"></i> Add Subscription
                                </button>
                            </div>

                            @if ($dataTypeContent->subscriptions && $dataTypeContent->subscriptions->count())
                                <div class="row">
                                    @foreach ($dataTypeContent->subscriptions as $subscription)
                                        <div class="col-md-6" style="margin-bottom: 20px;">
                                            <div class="subscription-card" id="subscription-{{ $subscription->id }}"
                                                style="background: white; 
                                            border-radius: 6px; 
                                            padding: 20px; 
                                            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                                            border: 1px solid #eee;
                                            height: 100%;
                                            position: relative;
                                            overflow: visible;">

                                                <!-- Action Dropdown -->
                                                <div class="dropdown subscription-actions"
                                                    style="position: absolute; right: 15px; top: 15px;">
                                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                                                        id="subscriptionDropdown-{{ $subscription->id }}"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="icon voyager-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="subscriptionDropdown-{{ $subscription->id }}">
                                                        <a class="dropdown-item edit-subscription" href="#"
                                                            data-id="{{ $subscription->id }}" style="margin-left:10px;">
                                                            <i class="icon voyager-edit"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item delete-subscription" href="#"
                                                            data-id="{{ $subscription->id }}" style="margin-left:10px;">
                                                            <i class="icon voyager-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </div>

                                                <h5 style="margin-top: 0; color: #2c3e50; font-weight: 600;">
                                                    {{ $subscription->name }}
                                                    <span class="badge badge-primary">
                                                        {{ ucfirst($subscription->subscription_type) }}
                                                    </span>
                                                </h5>

                                                <div style="margin: 15px 0;">
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <div>
                                                            <span style="font-size: 13px; color: #7f8c8d;">Price:</span>
                                                            <span style="font-weight: 600; color: #27ae60;">
                                                                ${{ number_format($subscription->price, 2) }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span style="font-size: 13px; color: #7f8c8d;">Billing
                                                                Period:</span>
                                                            <span style="font-weight: 600; color: #3498db;">
                                                                {{ $subscription->recurring_period == 'annual' ? 'Annual (12 months)' : 'Bi-Annual (24 months)' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="background: #f9f9f9; padding: 10px; border-radius: 4px;">
                                                    <div style="font-size: 12px; color: #7f8c8d;">Includes:</div>
                                                    <ul style="margin-bottom: 0; padding-left: 20px;">
                                                        @if ($subscription->subscription_type == 'digital')
                                                            <li>Full digital access to all archives</li>
                                                            <li>Weekly email updates</li>
                                                            <li>Mobile app access</li>
                                                        @else
                                                            <li>Physical magazine delivery</li>
                                                            <li>Free shipping</li>
                                                            <li>Digital access included</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state"
                                    style="text-align: center; padding: 40px; background: #f9f9f9; border-radius: 6px;">
                                    <i class="icon voyager-archive" style="font-size: 50px; color: #bdc3c7;"></i>
                                    <h4 style="color: #7f8c8d; margin-top: 15px;">No Subscription Plans</h4>
                                    <p style="color: #95a5a6;">This magazine doesn't have any subscription plans yet.</p>
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#addSubscriptionModal" style="margin-top: 10px;">
                                        <i class="icon voyager-plus"></i> Add First Subscription
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Subscription Modal -->
    <div class="modal fade" id="addSubscriptionModal" tabindex="-1" role="dialog"
        aria-labelledby="addSubscriptionModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addSubscriptionModalLabel">Add Subscription Plan</h4>
                </div>
                <form id="subscriptionForm" action="{{ route('magazines.subscriptions.store', $dataTypeContent->id) }}"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subscription_name">Plan Name</label>
                                    @php

                                        $subscriptions = App\Models\MagazineSubscription::all();
                                    @endphp
                                    <select class="form-control" id="magazine_subscription_id"
                                        name="magazine_subscription_id" required>
                                        @foreach ($subscriptions as $subscription)
                                            <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recurring_period">Billing Period (month)</label>
                                    <input type="number" class="form-control" id="recurring_period"
                                        name="recurring_period" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subscription_type">Subscription Type</label>
                                    <select class="form-control" id="subscription_type" name="subscription_type"
                                        required>
                                        <option value="digital">Digital</option>
                                        <option value="physical">Physical</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subscription_price">Price</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            id="subscription_price" name="price" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Subscription</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Subscription Modal -->
    <div class="modal fade" id="editSubscriptionModal" tabindex="-1" role="dialog"
        aria-labelledby="editSubscriptionModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editSubscriptionModalLabel">Edit Subscription</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editSubscriptionForm" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="edit_subscription_id" name="subscription_id">

                        <div class="form-group">
                            <label for="edit_name">Subscription Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_subscription_type">Subscription Type</label>
                            <select class="form-control" id="edit_subscription_type" name="subscription_type" required>
                                <option value="physical">Physical</option>
                                <option value="digital">Digital</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_price">Price</label>
                            <input type="number" step="0.01" class="form-control" id="edit_price" name="price"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="edit_recurring_period">Recurring Period</label>
                            <select class="form-control" id="edit_recurring_period" name="recurring_period" required>
                                <option value="annual">Annual</option>
                                <option value="bi-annual">Bi-Annual</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Subscription</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}
                        {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.' . $dataType->slug . '.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                            value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/) ?
                deleteFormAction.replace(/([0-9]+$)/, $(this).data('id')) :
                deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });
    </script>
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("pdf_file").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>

    <script>
        $(document).on('click', '.edit-archive', function(e) {
            e.preventDefault();

            var archiveId = $(this).data('id');
            var $modal = $('#editArchiveModal');
            $modal.modal('show');

            $.get('/admin/archives/' + archiveId + '/edit')
                .done(function(data) {
                    $modal.find('#edit_title').val(data.title);
                    $modal.find('#edit_description').val(data.description);
                    $modal.find('#edit_price').val(data.price);
                    $modal.find('#edit_quantity').val(data.quantity);
                    $modal.find('#shipping_cost').val(data.shipping_cost);

                    $modal.find('#editArchiveForm').attr('action', '/admin/archives/' + archiveId);
                })
                .fail(function() {
                    $modal.modal('hide');
                    toastr.error('Failed to load archive data');
                });
        });



        // Submit Edit Form
        $('#editArchiveForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append('_method', 'PUT');

            var url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editArchiveModal').modal('hide');
                    location.reload();
                    toastr.success('Archive updated successfully!');

                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                }
            });
        });
        // Delete Archive
        $('.delete-archive').click(function(e) {
            e.preventDefault();
            var archiveId = $(this).data('id');

            if (confirm('Are you sure you want to delete this archive?')) {
                $.ajax({
                    url: '/admin/archives/' + archiveId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#archive-' + archiveId).fadeOut(300, function() {
                                $(this).remove();
                            });
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting archive');
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add new subscription
            $('#subscriptionForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addSubscriptionModal').modal('hide');
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('Error: ' + (xhr.responseJSON.message ||
                                'Something went wrong'));
                        }
                    }
                });
            });

            // Edit subscription - fetch data and populate modal
            $(document).on('click', '.edit-subscription', function() {
                var subId = $(this).data('id');
                var $modal = $('#editSubscriptionModal');
                $.ajax({
                    url: '/subscriptions/' + subId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Populate form fields directly from response.data
                            $('#edit_subscription_id').val(response.data.id);
                            $('#edit_name').val(response.data.name);
                            $('#edit_subscription_type').val(response.data.subscription_type);
                            $('#edit_price').val(response.data.price);
                            $('#edit_recurring_period').val(response.data.recurring_period);

                            // Set form action
                            $('#editSubscriptionForm').attr('action', '/subscriptions/' +
                                subId);

                            // Show modal
                            $('#editSubscriptionModal').modal('show');
                        } else {
                            toastr.error('Failed to load subscription data');
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error: ' + (xhr.responseJSON.message ||
                            'Failed to load data'));
                    }
                });
            });

            // Update subscription
            $('#editSubscriptionForm').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form.serialize() + '&_method=PUT',
                    success: function(response) {
                        if (response.success) {
                            $('#editSubscriptionModal').modal('hide');
                            toastr.success(response.message);
                            location.reload();
                        } else {
                            toastr.error(response.message || 'Update failed');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('Error: ' + (xhr.responseJSON.message ||
                                'Update failed'));
                        }
                    }
                });
            });

            // Delete subscription
            $(document).on('click', '.delete-subscription', function(e) {
                e.preventDefault();

                if (confirm(
                        'Are you sure you want to delete this subscription? This action cannot be undone.'
                    )) {
                    var subId = $(this).data('id');
                    var $row = $('#subscription-' + subId);

                    $.ajax({
                        url: '/subscriptions/' + subId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        beforeSend: function() {
                            $row.css('opacity', '0.5');
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $row.fadeOut('slow', function() {
                                    $(this).remove();
                                });
                            } else {
                                toastr.error(response.message || 'Delete failed');
                                $row.css('opacity', '1');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Error: ' + (xhr.responseJSON.message ||
                                'Delete failed'));
                            $row.css('opacity', '1');
                        }
                    });
                }
            });
        });
    </script>
@stop
