@extends('layouts.customer')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Events</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Booking</a></li>
                </ol>
            </div> 
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">			
                <form method="POST" action="{{ route('customers.events.createBooking') }}" class="EventForm needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-3">Booking Information</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="from-group">
                                <label for="event">Event *</label>
                                <input type="text" class="form-control" id="event" name="event" value="{{$event->name}}">
                                <input type="hidden" id="event_id" name="event_id" value="{{$event->id}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="from-group">
                                <label for="event">Booking Type *</label>
                                <select class="form-control" id="booking_type" name="booking_type">
                                    <option disabled selected>Select Booking Type</option>
                                    <option value="Ticket">Ticket</option>
                                    <option value="Table Booking">Table Booking</option>
                                    <option value="Guestlist">Guestlist</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type">Type *</label>
                                <select class="form-control d-none display-booking" id="tickets" name="type">
                                    @foreach($event->tickets as $ticket)
                                        <option value="{{$ticket->type}}" data-price="{{$ticket->price}}">{{$ticket->type}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control d-none display-booking" id="tables" name="type">
                                    @foreach($event->tables as $table)
                                        <option value="{{$table->type}}" data-price="{{$table->price}}">{{$table->type}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control d-none display-booking" id="guestlists" name="type">
                                    @foreach($event->guestlists as $guestlist)
                                        <option value="{{$guestlist->type}}" data-price="{{$guestlist->price}}">{{$guestlist->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="price">Price *</label>
                                <input type="text" class="form-control" id="price" name="price"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="date" class="form-control text-center"/>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-6">
                            <button id="submit-button" type="submit" class="btn btn-primary">Create a Booking</button>
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
        function changePrice(e) {
            const price = $(e).find("option:selected").attr('data-price');
            $("#price").val(price);
        };

        function changeSelectOption() {
            var booking_type = $("#booking_type option:selected").val();
            alert(booking_type);
            $(".display-booking").addClass("d-none");
            if (booking_type === "Table Booking") {
                $("#tables").removeClass("d-none");
                changePrice("#tables");
                $("#tables").on('change', function() {
                    changePrice("#tables");
                });
            } else if (booking_type === "Ticket") {
                $("#tickets").removeClass("d-none");
                changePrice("#tickets");
                $("#tickets").on('change', function() {
                    changePrice("#tickets");
                })
            } else if (booking_type === "Guestlist") {
                $("#guestlists").removeClass("d-none");
                changePrice("#guestlists");
                $("#tickets").on('change', function() {
                    changePrice("#tickets");
                });
            }
        }
        changeSelectOption();

        $("#booking_type").on('change', function() {
            changeSelectOption();
        });
    })
</script>
@endsection