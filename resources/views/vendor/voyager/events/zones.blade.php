@extends('voyager::master')

@section('page_title', $event->title . ' Zones')

@section('css')
    <style>
        .card {
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .table thead th {
            border-top: none;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #f5f5f5;
        }

        .badge {
            font-size: 12px;
            font-weight: 500;
        }

        .btn-group-sm>.btn {
            padding: 5px 10px;
            font-size: 12px;
        }

        .panel {
            box-shadow: none;
            border-radius: 4px;
        }

        .stat-card {
            border-left: 4px solid #337ab7;
            padding: 15px;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .stat-card h1 {
            font-size: 14px;
            margin-top: 0;
            color: #337ab7;
            text-transform: uppercase;
        }

        .stat-card h3 {
            font-size: 24px;
            margin-bottom: 0;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <h1>{{ $event->name }} - Analytics</h1>
        <hr>
        @include('vendor.voyager.events.partial.buttons')

        <div class="panel panel-bordered">
            <div class="panel-body">
                <a href="{{ route('voyager.zones.create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Add New Zone
                </a>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Security Key</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zones as $zone)
                                <tr>
                                    <td><strong>{{ $zone->name }}</strong></td>
                                    <td>
                                        <span class="label label-default">{{ $zone->security_key ?? '-' }}</span>
                                    </td>
                                    <td class="text-right">

                                        <a href="{{ route('voyager.zones.show', $zone->id) }}" class="btn btn-default me-2">
                                            <i class="voyager-eye"></i>
                                        </a>
                                        <a href="{{ route('voyager.zones.edit', $zone->id) }}" class="btn btn-primary">
                                            <i class="voyager-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('voyager.zones.destroy', $zone->id) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this zone?')"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="voyager-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                {!! $zones->links() !!} <!-- Use $zones instead of $event->zones -->
            </div>
        </div>

    </div>
@stop
