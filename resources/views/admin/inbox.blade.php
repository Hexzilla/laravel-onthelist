@extends('layouts.admin')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Inbox</a></li>
                </ol>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <div class="card">
                    <div class="card-body">
                        <div role="toolbar" class="toolbar ml-4 ml-sm-0">
                            <div class="btn-group mb-4">
                                <span class="btn btn-dark ml-3">
                                    <input type="checkbox" />
                                </span>
                                <button class="btn btn-dark" type="button">
                                    <i class="ti-reload"></i>
                                </button>
                            </div>
                            <div class="btn-group mb-4">
                                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-dark dropdown-toggle" type="button">
                                    More
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="javascript:void(0)" class="dropdown-item">Mark as Unread</a>
                                </div>
                            </div>
                        </div>
                        <div class="email-list mt-4">
                            @foreach($messages as $message)
                            <div class="message">
                                <div>
                                    <div class="d-flex message-single">
                                        <div class="custom-control custom-checkbox pl-4">
                                            <input type="checkbox"></input>
                                        </div>
                                        <div class="ml-2">
                                            <button class="border-0 bg-transparent align-middle p-0">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <a href="javascript:void()" class="col-mail col-mail-2">
                                        <div class="subject"></div>
                                        <div class="date"></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div style="display: flex; justify-content: end; margin-right: 40px;">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection