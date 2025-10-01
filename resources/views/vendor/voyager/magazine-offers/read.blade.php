@extends('voyager::master')

@section('page_title', __('voyager::generic.view') . ' ' . $dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }}

        @can('browse', $dataTypeContent)
            <a href="{{ route('voyager.' . $dataType->slug . '.index') }}" class="btn btn-warning">
                <i class="glyphicon glyphicon-list"></i>
                <span class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
            </a>
        @endcan
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">

                    {{-- Magazine Info --}}
                    <div class="panel-heading">
                        <h3 class="panel-title">Magazine</h3>
                    </div>
                 
                    <div class="panel-body">
                        <p><strong>Magazine:</strong> {{ $dataTypeContent->magazine->name ?? 'N/A' }}</p>
                        <p><strong>Subscription Details:</strong>
                            {{ $dataTypeContent->subscription->subscription_type ?? 'N/A' }}</p>
                        <p><strong>Price:</strong>
                            {{ $dataTypeContent->subscription->price ?? 'N/A' }}</p>
                        <p><strong>Recurring Period:</strong>
                            {{ $dataTypeContent->subscription->recurring_period ?? 'N/A' }}</p>
                    </div>
                    <hr>

                    {{-- Receiver Info --}}
                    <div class="panel-heading">
                        <h3 class="panel-title">Receiver Information</h3>
                    </div>
                    <div class="panel-body">
                        <p><strong>Name:</strong> {{ $dataTypeContent->receiver_name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $dataTypeContent->receiver_email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $dataTypeContent->receiver_phone ?? 'N/A' }}</p>
                    </div>
                    <hr>

                    {{-- Created Info --}}
                    <div class="panel-heading">
                        <h3 class="panel-title">System Info</h3>
                    </div>
                    <div class="panel-body">
                        <p><strong>Created At:</strong>
                            {{ $dataTypeContent->created_at ? $dataTypeContent->created_at->format('d M, Y H:i') : 'N/A' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
