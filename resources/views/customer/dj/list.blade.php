@extends('layouts.customer')

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
                                            @if($dj->favourite)
                                                <a href="{{ route('customers.djs.unfavorite', $dj->id) }}" class="text-warning"><i class="fa fa-star" style="font-size: 24px"></i></a>
                                            @else
                                                <a href="{{ route('customers.djs.favorite', $dj->id) }}"><i class="fa fa-star" style="font-size: 24px"></i></a>
                                            @endif
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

<!-- Dj Media Modal -->
<div class="modal fade" id="modal_dj_media_v2">
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
        const titleCase = (str) => {
            str = str.toLowerCase().split(' ');
            for (var i = 0; i < str.length; i++) {
                str[i] = str[i].charAt(0).toUpperCase() + str[i].slice(1); 
            }
            return str.join(' ');
        }

        const openMediaModal = (dj, headerImage, images) => {
            images = JSON.parse(images);
            
            $(".display-media").remove();
            const media = $('#modal_dj_media_v2').clone().addClass("display-media")
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