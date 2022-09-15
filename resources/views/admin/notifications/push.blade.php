@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Notification</a></li>
                </ol>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <form method="POST" action="{{ route('admin.notifications.push') }}" class="EventForm needs-validation" encrypt="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Subject</label>
                                <input type="text" class="form-control" id="name" name="name"/>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" rows="6" id="message" name="message"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="link">Link</label>
                                <select class="form-control" name="link">
                                    <option>Select Link</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event }}">Event: {{ $event->name }}</option>
                                    @endforeach
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue }}">Venue: {{ $venue->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Gender">Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="Both">Both</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="age">Age</label>
                                <select class="form-control multi-select" id="age" name="age[]" multiple required>
                                    <option value="1">18-24</option>
                                    <option value="2">25-30</option>
                                    <option value="3">30+</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Location/City</label>
                                <select class="form-control" id="city" name="city">
                                    <option>All</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->name }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="radius">Radius</label>
                                <input class="form-control" type="number" name="radius" id="radius" min="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-6">
                            <button id="submit-button" type="submit" class="btn btn-primary">Push Notification<i class="mdi mdi-chevron-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.multi-select').select2();
    });
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap&libraries=places&v=weekly" 
    async
></script>
@endsection