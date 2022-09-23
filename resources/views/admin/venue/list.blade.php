@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Venues</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $breadcrumb }}</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 col-xxl-12">	
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="float-right">
                                <button type='button' class="btn btn-rounded btn-outline-success mb-1">
                                    <a href="{{ route('admin.venues.city' )}}">Add City</a>
                                </button>
                            </div>
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>City</th>
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
                                        <td>{{$venue->city}}</td>
                                        <td>{{$venue->location}}</td>
                                        <td>{{$venue->phone}}</td>
                                        <td>
                                            <button type="button" class="btn btn-rounded btn-outline-primary mb-1" onclick="openTimetableModal('{{$venue->name}}', '{{$venue->timetable}}')">Show Timetable</button>
                                            <button type="button" class="btn btn-rounded btn-outline-secondary mb-1" onclick="openTableModal('{{$venue->name}}', '{{$venue->tables}}')">Show Tables</button>
                                            <button type="button" class="btn btn-rounded btn-outline-success mb-1" onclick="openTableModal('{{$venue->name}}', '{{$venue->offers}}')">Show Offers</button>
                                            <button type="button" class="btn btn-rounded btn-outline-warning mb-1" onclick="openMediaModal('{{$venue->name}}', '{{$venue->header_image_path}}', '{{$venue->media}}')">Show Media</button>
                                            <button type="button" class="btn btn-rounded btn-outline-info mb-1" onclick="openDetailModal('{{$venue}}')">Show More</button>
                                        </td>
                                        <td>
                                            @if($venue->status == 'Rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                            @elseif($venue->status === 'Pending')
                                            <span class="badge badge-warning">Pending</span>
                                            @else
                                            <span class="badge badge-success">{{$venue->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-rounded btn-primary mb-1"><a href="{{ route('admin.venues.edit', $venue->id) }}"><i class="fa fa-edit"></i></a></button>
                                            <button title="Approve" class="btn btn-rounded btn-success mb-1" onclick="openApproveModal('{{$venue->id}}')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button title="Reject" class="btn btn-rounded btn-danger mb-1" onclick="openRejectModal('{{$venue->id}}')">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                            @if($venue->feature !== "yes")
                                            <button type="button" title="As Feature" class="btn btn-rounded btn-outline-info mb-1">
                                                <a href="{{ route('admin.venues.feature', $venue->id) }}"><i class="fa fa-bitcoin"></i></a>
                                            </button>
                                            @else
                                            <button type="button" title="Cancel Feature" class="btn btn-rounded btn-info mb-1">
                                                <a href="{{ route('admin.venues.unfeature', $venue->id) }}"><i class="fa fa-bitcoin"></i></a>
                                            </button>
                                            @endif
                                            @if($breadcrumb == 'Featured')
                                            <button type="button" title="Upload Image" class="btn btn-rounded btn-warning mb-1">
                                                <a href="{{ route('admin.venues.upload', $venue->id) }}"><i class="mdi mdi-image-multiple"></i>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                            <div style="display: flex; justify-content: end; margin-right: 40px;">
                                {{ $venues->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Venue Modal -->
<div class="modal fade" id="modal_delete_v2">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Venue</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to delete this venue?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<!-- Time Table Modal -->
<div class="modal fade" id="modal_time_table">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$TITLE Timetable</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-responsive-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Open</th>
                                <th>Close</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-none">
                                <td>$DAY</td>
                                <td>$DAY_OPEN</td>
                                <td>$DAY_CLOSE</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Venue Media Modal -->
<div class="modal fade" id="modal_venue_media_v2">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="carouselControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="../../$HEADERIMAGE" alt="Header Image">
                            <div class="carousel-caption d-none d-md-block"><h5>Header Image</h5></div>
                        </div>
                        <div class="carousel-item image d-none">
                            <img class="d-block w-100" src="../../$PATH" alt="Gallery Image">
                            <div class="carousel-caption d-none d-md-block"><h5>Gallery Image</h5></div>
                        </div>
                        <div class="carousel-item video d-none">
                            <video controls autoplay>
                                <source src="$PATH" type="video/mp4">
                            </video>
                            <div class="carousel-caption d-none d-md-block"><h5>Video</h5></div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Venue Table Modal -->
<div class="modal fade" id="modal_venue_table">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$TITLE Venue</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-responsive-am">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Approval</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-none">
                                <td>$Type</td>
                                <td>$Description</td>
                                <td>$Quantity</td>
                                <td>$Price</td>
                                <td>$Approval</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Venue Detail Modal -->
<div class="modal fade" id="modal_venue_detail">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$TITLE Details</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h5>Description:</h5>
                        <span>$Description<span>
                    </li>
                    <li class="list-group-item">
                        <h5>Facilities:</h5>
                        <span>$Facilities<span>
                    </li>
                    <li class="list-group-item">
                        <h5>Music Policy:</h5>
                        <span>$Music_Policy<span>
                    </li>
                    <li class="list-group-item">
                        <h5>Dress code:</h5>
                        <span>$Dress_code<span>
                    </li>
                    <li class="list-group-item">
                        <h5>Perks:</h5>
                        <span>$Perks<span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="modal_approve_v2">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Venue</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to approve this venue?</div>
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
                <h5 class="modal-title">Reject Venue</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to reject this venue?</div>
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
        const openApproveModal = (venue_id) => {
            let url = "{{ route('admin.venues.approve', 0) }}";
            url = url.substr(0, url.length-1) + venue_id;
            let html = $("#modal_approve_v2").html().replace('$URL', url);
            $("#modal_approve_v2").html(html);
            $("#modal_approve_v2").modal('show');
        }
        
        const openRejectModal = (venue_id) => {
            let url = "{{ route('admin.venues.reject', 0) }}";
            url = url.substr(0, url.length-1) + venue_id;
            let html = $("#modal_reject_v2").html().replace('$URL', url);
            $("#modal_reject_v2").html(html);
            $("#modal_reject_v2").modal('show');
        }

        const openDeleteModal = (venue, venue_id) => {
            let url = "{{ route('vendors.venue.destroy', 0) }}";
            url = url.substr(0, url.length-1) + venue_id;

            let html = $("#modal_delete_v2").html().replace('$URL', url);
            $("#modal_delete_v2").html(html);

            $("#modal_delete_v2").modal('show');
        }

        const openTimetableModal = (venue, timetable) => {
            timetable = JSON.parse(timetable);
            const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

            const tbody = $('#modal_time_table tbody');
            const sample = tbody.children('.d-none');
            tbody.find('.display').remove();

            days.forEach(day => {
                const clone = sample.clone().removeClass('d-none').addClass('display');
                let html = clone.html();
                html = html.replace('$DAY', day)
                html = html.replace('$DAY_OPEN', timetable[day + '_open'])
                html = html.replace('$DAY_CLOSE', timetable[day + '_close'])
                tbody.append(clone.html(html));
            });

            const modal = $('#modal_time_table').html().replace('$TITLE', venue);
            $('#modal_time_table').html(modal);
            $('#modal_time_table').modal('show');
        }

        function openMediaModal(venue, headerImage, images) {
            images = JSON.parse(images);
            
            $(".display-media").remove();
            const media = $("#modal_venue_media_v2").clone().addClass("display-media");
            const list = media.find('.carousel-inner');
            const html = list.html().replace('$HEADERIMAGE', headerImage);
            list.html(html);
            const videosample = media.find('.video');
            const imagesample = media.find('.image');

            images.forEach(image => {
                if(image.type === 'image')
                {
                    const clone = imagesample.clone().removeClass('hidden').addClass('display');
                    let html = clone.html();
                    html = html.replace('$PATH', image.path);
                    list.append(clone.html(html)); 
                }
                if(image.type === 'video' || image.type === 'link')
                {
                    const clone = videosample.clone().removeClass('hidden').addClass('display');
                    let html = clone.html();
                    html = html.replace('$PATH', image.path);
                    list.append(clone.html(html));
                }
            });
            media.find('.d-none').remove();
            media.find('.carousel').carousel();
            $("body").append(media);
            media.modal('show');
        }

        const openTableModal = (venue, tables) => {
            tables = JSON.parse(tables);
            
            const tbody = $("#modal_venue_table tbody");
            const sample = tbody.children('.d-none');
            tbody.find('.display').remove();

            tables.forEach(table => {
                const clone = sample.clone().removeClass('d-none').addClass('display');
                let html = clone.html();
                html = html.replace('$Type', table.type)
                html = html.replace('$Description', table.description || '')
                html = html.replace('$Quantity', table.qty)
                html = html.replace('$Price', table.price)
                html = html.replace('$Approval', table.approval)
                tbody.append(clone.html(html));
            });

            const modal = $('#modal_venue_table').html().replace('$TITLE', venue);
            $('#modal_venue_table').html(modal);
            $('#modal_venue_table').modal('show');
        }

        const openDetailModal = (venue) => {
            venue = JSON.parse(venue);
            let html = $("#modal_venue_detail").html();
            html = html.replace('$Description', venue.description || '');
            html = html.replace('$Facilities', venue.facilities || '');
            html = html.replace('$Music_Policy', venue.music_policy || '');
            html = html.replace('$Dress_code', venue.dress_code || '');
            html = html.replace('$Perks', venue.perks || '');
            $("#modal_venue_detail").html(html);
            $("#modal_venue_detail").modal('show');
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