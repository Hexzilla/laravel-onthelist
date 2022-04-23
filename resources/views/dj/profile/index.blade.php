@extends('layouts.dj')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dj Profile</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Profile</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body EventForm">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h4 class="main-title mb-3">Profile Information</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="FullName">Full Name *</label>
                                    <input type="text" class="form-control" id="FullName" name="name" value="{{ $user->name }}" readonly/>
                                </div>
                                <div class="form-group">
                                    <label for="Email">Email *</label>
                                    <input type="email" class="form-control" id="Email" name="email" value="{{ $user->email }}"  readonly/>
                                </div>
                            </div>
                        </div>	
                        <div class="row no-input-border">
                            <div class="col-md-12">
                                <div class="form-group border-input">
                                    <label for="Genres">Genres *</label>
                                    @if(count($user->profile) > 0)
                                    <input type="text" class="form-control" placeholder="" id="Genres" name="genres" value="{{ $user->profile[0]->genres }}" readonly>
                                    @else
                                    <input type="text" class="form-control" placeholder="" id="Genres" name="genres" value="{{ '' }}" readonly>
                                    @endif
                                </div>
                                <div class="form-group border-input">
                                    <label for="Age">Age *</label>
                                    @if(count($user->profile) > 0)
                                    <input type="number" class="form-control" placeholder="" id="Age" name="age" value="{{ $user->profile[0]->age }}" readonly>
                                    @else
                                    <input type="number" class="form-control" placeholder="" id="Genres" name="genres" value="{{ '' }}" readonly>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-12">
                                <h4 class="main-title mb-3">Media Information</h4>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($user->dj->media)
                                        @foreach($user->dj->media as $media)
                                        <tr>
                                            <td>{{$media->id}}</td>
                                            <td>{{$media->type}}</td>
                                            <td>
                                                <button type="button" class="btn btn-rounded btn-outline-warning mb-1" onclick="openMediaModal('{{$user->name}}', '{{$media}}')">Show Media</button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-rounded btn-danger mb-1"><a href="{{ route('dj.profile.deletemedia', $media->id) }}"><i class="fa fa-trash"></i> Delete</a></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        const openMediaModal = (venue, image) => {
            image = JSON.parse(image);
            $("#modal_venue_media").modal('show');
            $("#modal_venue_media .modal-title").text(`"${venue}" Gallery`);
            var content = '<div id="carouselControls" class="carousel slide" data-ride="carousel">';
                content += '<div class="carousel-inner">';
                        content += '<div class="carousel-item active">';
                        if(image.type === 'image'){
                            content += '<img class="d-block w-100" src="../' + image.path + '" alt="Gallery Image">';
                            content += '<div class="carousel-caption d-none d-md-block"><h5>Gallery Image</h5></div>';
                        }
                        if(image.type === 'video' || image.type === 'link'){
                            content += '<video controls autoplay>';
                                content += '<source src="../' + image.path + '" type="video/mp4">';
                            content += '</video>';
                            content += '<div class="carousel-caption d-none d-md-block"><h5>Video</h5></div>';
                        }                        
                        content += '</div>';
                content += '</div>';
                content += `
                <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                `;
            content += '</div>';
            $("#modal_venue_media .modal-body").html(content);
            $('.carousel').carousel();
        }
    </script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
@endsection