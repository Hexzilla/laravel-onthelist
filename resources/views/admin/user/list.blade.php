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
                                        <th>Age</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->userProfile ? $user->userProfile->age : ''}}
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->userProfile ? $user->userProfile->phone : ''}}</td>
                                        <td>
                                            @if($user->status == 'Rejected')
                                            <span class="badge badge-danger">Blocked</span>
                                            @else
                                            <span class="badge badge-success">Normal</span>
                                            @endif
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            @if($user->status == 'Rejected')
                                                <button title="Hold" class="btn btn-rounded btn-success mb-1" onclick="openHoldModal('{{$user->id}}')"><i class="fa fa-play"></i></button>
                                            @else
                                                <button title="Pause" class="btn btn-rounded btn-danger mb-1" onclick="openBlockModal('{{$user->id}}')"><i class="fa fa-remove"></i></button>
                                            @endif
                                            <button title="Delete" class="btn btn-rounded btn-danger mb-1" onclick="openRemoveModal('{{$user->id}}')"><i class="fa fa-trash"></i></button>
                                            <!-- @if($role === 'dj')
                                            <button type="button" class="btn btn-rounded btn-success mb-1"><a href="{{ route('admin.users.show', $user->id) }}"><i class="fa fa-visibility"></i> Show Event</a></button>
                                            @endif -->
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
<!-- Approve Modal -->
<div class="modal fade" id="modal_approve_v2">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hold User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to hold this user?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="modal_reject_v2">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pause User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to pause this user?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">
                    <a href="$URL">Yes</a>
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Remove Modal -->
<div class="modal fade" id="modal_remove_v2">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remove User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black">Are you sure you want to remove this user?</div>
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
         const openHoldModal = (user_id) => {
            let url = "{{ route('admin.users.approve', 0) }}";
            url = url.substr(0, url.length-1) + user_id;
            let html = $("#modal_approve_v2").html().replace('$URL', url);
            $("#modal_approve_v2").html(html);
            $("#modal_approve_v2").modal('show');
        }

        const openBlockModal = (user_id) => {
            let url = "{{ route('admin.users.reject', 0) }}";
            url = url.substr(0, url.length-1) + user_id;
            let html = $("#modal_reject_v2").html().replace('$URL', url);
            $("#modal_reject_v2").html(html);
            $("#modal_reject_v2").modal('show');
        }

        const openRemoveModal = (user_id) => {
            let url = "{{ route('admin.users.destroy', 0) }}";
            url = url.substr(0, url.length-1) + user_id;
            let html = $("#modal_remove_v2").html().replace('$URL', url);
            $("#modal_remove_v2").html(html);
            $("#modal_remove_v2").modal('show');
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