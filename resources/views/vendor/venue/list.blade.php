@extends('layouts.vendor')

@section('styles')
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
@endsection

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
            @foreach($venues as $venue)
                @include('vendor.venue.card', ['venue' => $venue])
            @endforeach            
        </div>
    </div>
</div>
<!-- Venue Table Modal -->
<div class="modal fade" id="modal_venue_table">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$TITLE - Table Bookings</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-responsive-am">
                        <thead>
                            <tr>
                                <th>Booking Name</th>
                                <th>Offer Type</th>
                                <th>Purchase Date</th>
                                <th>Price Paid</th>
                                <th>Order No</th>
                                <th>Scanned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-none">
                                <td>$name</td>
                                <td>$type</td>
                                <td>$date</td>
                                <td>$price</td>
                                <td>$no</td>
                                <td>$id</td>
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
<!-- Venue Offer Modal -->
<div class="modal fade" id="modal_venue_offer">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$TITLE - Table Bookings</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-responsive-am">
                        <thead>
                            <tr>
                                <th>Booking Name</th>
                                <th>Table Type</th>
                                <th>Booking Time</th>
                                <th>Deposit Paid</th>
                                <th>Booking No</th>
                                <th>Scanned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-none">
                                <td>$name</td>
                                <td>$type</td>
                                <td>$time</td>
                                <td>$price</td>
                                <td>$no</td>
                                <td>$id</td>
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
                <h5 class="modal-title">$TITLE Opening Time</h5>
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
                            <img class="d-block w-100" src="../$HEADERIMAGE" alt="Header Image">
                            <div class="carousel-caption d-none d-md-block"><h5>Header Image</h5></div>
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
                    <div class="carousel-item image d-none">
                        <img class="d-block w-100" src="../$PATH" alt="Gallery Image">
                        <div class="carousel-caption d-none d-md-block"><h5>Gallery Image</h5></div>
                    </div>
                    <div class="carousel-item video d-none">
                        <video controls autoplay>
                            <source src="$PATH" type="video/mp4">
                        </video>
                        <div class="carousel-caption d-none d-md-block"><h5>Video</h5></div>
                    </div>
                </div>
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
@endsection

@section('scripts')
<script>
    function openDeleteModal(venue, venue_id) {
        let url = "{{ route('vendors.venue.destroy', 0) }}";
        url = url.substr(0, url.length-1) + venue_id;

        let html = $("#modal_delete_v2").html().replace('$URL', url);
        $("#modal_delete_v2").html(html);

        $("#modal_delete_v2").modal('show');
    }

    function titleCase(str) {
        str = str.toLowerCase().split(' ');
        for (var i = 0; i < str.length; i++) {
            str[i] = str[i].charAt(0).toUpperCase() + str[i].slice(1); 
        }
        return str.join(' ');
    }

    function openTimetableModal(venue, timetable) {
        timetable = JSON.parse(timetable);
        const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        const tbody = $('#modal_time_table tbody');
        const sample = tbody.children('.d-none');
        tbody.find('.display').remove();

        days.forEach(day => {
            const clone = sample.clone().removeClass('d-none').addClass('display');
            let html = clone.html();
            html = html.replace('$DAY', titleCase(day))
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

    function openTableModal(venue, venue_id){
        $.ajax({
            url: '/api/venue/table/' + venue_id,
            type: "GET",
            dataType: 'json',
            success: function(dataResult){
                var tables = dataResult.data;
                $(".display-modal").remove();
                const body = $("#modal_venue_table").clone().addClass("display-modal");
                const tbody = body.find("tbody");
                const sample = tbody.children('.d-none');

                $.each(tables, function(index, row){
                    const clone = sample.clone().removeClass('d-none').addClass('display');
                    let html = clone.html();
                    html = html.replace('$name', row.userName)
                    html = html.replace('$type', row.type)
                    html = html.replace('$time', row.time || '')
                    html = html.replace('$price', row.price)
                    html = html.replace('$no', row.id)
                    tbody.append(clone.html(html));
                })
                const modal = body.html().replace('$TITLE', venue);
                $("body").append(body.html(modal));
                body.modal('show');
            }
        });
    }

    function openOfferModal(venue, venue_id){
        $.ajax({
            url: '/api/venue/offer/' + venue_id,
            type: "GET",
            dataType: 'json',
            success: function(dataResult){
                var offers = dataResult.data;
                $(".display-modal").remove();
                const body = $("#modal_venue_offer").clone().addClass("display-modal");
                const tbody = body.find("tbody");
                const sample = tbody.children('.d-none');

                $.each(offers, function(index, row){
                    const clone = sample.clone().removeClass('d-none').addClass('display');
                    let html = clone.html();
                    html = html.replace('$name', row.userName)
                    html = html.replace('$type', row.type)
                    html = html.replace('$date', row.date)
                    html = html.replace('$price', row.price)
                    html = html.replace('$no', row.id)
                    tbody.append(clone.html(html));
                })
                const modal = body.html().replace('$TITLE', venue);
                $("body").append(body.html(modal));
                body.modal('show');
            }
        });
    }

    /*function openTableModal(venue, venue_id){
        $.ajax({
            url: '/api/venue/table/' + venue_id,
            type: "POST",
            dataType: 'json',
            success: function(dataResult){
                var tables = dataResult.data;
                $(".display-modal").remove();
                const body = $("#modal_venue_table").clone().addClass("display-modal");
                const tbody = body.find("tbody");
                const sample = tbody.children('.d-none');

                $.each(tables, function(index, row){
                    const clone = sample.clone().removeClass('d-none').addClass('display');
                    let html = clone.html();
                    html = html.replace('$name', row.userName)
                    html = html.replace('$type', row.type)
                    html = html.replace('$qty', row.qty || '')
                    html = html.replace('$price', row.price)
                    html = html.replace('$no', row.id)
                    tbody.append(clone.html(html));
                })
                const modal = body.html().replace('$TITLE', venue);
                $("body").append(body.html(modal));
                body.modal('show');
            }
        });
    }*/

    function openDetailModal(venue) {
        venue = JSON.parse(venue);

        $(".display-modal").remove();
        const detail = $("#modal_venue_detail").clone().addClass("display-modal");
        let html = detail.html();
        html = html.replace('$TITLE', venue.name);
        html = html.replace('$Description', venue.description || '');
        html = html.replace('$Facilities', venue.facilities || '');
        html = html.replace('$Music_Policy', venue.music_policy || '');
        html = html.replace('$Dress_code', venue.dress_code || '');
        html = html.replace('$Perks', venue.perks || '');
        $("body").append(detail.html(html));
        detail.modal('show');
    }
</script>
<script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
@endsection