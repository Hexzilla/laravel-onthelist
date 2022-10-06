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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Events</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            @foreach($events as $event)
                @include('vendor.event.card', ['event' => $event])
            @endforeach
        </div>
    </div>
</div>

<!-- Event Delete Modal -->
<div class="modal fade" id="event_delete_modal">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Event</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to delete this event?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Event Ticket Modal -->
<div class="modal fade" id="modal_event_ticket">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$TITLE Event - Ticket Bookings</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-responsive-am">
                        <thead>
                            <tr>
                                <th>Booking Name</th>
                                <th>Ticket Type</th>
                                <th>Quantity</th>
                                <th>Ticket Price</th>
                                <th>Booking No</th>
                                <th>Scanned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-none">
                                <td>$name</td>
                                <td>$type</td>
                                <td>$qty</td>
                                <td>$price</td>
                                <td>$no</td>
                                <td><input type="checkbox" class="checkbox-booking" disabled></td>
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

<!-- Event Table Modal -->
<div class="modal fade" id="modal_event_table">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$TITLE Event - Table Bookings</h5>
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
                                <th>Quantity</th>
                                <th>Deposit Paid</th>
                                <th>Booking No</th>
                                <th>Scanned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-none">
                                <td>$name</td>
                                <td>$type</td>
                                <td>$qty</td>
                                <td>$price</td>
                                <td>$no</td>
                                <td><input type="checkbox" class="checkbox-booking" disabled></td>
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

<!-- Event Guestlist Modal -->
<div class="modal fade" id="modal_event_guestlist">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$TITLE Event - Guestlist Bookings</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-responsive-am">
                        <thead>
                            <tr>
                                <th>Booking Name</th>
                                <th>Guestlist Type</th>
                                <th>Quantity</th>
                                <th>Pay at Door Price</th>
                                <th>Booking No</th>
                                <th>Scanned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="d-none">
                                <td>$name</td>
                                <td>$type</td>
                                <td>$qty</td>
                                <td>$price</td>
                                <td>$no</td>
                                <td><input type="checkbox" class="checkbox-booking" disabled></td>
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

<!-- Event Media Modal -->
<div class="modal fade" id="modal_event_media">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="carouselControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="../$HEADERIMAGE" alt="Header Image">
                            <div class="carousel-caption d-none d-md-block"><h5>Header Image</h5></div>
                        </div>
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

<!-- Event Detail Modal -->
<div class="modal fade" id="modal_event_detail">
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
                <button type="button" class="btn btn-primary close-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Scan Booking Modal -->
<div class="modal fade" id="modal_scan_booking">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan Booking</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="reader" width="600px"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function openDeleteModal(event, event_id) {
            let url = "{{ route('vendors.event.destroy', 0) }}";
            url = url.substr(0, url.length-1) + event_id;
            let html = $("#event_delete_modal").html().replace("$URL", url);
            $("#event_delete_modal").html(html);
            $("#event_delete_modal").modal('show');
        }

        function openTicketModal(event, event_id){
            $.ajax({
                url: '/api/event/ticket/' + event_id,
                type: "GET",
                dataType: 'json',
                success: function(dataResult){
                    var tickets = dataResult.data;
                    $(".display-modal").remove();
                    const body = $("#modal_event_ticket").clone().addClass("display-modal");
                    const tbody = body.find("tbody");
                    const sample = tbody.children('.d-none');

                    $.each(tickets, function(index, row){
                        const clone = sample.clone().removeClass('d-none').addClass('display');
                        let html = clone.html();
                        html = html.replace('$name', row.userName)
                        html = html.replace('$type', row.type)
                        html = html.replace('$qty', row.qty || '')
                        html = html.replace('$price', row.price)
                        html = html.replace('$no', row.id)
                        const item = clone.html(html);
                        if (row.is_scanned === 1) {
                            const checkbox = item.find("input:checkbox");
                            checkbox.attr('checked', true);
                        }
                        tbody.append(item);
                    })
                    const modal = body.html().replace('$TITLE', event);
                    $("body").append(body.html(modal));
                    body.modal('show');
            }
        });
        }

        function openTableModal(event, event_id){
            $.ajax({
                url: '/api/event/table/' + event_id,
                type: "GET",
                dataType: 'json',
                success: function(dataResult){
                    var tables = dataResult.data;
                    $(".display-modal").remove();
                    const body = $("#modal_event_table").clone().addClass("display-modal");
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
                        const item = clone.html(html);
                        if (row.is_scanned === 1) {
                            const checkbox = item.find("input:checkbox");
                            checkbox.attr('checked', true);
                        }
                        tbody.append(item);
                    })
                    const modal = body.html().replace('$TITLE', event);
                    $("body").append(body.html(modal));
                    body.modal('show');
            }
        });
        }

        function openGuestlistModal(event, event_id){
            $.ajax({
                url: '/api/event/guestlist/' + event_id,
                type: "GET",
                dataType: 'json',
                success: function(dataResult){
                    var guestlists = dataResult.data;
                    $(".display-modal").remove();
                    const body = $("#modal_event_questlist").clone().addClass("display-modal");
                    const tbody = body.find("tbody");
                    const sample = tbody.children('.d-none');

                    $.each(guestlists, function(index, row){
                        const clone = sample.clone().removeClass('d-none').addClass('display');
                        let html = clone.html();
                        html = html.replace('$name', row.userName)
                        html = html.replace('$type', row.type)
                        html = html.replace('$qty', row.qty || '')
                        html = html.replace('$price', row.price)
                        html = html.replace('$no', row.id)
                        const item = clone.html(html);
                        if (row.is_scanned === 1) {
                            const checkbox = item.find("input:checkbox");
                            checkbox.attr('checked', true);
                        }
                        tbody.append(item);
                    })
                    const modal = body.html().replace('$TITLE', event);
                    $("body").append(body.html(modal));
                    body.modal('show');
            }
        });
        }

        function openDetailModal(event) {
            event = JSON.parse(event);
            $(".display-modal").remove();
            const detail = $("#modal_event_detail").clone().addClass("display-modal");
            let html = $("#modal_event_detail").html();
            html = html.replace('$TITLE', event.name);
            html = html.replace('$Description', event.description || '');
            html = html.replace('$Facilities', event.facilities || '');
            html = html.replace('$Music_Policy', event.music_policy || '');
            html = html.replace('$Dress_code', event.dress_code || '');
            html = html.replace('$Perks', event.perks || '');
            $("body").append(detail.html(html));
            detail.modal('show');
        }

        function openMediaModal(venue, headerImage, images) {
            images = JSON.parse(images);
            
            $(".display-modal").remove();
            const media = $("#modal_event_media").clone().addClass("display-modal");
            const list = media.find('.carousel-inner');
            const html = list.html().replace('$HEADERIMAGE', headerImage);
            list.html(html);
            const videosample = list.children('.video');
            const imagesample = list.children('.image');
            list.find('.display').remove();

            images.forEach(image => {
            if (image.type === 'image') {
                const clone = imagesample.clone().removeClass('d-none').addClass('display');
                let html = clone.html();
                html = html.replace('$PATH', image.path);
                list.append(clone.html(html));
            }
            if (image.type === 'video' || image.type === 'link') {
                    const clone = videosample.clone().removeClass('d-none').addClass('display');
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

        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            console.log(`Code matched = ${decodedText}`, decodedResult);
            if (decodedResult) {
                $.ajax({
                    url: '/api/event/scanbooking',
                    type: "POST",
                    dataType: 'json',
                    data: decodedText,
                    success: function(result) {
                        
                    }
                });
            }
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
        }

        window.addEventListener('load', function() {
            $('.scan-booking').click(function(event) {
                event.preventDefault();
                const eventId = $(this).attr("eventId");
                console.log('eventId', eventId);

            const html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: 250
            }, /* verbose= */ false);
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);

                $("#modal_scan_booking").modal('show');
            });
        });

    </script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
@endsection