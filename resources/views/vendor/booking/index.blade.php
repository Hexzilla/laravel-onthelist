@extends('layouts.vendor')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Bookings</a></li>
                </ol>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>ID No</th>
                                        <th>Client</th>
                                        <th>Event Name</th>
                                        <th>Venue</th>
                                        <th>Event Type</th>
                                        <th>Booking Type</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{$booking->id}}</td>
                                        <td>{{$booking->userName}}</td>
                                        <td>{{$booking->eventName}}</td>
                                        <td>{{$booking->venueName}}</td>
                                        <td>{{$booking->eventType}}</td>
                                        <td>{{$booking->booking_type}}</td>
                                        <td>£ {{$booking->price}}</td>
                                        <td>
                                            @if($booking->status == 'Rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                            @elseif($booking->status === 'Pending')
                                            <span class="badge badge-warning">Pending</span>
                                            @else
                                            <span class="badge badge-success">Approved</span>
                                            @endif
                                        </td>
                                        <td>{{$booking->date}}</td>
                                        <td>
                                            <button class="btn btn-rounded btn-success mb-1" title="Approve" onclick="openApproveModal('{{$booking->id}}')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="btn btn-rounded btn-danger mb-1" title="Reject" onclick="openRejectModal('{{$booking->id}}')">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                            <div style="display: flex; justify-content: end; margin-right: 40px;">
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="modal_approve_v2">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Booking</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to approve this booking?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="modal_reject_v2">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Booking</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to reject this booking?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const openApproveModal = (event_id) => {
        let url = "{{ route('vendors.booking.approve', 0) }}";
        url = url.substr(0, url.length - 1) + event_id;
        let html = $("#modal_approve_v2").html().replace('$URL', url);
        $("#modal_approve_v2").html(html);
        $("#modal_approve_v2").modal('show');
    }

    const openRejectModal = (event_id) => {
        let url = "{{ route('vendors.booking.reject', 0) }}";
        url = url.substr(0, url.length - 1) + event_id;
        let html = $("#modal_reject_v2").html().replace('$URL', url);
        $("#modal_reject_v2").html(html);
        $("#modal_reject_v2").modal('show');
    }
    window.addEventListener('load', (event) => {
            initDataTable('example', {
                info: false,
                paging: false,
            })
        });
</script>
<script src="{{ asset('js/datatable.js') }}"></script>
@endsection