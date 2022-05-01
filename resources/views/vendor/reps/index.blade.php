@extends('layouts.vendor')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Reps</a></li>
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
                                        <th>No</th>
                                        <th>Event Name</th>
                                        <th>Affiliate Name</th>
                                        <th>Referral Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reps as $rep)
                                    <tr>
                                        <td>{{$rep->id}}</td>
                                        <td>{{$rep->EventName}}</td>
                                        <td>{{$rep->affiliate_code}}</td>
                                        <td>{{$rep->referral_fee}}% of the ticket sales</td>
                                    </tr>
                                    @endforeach
                            </table>
                            <div style="display: flex; justify-content: end; margin-right: 40px;">
                                {{ $reps->links() }}
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