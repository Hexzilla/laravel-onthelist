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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Djs</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mr-4">
                            <button type="button" class="btn btn-primary add-dj-button"><a href="{{ route('vendors.dj.create') }}">Add Dj</a></button>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Genre</th>
                                        <th>Mixcloud link</th>
                                        <th>Details</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($djs as $dj)
                                    <tr>
                                        <td>{{$dj->user->name}}</td>
                                        <td>{{$dj->genre}}</td>
                                        <td><a href="{{$dj->mixcloud_link}}">{{$dj->mixcloud_link}}</a></td>
                                        <td>
                                            <button class="btn btn-rounded btn-success mb-1" onclick="openMediaModal('{{$dj->name}}', '{{$dj->header_image_path}}', '{{$dj->media}}')">Show Media</button>
                                            <button class="btn btn-rounded btn-warning mb-1" onclick="openDetailModal('{{$dj}}')">Show Detail</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-rounded btn-primary">
                                                <a href="{{ route('vendors.dj.edit', $dj->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                            </button>
                                            <button type="button" class="btn btn-rounded btn-danger">
                                                <a onclick="openDeleteModal('{{$dj->name}}', '{{$dj->id}}')" title="Delete"><i class="fa fa-trash"></i></a>
                                            </button>
                                        <td>

                                            <!-- <button class="btn btn-rounded btn-success mb-1" title="Approve" onclick="openApproveModal('{{$dj->id}}')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="btn btn-rounded btn-danger mb-1" title="Reject" onclick="openRejectModal('{{$dj->id}}')">
                                                <i class="fa fa-remove"></i>
                                            </button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                            <div style="display: flex; justify-content: end; margin-right: 40px;">
                                {{ $djs->links() }}
                            </div>
                        </div>
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
<!-- Delete Dj Modal -->
<div class="modal fade" id="modal_delete_v2">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Dj</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to delete this Dj?</div>
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

<!-- Dj Detail Modal -->
<div class="modal fade" id="modal_dj_detail">
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
                    <!-- <li class="list-group-item">
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
                    </li> -->
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
        const openDeleteModal = (venue, venue_id) => {
            let url = "{{ route('vendors.dj.destroy', 0) }}";
            url = url.substr(0, url.length-1) + venue_id;

            let html = $("#modal_delete_v2").html().replace('$URL', url);
            $("#modal_delete_v2").html(html);

            $("#modal_delete_v2").modal('show');
        }

        const titleCase = (str) => {
            str = str.toLowerCase().split(' ');
            for (var i = 0; i < str.length; i++) {
                str[i] = str[i].charAt(0).toUpperCase() + str[i].slice(1); 
            }
            return str.join(' ');
        }

        const openMediaModal = (venue, headerImage, images) => {
            images = JSON.parse(images);
            
            $(".display-media").remove();
            const media = $('#modal_venue_media_v2').clone().addClass("display-media")
            const list = media.find('.carousel-inner');
            const html = list.html().replace('$HEADERIMAGE', headerImage);
            list.html(html);
            const videosample = media.find(".video");
            const imagesample = media.find(".image");

            images.forEach(image => {
                if(image.type === 'image')
                {
                    const clone = imagesample.clone().removeClass('d-none').addClass('display');
                    let html = clone.html();
                    html = html.replace('$PATH', image.path);
                    list.append(clone.html(html)); 
                }
                if(image.type === 'video' || image.type === 'link')
                {
                    const clone = videosample.clone().removeClass('d-none').addClass('display');
                    let html = clone.html();
                    html = html.replace('$PATH', image.path);
                    list.append(clone.html(html));
                }
            });
            media.find('.carousel').carousel();
            $("body").append(media);
            media.modal('show');
        }

        const openDetailModal = (dj) => {
            dj = JSON.parse(dj);

            $(".display-modal").remove();
            const description = $("#modal_dj_detail").clone().addClass("display-modal");
            let html = description.html();
            html = html.replace('$TITLE', dj.name);
            html = html.replace('$Description', dj.description || '');
            // html = html.replace('$Facilities', dj.facilities || '');
            // html = html.replace('$Music_Policy', dj.music_policy || '');
            // html = html.replace('$Dress_code', vendjue.dress_code || '');
            // html = html.replace('$Perks', dj.perks || '');
            $("body").append(description.html(html));
            description.modal('show');
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