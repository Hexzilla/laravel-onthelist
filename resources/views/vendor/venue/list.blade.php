@extends('layouts.vendor')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Venues</a></li>
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
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>Phone</th>
                                        <th>Details</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venues as $venue)
                                    <tr>
                                        <td>{{$venue->name}}</td>
                                        <td>{{$venue->type}}</td>
                                        <td>{{$venue->location}}</td>
                                        <td>{{$venue->phone}}</td>
                                        <td>
                                            <button type="button" class="btn btn-rounded btn-outline-primary mb-1" onclick="openTimetableModal('{{$venue->name}}', '{{$venue->timetable}}')">Show Timetable</button>
                                            <button type="button" class="btn btn-rounded btn-outline-secondary mb-1" onclick="openTableModal('{{$venue->name}}', '{{$venue->tables}}')">Show Tables</button>
                                            <button type="button" class="btn btn-rounded btn-outline-success mb-1" onclick="openOfferModal('{{$venue->name}}', '{{$venue->offers}}')">Show Offers</button>
                                            <button type="button" class="btn btn-rounded btn-outline-warning mb-1" onclick="openMediaModal('{{$venue->name}}', '{{$venue->header_image_path}}', '{{$venue->media}}')">Show Media</button>
                                            <button type="button" class="btn btn-rounded btn-outline-info mb-1" onclick="openDetailModal('{{$venue}}')">Show More</button>
                                        </td>
                                        <td>
                                            @if($venue->isApproved())
                                            <span class="badge badge-success">Approved</span>
                                            @else
                                            <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-rounded btn-primary mb-1"><a href="{{ route('vendors.venue.edit', $venue->id) }}"><i class="fa fa-edit"></i> Edit</a></button>
                                            @if(!$venue->isApproved())
                                            <button type="button" class="btn btn-rounded btn-danger mb-1" onclick="openDeleteModal('{{$venue->name}}', '{{$venue->id}}' )"><i class="fa fa-trash"></i> Delete</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
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
        const openDeleteModal = (venue, venue_id) => {
            let url = "{{ route('vendors.venue.destroy', 0) }}";
            url = url.substr(0, url.length-1) + venue_id;
            $("#modal_delete").modal('show');
            $("#modal_delete .modal-title").text(`Delete ${venue}`);
            var content = '<button type="button" class="btn btn-info">';
                content += `<a href="${url}">`;
                content += "Delete</a></button>";
                content += '<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>';
            $("#modal_delete .modal-footer").html(content);
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
    </script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
@endsection