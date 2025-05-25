@extends('voyager::master')

@section('page_title', $event->title . ' Extras')

@section('content')
    <div class="container">
        <h1>{{ $event->name }} - Analytics</h1>
        <hr>
        @include('vendor.voyager.events.partial.buttons')

        <div class="panel panel-bordered">
            <div class="panel-body">
                <a href="{{ route('voyager.extras.create') }}" class="btn btn-success">Adicionar</a>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Price</th>
                            <th>Tax</th>
                            <th>Type</th>
                            <th>Zone</th>
                            <th>Category</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($extras as $extra)
                            <tr>
                                <td>{{ $extra->name }}</td>
                                <td>{{ $extra->display_name }}</td>
                                <td>{{ $extra->price }}€</td>
                                <td>{{ $extra->tax }}</td>
                                <td>{{ ucfirst($extra->type) }}</td>
                                <td>{{ $extra->zone->name ?? '-' }}</td>
                                <td>{{ $extra->extraCategory->name ?? '-' }}</td>
                                <td>{{ $extra->created_at }}</td>
                                <td>
                                    <a href="{{ route('voyager.extras.show', $extra->id) }}"
                                        class="btn btn-sm btn-warning">Ver</a>
                                    <a href="{{ route('voyager.extras.edit', $extra->id) }}"
                                        class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('voyager.extras.destroy', $extra->id) }}" method="POST"
                                        style="display:inline-block;">
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
                    {{ $extras->links() }}
                </div>

                
            </div>
        </div>


    </div>
@endsection
