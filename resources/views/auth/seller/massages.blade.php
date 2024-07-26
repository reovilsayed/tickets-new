@extends('layouts.seller-dashboar')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card space-bottom-30">
            <div class="ec-vendor-card-header">
                <h5>Massages</h5>


            </div>

            @if (count($massages) == !0)
                <div class="ec-vendor-card-body">

                    <div class="ec-vendor-card-table">



                        <table class="table ec-table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Massage</th>
                                    <th scope="col">Reply Massage</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($massages as $massage)
                                    <tr>
                                        <th scope="row"><span>{{ $loop->index + 1 }}</span></th>
                                        <td><span>{{ $massage->email }}</span></td>
                                        <td><span>{{ $massage->massage }}</span></td>
                                        <td>
                                            @foreach ($massage->child as $child)
                                            <span >{{ $child->massage }}</span>
                                            @endforeach
                                        
                                        </td>
                                        <td><span><a href="javascript:void(0)"  data-bs-id="{{ $massage->id }}" data-bs-toggle="modal" data-bs-target="#massageModal" class="btn btn-danger">Reply</a></span></td>

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>

                    </div>

                </div>
            @else
                <h3 class="text-center text-danger">No Massages Found</h3>
            @endif
        </div>
    </div>

    <div class="modal fade" id="massageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Send Massage</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('vendor.massage.reply')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="massage">Massage</label>
                            <textarea class="form-control" rows="5" name="massage" id="massage" required></textarea>
                        </div>
                        <input id="massageId" type="hidden" name="massage_id" value="">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
    var exampleModal = document.getElementById('massageModal')
    exampleModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-id')
        var modalBodyInput = exampleModal.querySelector('#massageId')

        modalBodyInput.value = recipient
    })
</script>
@endsection
