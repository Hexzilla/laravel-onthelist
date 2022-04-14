<div class="col-md-6 col-sm-12 col-lg-6 col-xl-4 col-xxl-6">
    <div class="card event-card">
        <div class="event-card-img">
            <img class="img-fluid" src="../{{ $event->header_image_path }}" data-toggle="modal" data-target="#event-view" height >
            <h4>{{ $event->name }}</h4>
        </div>
        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</a>
        <div class="dropdown-menu dropdown-menu-right">
            <div><a href="{{ route('vendors.event.edit', $event->id) }}"><i class="fa fa-edit"></i> Edit</a></div>
            <div>
                @if(!$event->isApproved())
                <a onclick="openDeleteModal('{{$event->name}}', '{{$event->id}}')"><i class="fa fa-trash"></i> Delete</a>
                @endif
            </div>
            <div><a onclick="openTableModal('{{$event->name}}', '{{$event->tickets}}')">Tickets</a></div>
            <div><a onclick="openTableModal('{{$event->name}}', '{{$event->tables}}')">Tables</a></div>
            <!-- <div><a onclick="openMediaModal('{{$event->name}}', '{{$event->header_image_path}}', '{{$event->media}}')">Media</a></div>
            <div><a onclick="openDetailModal('{{$event}}')">Detail</a></div> -->
            <div><a onclick="openTableModal('{{$event->name}}', '{{$event->guestlists}}')">Guestlists</a></div>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-auto">
                    <h5>Date</h5>
                    <p>{{ date('M d, Y', strtotime(explode(' ', $event->start)[0])) }}</p>
                </div>
                <div class="col-auto">
                    <h5>Location</h5>
                    <p>{{ $event->venue->city }}</p>
                </div>
                <div class="col-auto">
                    <h5>Tickets</h5>
                    <p>Available 26/100</p>
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