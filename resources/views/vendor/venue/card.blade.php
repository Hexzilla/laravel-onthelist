<div class="col-md-6 col-sm-12 col-lg-6 col-xl-4 col-xxl-6">
    <div class="card event-card">
        <div class="event-card-img">
            <img class="img-fluid" src="../{{ $venue->header_image_path }}" data-toggle="modal" data-target="#event-view" height >
            <h4>{{ $venue->name }}</h4>
        </div>
        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</a>
        <div class="dropdown-menu dropdown-menu-right">
            <div><a href="{{ route('vendors.venue.edit', $venue->id) }}"><i class="fa fa-edit"></i> Edit</a></div>
            <div>
                @if(!$venue->isApproved())
                <a onclick="openDeleteModal('{{$venue->name}}', '{{$venue->id}}')"><i class="fa fa-trash"></i> Delete</a>
                @endif
            </div>
            <div><a onclick="openTimetableModal('{{$venue->name}}', '{{$venue->timetable}}')">TimeTables</a></div>
            <div><a onclick="openTableModal('{{$venue->name}}', '{{$venue->tables}}')">Tables</a></div>
            <div><a onclick="openTableModal('{{$venue->name}}', '{{$venue->offers}}')">Offers</a></div>
            <!-- <div><a onclick="openMediaModal('{{$venue->name}}', '{{$venue->header_image_path}}', '{{$venue->media}}')">Media</a></div>
            <div><a onclick="openDetailModal('{{$venue}}')">Detail</a></div> -->
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-auto">
                    <h5>Location</h5>
                    <p>{{ $venue->city }}</p>
                </div>
                <!-- <div class="col-auto">
                    <h5>Tickets</h5>
                    <p>Available 26/100</p>
                </div> -->
            </div>
        </div>
        <div class="card-sponsor">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <h4>Attending</h4>
                    <div class="card-sponsor-img">
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