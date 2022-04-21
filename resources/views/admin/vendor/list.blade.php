@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{ ucfirst($role) }}s</a></li>
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
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Contact Number</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>{{$user->vendor ? $user->vendor->phone : ''}}</td>
                                        <td>
                                            @if(isset($user->paused_at))
                                            <span class="badge badge-warning">Paused</span>
                                            @else
                                            <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            <button type="button" class="btn btn-rounded btn-primary">
                                                <a href="{{ route('admin.vendors.edit', $user->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                            </button>
                                            @if (isset($user->paused_at))
                                            <button type="button" class="btn btn-rounded btn-success">
                                                <a onclick="openResumeModal('{{$user->name}}', '{{$user->id}}')" title="Resume"><i class="fa fa-play"></i></a>
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-rounded btn-warning">
                                                <a onclick="openPauseModal('{{$user->name}}', '{{$user->id}}')" title="Pause"><i class="fa fa-pause"></i></a>
                                            </button>
                                            @endif
                                            <button type="button" class="btn btn-rounded btn-danger">
                                                <a onclick="openDeleteModal('{{$user->name}}', '{{$user->id}}')" title="Delete"><i class="fa fa-trash"></i></a>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                            <div style="display: flex; justify-content: end; margin-right: 40px;">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pause Vendor Modal -->
<div class="modal fade" id="modal_pause">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pause Vendor</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to pause this vendor?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Resume Vendor Modal -->
<div class="modal fade" id="modal_resume">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resume Vendor</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to resume this vendor?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Vendor Modal -->
<div class="modal fade" id="modal_delete">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Vendor</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to delete this vendor?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openPauseModal(venue, venue_id) {
        let url = "{{ route('admin.vendors.pause', 0) }}";
        url = url.substr(0, url.length-1) + venue_id;
        
        const modal = $("#modal_pause").clone();
        let html = modal.html().replace('$URL', url);
        $(modal).html(html);
        $(modal).modal('show');
    }

    function openResumeModal(venue, venue_id) {
        let url = "{{ route('admin.vendors.resume', 0) }}";
        url = url.substr(0, url.length-1) + venue_id;
        
        const modal = $("#modal_resume").clone();
        let html = modal.html().replace('$URL', url);
        $(modal).html(html);
        $(modal).modal('show');
    }

    function openDeleteModal(venue, venue_id) {
        let url = "{{ route('admin.vendors.destroy', 0) }}";
        url = url.substr(0, url.length-1) + venue_id;
        
        const modal = $("#modal_delete").clone();
        let html = modal.html().replace('$URL', url);
        $(modal).html(html);
        $(modal).modal('show');
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