@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Payments</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Payment Details</a></li>
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
                                        <th>Venue Name</th>
                                        <th>Name on Account</th>
                                        <th>Sort Code</th>
                                        <th>Acc Number</th>
                                        <th>Bank Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($accounts as $account)
                                    <tr>
                                        <td>{{$account->venuename}}</td>
                                        <td>{{$account->name}}</td>
                                        <td>{{$account->sort_code}}</td>
                                        <td>{{$account->account_number}}</td>
                                        <td>{{$account->bank_name}}</td>
                                    </tr>
                                    @endforeach
                            </table>
                            <div style="display: flex; justify-content: end; margin-right: 40px;">
                                {{ $accounts->links() }}
                            </div>
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
        window.addEventListener('load', (event) => {
            initDataTable('example', {
                info: false,
                paging: false,
            })
        });
    </script>
    <script src="{{ asset('js/datatable.js') }}"></script>
@endsection