@extends('layouts.customer')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-xxl-6 col-sm-6 col-md-6">
                <div class="row stats-card">
                    <div class="col-6 border-right">
                        <img src="{{ asset("images/admin/event.png") }}" />
                    </div>
                    <div class="col-6">
                        <h2>159</h2>
                        <span>Total Events</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-sm-6 col-md-6">
                <div class="row stats-card">
                    <div class="col-6 border-right">
                        <img src="{{ asset("images/admin/user.png") }}" />
                    </div>
                    <div class="col-6">
                        <h2>2,661</h2>
                        <span>User Registration</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-sm-6 col-md-6">
                <div class="row stats-card">
                    <div class="col-6 border-right">
                        <img src="{{ asset("images/admin/sales.png") }}" />
                    </div>
                    <div class="col-6">
                        <h2>1,092</h2>
                        <span>Total Sales</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-sm-6 col-md-6">
                <div class="row stats-card">
                    <div class="col-6 border-right">
                        <img src="{{ asset("images/admin/earning.png") }}" />
                    </div>
                    <div class="col-6">
                        <h2>£3,590</h2>
                        <span>Total Earnings</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upcoming Events</h4>
                        <i class="mdi mdi-dots-horizontal"></i>
                    </div>
                    <div class="card-body event-goals">
                        <ul>
                            <li>
                                <div class="media">
                                    <div class="user-img mr-4">
                                        <div class="date-card">25<br/>JUN<br/>2018</div>
                                    </div>
                                    <div class="media-body">
                                        <h5>Event name</h5>
                                        <p>support@example.com</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <div class="user-img mr-4">
                                        <div class="date-card">25<br/>JUN<br/>2018</div>
                                    </div>
                                    <div class="media-body">
                                        <h5>Event name</h5>
                                        <p>support@example.com</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <div class="user-img mr-4">
                                        <div class="date-card">25<br/>JUN<br/>2018</div>
                                    </div>
                                    <div class="media-body">
                                        <h5>Event name</h5>
                                        <p>support@example.com</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Event Views</h4>
                        <i class="mdi mdi-dots-horizontal"></i>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <p class="mb-2">Ticket 1</p>
                                <h4 class="text-dark">$5500.00</h4>
                            </div>
                            <div class="col-4">
                                <p class="mb-2">Ticket 2</p>
                                <h4 class="text-dark">$6550.00</h4>
                            </div>
                            <div class="col-4">
                                <p class="mb-2">Ticket 3</p>
                                <h4 class="text-dark">$7540.00</h4>
                            </div>
                            <div class="col-12">
                                <canvas id="event_views_chart" class="chartjs"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-xxl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ticket Sold</h4>
                        <i class="mdi mdi-dots-horizontal"></i>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-xxl-12">
                                <p class="mb-2 font-weight-bold">Event name
                                    <span class="float-right">250 / 100</span>
                                </p>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-primary progress-animated" style="width: 85%; height:15px;" role="progressbar">
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-12 col-xxl-12">
                                <p class="mb-2 font-weight-bold">Event name
                                    <span class="float-right">250 / 100</span>
                                </p>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-primary progress-animated" style="width: 65%; height:15px;" role="progressbar">
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-12 col-xxl-12">
                                <p class="mb-2 font-weight-bold">Event name
                                    <span class="float-right">250 / 90</span>
                                </p>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-primary progress-animated" style="width: 65%; height:15px;" role="progressbar">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-xxl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Calendar</h4>
                        <i class="mdi mdi-dots-horizontal"></i>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-xxl-12">
                <div class="card" data-aos="fade-up">
                    <div class="card-header">
                        <h4 class="card-title">Approval Request</h4>
                        <i class="mdi mdi-dots-horizontal"></i>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-xxl-4">
                                <div class="card single-administrator">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="user-img mr-4">
                                                <span class="activity active"></span>
                                                <img src="images/user/2.png" height="50" width="50" alt="">
                                            </div>
                                            <div class="media-body">
                                                <h5>Lurch Schpellchek</h5>
                                                <p>support@example.com</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4">
                                <div class="card single-administrator">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="user-img mr-4">
                                                <span class="activity active"></span>
                                                <img src="images/user/1.png" height="50" width="50" alt="">
                                            </div>
                                            <div class="media-body">
                                                <h5>Ursula Gurnmeister</h5>
                                                <p>support@example.com</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4">
                                <div class="card single-administrator">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="user-img mr-4">
                                                <span class="activity inactive"></span>
                                                <img src="images/user/8.png" height="50" width="50" alt="">
                                            </div>
                                            <div class="media-body">
                                                <h5>Alan Fresco</h5>
                                                <p>support@example.com</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script>
@endsection