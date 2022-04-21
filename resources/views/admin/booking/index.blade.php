@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
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
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{$booking->id}}</td>
                                        <td>{{$booking->user->name}}</td>
                                        <td>{{$booking->event->name}}</td>
                                        <td>{{$booking->event->venue->name}}</td>
                                        <td>{{$booking->event->type}}</td>
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
                                        <!-- <td>
                                            <button class="btn btn-rounded btn-success mb-1" onclick="openApproveModal('{{$booking->id}}')"><i class="fa fa-check"></i></button>
                                            <button class="btn btn-rounded btn-danger mb-1" onclick="openRejectModal('{{$booking->id}}')"><i class="fa fa-remove"></i></button>
                                        </td> -->
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
@endsection

@section('scripts')
    <script>
        const openApproveModal = (event_id) => {
            let url = "{{ route('admin.booking.approve', 0) }}";
            url = url.substr(0, url.length-1) + event_id;
            $("#modal_delete").modal('show');
            $("#modal_delete .modal-title").text(`Approve Booking`);
            var content = '<button type="button" class="btn btn-info">';
                content += `<a href="${url}">`;
                content += "Yes</a></button>";
                content += '<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>';
            $("#modal_delete .modal-footer").html(content);
            $("#modal_delete .modal-body").text('Are you sure you want to approve this booking?');
        }

        const openRejectModal = (event_id) => {
            let url = "{{ route('admin.booking.reject', 0) }}";
            url = url.substr(0, url.length-1) + event_id;
            $("#modal_delete").modal('show');
            $("#modal_delete .modal-title").text(`Reject Booking`);
            var content = '<button type="button" class="btn btn-info">';
                content += `<a href="${url}">`;
                content += "Yes</a></button>";
                content += '<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>';
            $("#modal_delete .modal-footer").html(content);
            $("#modal_delete .modal-body").text('Are you sure you want to reject this booking?');
        }

        const openTimetableModal = (venue, timetable) => {
            timetable = JSON.parse(timetable);
            var days = ["mon", "tue", "wed", "thu", "fri", "sat", "sun"];
            
            $("#modal_venue").modal('show');
            $("#modal_venue .modal-title").text(`"${venue}" Timetable`);
            var content = '<div class="table-responsive"><table class="table table-responsive-sm">';
                content += '<thead>';
                    content += '<tr>';
                        content += '<th>#</th>';
                        content += '<th>Open</th>';
                        content += '<th>Close</th>';
                    content += '</tr>';
                content += '</thead>';
                content += '<tbody>';
                    days.map(day => {
                        content += '<tr>';
                            content += '<td>' + day.toUpperCase() + '</td>';
                            content += '<td>' + timetable[day + '_open'] + '</td>';
                            content += '<td>' + timetable[day + '_close'] + '</td>';
                        content += '</tr>';
                    });
                content += '</tbody>';
            content += '</table></div>';
            $("#modal_venue .modal-body").html(content);
        }

        const openTableModal = (venue, tables) => {
            tables = JSON.parse(tables);
            $("#modal_venue").modal('show');
            $("#modal_venue .modal-title").text(`"${venue}" Tables`);
            var content = '<div class="table-responsive"><table class="table table-responsive-sm">';
                content += '<thead>';
                    content += '<tr>';
                        content += '<th>Type</th>';
                        content += '<th>Description</th>';
                        content += '<th>Quantity</th>';
                        content += '<th>Price</th>';
                        content += '<th>Approval</th>';
                    content += '</tr>';
                content += '</thead>';
                content += '<tbody>';
                    tables.map(table => {
                        content += '<tr>';
                            content += '<td>' + table.type + '</td>';
                            content += '<td>' + table.description + '</td>';
                            content += '<td>' + table.qty + '</td>';
                            content += '<td>£' + table.price.toFixed(2) + '</td>';
                            content += '<td>' + table.approval + '</td>';
                        content += '</tr>';
                    });
                content += '</tbody>';
            content += '</table></div>';
            $("#modal_venue .modal-body").html(content);
        }

        const openOfferModal = (venue, offers) => {
            offers = JSON.parse(offers);
            $("#modal_venue").modal('show');
            $("#modal_venue .modal-title").text(`"${venue}" Offers`);
            var content = '<div class="table-responsive"><table class="table table-responsive-sm">';
                content += '<thead>';
                    content += '<tr>';
                        content += '<th>Type</th>';
                        content += '<th>Description</th>';
                        content += '<th>Quantity</th>';
                        content += '<th>Price</th>';
                        content += '<th>Approval</th>';
                    content += '</tr>';
                content += '</thead>';
                content += '<tbody>';
                    offers.map(offer => {
                        content += '<tr>';
                            content += '<td>' + offer.type + '</td>';
                            content += '<td>' + offer.description + '</td>';
                            content += '<td>' + offer.qty + '</td>';
                            content += '<td>£' + offer.price.toFixed(2) + '</td>';
                            content += '<td>' + offer.approval + '</td>';
                        content += '</tr>';
                    });
                content += '</tbody>';
            content += '</table></div>';
            $("#modal_venue .modal-body").html(content);
        }

        const openDetailModal = (venue) => {
            venue = JSON.parse(venue);
            $("#modal_venue").modal('show');
            $("#modal_venue .modal-title").text(`"${venue.name}" Details`);
            var content = '<ul class="list-group list-group-flush">';
                content += '<li class="list-group-item">';
                    content += '<h5>Description:</h5>';
                    content += '<span>' + venue.description + '</span>';
                content += '</li>';
                content += '<li class="list-group-item">';
                    content += '<h5>Facilities:</h5>';
                    content += '<span>' + venue.facilities + '</span>';
                content += '</li>';
                content += '<li class="list-group-item">';
                    content += '<h5>Music Policy:</h5>';
                    content += '<span>' + venue.music_policy + '</span>';
                content += '</li>';
                content += '<li class="list-group-item">';
                    content += '<h5>Dress code:</h5>';
                    content += '<span>' + venue.dress_code + '</span>';
                content += '</li>';
                content += '<li class="list-group-item">';
                    content += '<h5>Perks:</h5>';
                    content += '<span>' + venue.perks + '</span>';
                content += '</li>';
            content += '</ul>';
            $("#modal_venue .modal-body").html(content);
        }

        const openMediaModal = (venue, headerImage, images) => {
            images = JSON.parse(images);
            $("#modal_venue_media").modal('show');
            $("#modal_venue_media .modal-title").text(`"${venue}" Gallery`);
            var content = '<div id="carouselControls" class="carousel slide" data-ride="carousel">';
                content += '<div class="carousel-inner">';
                    content += '<div class="carousel-item active">';
                        content += '<img class="d-block w-100" src="../' + headerImage + '" alt="Header Image">';
                        content += '<div class="carousel-caption d-none d-md-block"><h5>Header Image</h5></div>';
                    content += '</div>';
                    images.map(image => {
                        content += '<div class="carousel-item">';
                        if(image.type === 'image'){
                            content += '<img class="d-block w-100" src="../' + image.path + '" alt="Gallery Image">';
                            content += '<div class="carousel-caption d-none d-md-block"><h5>Gallery Image</h5></div>';
                        }
                        if(image.type === 'video' || image.type === 'link'){
                            content += '<video controls autoplay>';
                                content += '<source src="../' + image.path + '" type="video/mp4">';
                            content += '</video>';
                            content += '<div class="carousel-caption d-none d-md-block"><h5>Video</h5></div>';
                        }                        
                        content += '</div>';
                    });
                content += '</div>';
                content += `
                <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                `;
            content += '</div>';
            $("#modal_venue_media .modal-body").html(content);
            $('.carousel').carousel();
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