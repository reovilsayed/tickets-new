@extends('voyager::master')

@section('page_title', $event->title . ' Extras')

@section('content')
    <div class="container">
        <h1>{{ $event->name }} - Analytics</h1>
        <hr>
        @include('vendor.voyager.events.partial.buttons')

        <div class="panel panel-bordered">
            <div class="panel-body">
                <a href="{{ route('voyager.extra-categories.create') }}" class="btn btn-success">Adicionar</a>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Order</th>
                            <th>Event</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($extraCategory as $extraCat)
                            <tr>
                                <td>{{ $extraCat->name }}</td>
                                <td>{{ $extraCat->slug }}</td>
                                <td>{{ $extraCat->order }}</td>
                                <td>{{ $extraCat->event->name ?? '-' }}</td>
                                <td>{{ $extraCat->created_at }}</td>
                                <td>
                                    <a href="{{ route('voyager.extra-categories.show', $extraCat->id) }}"
                                        class="btn btn-sm btn-warning">Ver</a>
                                    <a href="{{ route('voyager.extra-categories.edit', $extraCat->id) }}"
                                        class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('voyager.extra-categories.destroy', $extraCat->id) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">No results</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $extraCategory->links() }}
                </div>


            </div>
        </div>


    </div>
@endsection
