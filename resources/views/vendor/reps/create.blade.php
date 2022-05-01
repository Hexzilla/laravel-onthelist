@extends('layouts.vendor')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-12 p-md-0 justify-content-sm-start mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Reps</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Rep</a></li>
                </ol>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xl-8 col-xxl-8">
                <form method="POST" action="{{ route('vendors.event.create_rep') }}" class="EventForm needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="main-title mb-5">Create Affiliate Program</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="event_id" value="{{ $id }}">
                                <label for="code">Code Of Your Affiliate Program</label>
                                <input type="text" class="form-control" name="affiliate_code" id="code">
                            </div>
                            <div class="form-group">
                                <label for="referral_fee">Referral Fee</label>
                                <input type="text" class="form-control" name="referral_fee" id="referral_fee">
                            </div>
                            <div class="form-group">
                                <label for="additional_notes">Additional Notes</label>
                                <textarea class="form-control" id="additional_notes" name="additional_notes"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-6">
                            <button id="submit_button" type="submit" class="btn btn-primary">Create Affiliate Link</button>
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
    function initMap() {
        const input = document.getElementById("venue_location");
        const options = {
            fields: ["formatted_address", "geometry", "name"],
            strictBounds: false,
            types: ["establishment"],
        };
        const autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            console.log('place', place)

            if (!place.geometry || !place.geometry.location) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                //window.alert("No details available for input: '" + place.name + "'");
                return;
            }
        });
    }
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap&libraries=places&v=weekly" 
    async
></script>
@endsection