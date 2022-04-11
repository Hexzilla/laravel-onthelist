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
                                        <th>Role</th>
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
                                        <td>
                                            @if($user->status == 'Rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                            @elseif($user->status === 'Pending')
                                            <span class="badge badge-warning">Pending</span>
                                            @else
                                            <span class="badge badge-success">{{$user->status}}</span>
                                            @endif
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            <button class="btn btn-rounded btn-success mb-1" onclick="openApproveModal('{{$user->id}}')"><i class="fa fa-check"></i></button>
                                            <button class="btn btn-rounded btn-danger mb-1" onclick="openRejectModal('{{$user->id}}')"><i class="fa fa-remove"></i></button>
                                            <!-- @if($role === 'dj')
                                            <button type="button" class="btn btn-rounded btn-success mb-1"><a href="{{ route('admin.users.show', $user->id) }}"><i class="fa fa-visibility"></i> Show Event</a></button>
                                            @endif -->
                                        </td>
                                    </tr>
                                    @endforeach
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
         const openApproveModal = (user_id) => {
            let url = "{{ route('admin.users.approve', 0) }}";
            url = url.substr(0, url.length-1) + user_id;
            $("#modal_delete").modal('show');
            $("#modal_delete .modal-title").text(`Approve User`);
            var content = '<button type="button" class="btn btn-info">';
                content += `<a href="${url}">`;
                content += "Yes</a></button>";
                content += '<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>';
            $("#modal_delete .modal-footer").html(content);
            $("#modal_delete .modal-body").text('Are you sure you want to approve this user?');
        }

        const openRejectModal = (user_id) => {
            let url = "{{ route('admin.users.reject', 0) }}";
            url = url.substr(0, url.length-1) + user_id;
            $("#modal_delete").modal('show');
            $("#modal_delete .modal-title").text(`Reject User`);
            var content = '<button type="button" class="btn btn-info">';
                content += `<a href="${url}">`;
                content += "Yes</a></button>";
                content += '<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>';
            $("#modal_delete .modal-footer").html(content);
            $("#modal_delete .modal-body").text('Are you sure you want to reject this user?');
        }
    </script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
@endsection