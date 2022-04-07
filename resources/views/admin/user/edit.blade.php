@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Edit User</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 col-xxl-12">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="EventForm" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-3">User Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="UserName">User Name *</label>
                                <input type="text" class="form-control" id="UserName" name="name" value="{{ $user->name }}" />
                            </div>
                            <div class="form-group">
                            <label for="UserEmail">User Email *</label>
                                <input type="email" class="form-control" id="UserEmail" name="email" value="{{ $user->email }}" />
                            </div>
                            <div class="form-group">
                                <label for="UserRole">User Role *</label>
                                <select class="form-control" id="UserRole" name="role" value="{{ $user->role }}">
                                    <option disabled>Select User Role</option>
                                    <option value="dj">Dj</option>
                                    <option value="vendor">Vendor</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Update an User <i class="mdi mdi-chevron-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
          $("#header-image-uploader").on('click', function(){
                $("#header-image").click();
            });
            $("#header-image").on('change', function(){
                $("#header-image-file-name").text($(this)[0].files[0].name);
            });
        })
    </script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
@endsection