<div class="col-md-6 col-sm-12 col-lg-6 col-xl-4 col-xxl-6">
    <div class="card event-card">
        <div class="event-card-img">
            <img class="img-fluid h-100 card-header-image" src="../{{ $event->header_image_path }}" data-toggle="modal" data-target="#event-view" height >
            <h4 class="event-title">{{ $event->name }}</h4>
        </div>
        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="mb-1"><a href="{{ route('vendors.event.edit', $event->id) }}"><i class="fa fa-edit"></i> Edit</a></div>
            @if(!$event->isApproved())
                <div class="mb-1">                
                    <a onclick="openDeleteModal('{{$event->name}}', '{{$event->id}}')"><i class="fa fa-trash"></i> Delete</a>
                </div class="mb-1">
            @endif
            <div class="mb-1"><a onclick="openTicketModal('{{$event->name}}', '{{$event->id}}')">Tickets</a></div>
            <div class="mb-1"><a onclick="openTableModal('{{$event->name}}', '{{$event->id}}')">Tables</a></div>
            <!-- <div><a onclick="openMediaModal('{{$event->name}}', '{{$event->header_image_path}}', '{{$event->media}}')">Media</a></div>
            <div><a onclick="openDetailModal('{{$event}}')">Detail</a></div> -->
            <div class="mb-1"><a onclick="openGuestlistModal('{{$event->name}}', '{{$event->id}}')">Guestlists</a></div>
            <div class="mb-1"><a href="{{ route('vendors.event.createRep', $event->id) }}">Add Repo</a></div>
        </div>
        <div class="card-body padding-4">
            <div class="card-body-content">
                <div class="card-body-item">
                    <h5>Date</h5>
                    <p>{{ date('M d, Y', strtotime(explode(' ', $event->start)[0])) }}</p>
                </div>
                <div class="card-body-item">
                    <h5>Location</h5>
                    <p>{{ $event->venue->city }}</p>
                </div>
                <div class="card-body-item">
                    <h5>Tickets</h5>
                    <p>Available 26/100</p>
                </div>
                <div class="card-body-item position-r">
                    <button type="button" class="btn btn-primary scan-booking" eventId="{{$event->id}}">Scan Booking</button>
                </div>
            </div>
        </div>
        <div class="card-sponsor">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <h4>Attending</h4>
                    <div class="card-sponsor-img">
                        <!-- @foreach($event->bookings as $booking)
                            <a href="#">
                                <img class="img-fluid" src="">
                            </a>
                        @endforeach -->
                        <a href="#"><img class="img-fluid" src="../images/user/1621929509477160abadff1a619.png"/></a>
                        <a href="#"><img class="img-fluid" src="../images/user/1622395133656360b26be8d6249.png"/></a>
                        <a href="#"><img class="img-fluid" src="../images/user/1622436388735760b23d94d4018.png"/></a>
                        <a href="#"><img class="img-fluid" src="../images/user/1622441283070160b1a2e818e0a.png"/></a>
                        <a href="#"><img class="img-fluid" src="../images/user/1622455400325160b1f02fc510d.png"/></a>
                    </div>
                </div>
                <div class="col-auto">
                    <p>Free</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i>126</a></li>
                <li><a href="#"><i class="fa fa-comment"></i>O3</a></li>
                <li><a href="#"><i class="fa fa-sign-out"></i></a></li>
            </ul>
            <div class="float-right">
                <a href="#">
                    <i class="fa fa-bar-chart"></i>Insights
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        $('.card-header-image').click(function(event) {
            window.location.href = "{{ route('vendors.dashboard') }}";
        });
    });
</script>
