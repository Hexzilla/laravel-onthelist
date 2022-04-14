<div class="col-md-6 col-sm-12 col-lg-6 col-xl-4 col-xxl-6">
    <div class="card event-card">
        <div class="event-card-img">
            <img class="img-fluid h-100" src="../{{ $dj->header_image_path }}" data-toggle="modal" data-target="#event-view" height >
            <h4 class="event-title">{{ $dj->name }}</h4>
        </div>
        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...</a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="mb-1"><a href="{{ route('vendors.dj.edit', $dj->id) }}"><i class="fa fa-edit"></i> Edit</a></div>
            <div>
                <a onclick="openDeleteModal('{{$dj->name}}', '{{$dj->id}}')"><i class="fa fa-trash"></i> Delete</a>
            </div>
            <div class="mb-1"><a onclick="openTimetableModal('{{$dj->name}}', '{{$dj->timetable}}')">TimeTables</a></div>
            <div class="mb-1"><a onclick="openTableModal('{{$dj->name}}', '{{$dj->tables}}')">Tables</a></div>
            <div class="mb-1"><a onclick="openTableModal('{{$dj->name}}', '{{$dj->offers}}')">Offers</a></div>
            <!-- <div class="mb-1"><a onclick="openMediaModal('{{$dj->name}}', '{{$dj->header_image_path}}', '{{$dj->media}}')">Media</a></div>
            <div class="mb-1"><a onclick="openDetailModal('{{$dj}}')">Detail</a></div> -->
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-auto">
                    <h5>Location</h5>
                    <p>{{ $dj->city }}</p>
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