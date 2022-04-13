<div class="col-md-6 col-sm-6 col-lg-6 col-xl-4 col-xxl-6">
    <div class="card event-card">
        <div class="event-card-img">
            <img class="img-fluid" src="../{{ $event->header_image_path }}" data-toggle="modal" data-target="#event-view" height >
            <h4>{{ $event->name }}</h4>
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</a>
            <div class="dropdown-menu dropdown-menu-right">
                <div>
                    <a href="{{ route('vendors.event.edit', $event->id) }}"><i class="fa fa-edit"></i> Edit</a>
                </div>
                <div>
                    @if(!$event->isApproved())
                    <a onclick="openDeleteModal('{{$event->name}}', '{{$event->id}}')"><i class="fa fa-trash"></i> Delete</a>
                    @endif
                </div>
                <div>
                    <a onclick="openViewModal('{{$event}}', '{{$event->tables}}', '{{$event->tickets}}', '{{$event->guestlists}}', '{{$event->media}}' )"><i class="fa fa-visibility"></i> View</a> 
                </div>
            </div>
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
                        @foreach($event->bookings as $booking)
                            <a href="#">
                                <img class="img-fluid" src="">
                            </a>
                        @endforeach
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