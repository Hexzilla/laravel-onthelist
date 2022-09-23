<div id="event-guestlist-default" class="row event-guestlist">
    <input type="hidden" name="guestlist_id[]" value="{{ $guestlist ? $guestlist->id : old('guestlist_id[]')}}">
    <div class="col-md-12">
        <a class="remove-event-guestlist add-another-link float-right d-none"><i class="mdi mdi-minus"></i> Remove guestlist</a>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="guestlist_type">Guestlist Type</label>
            <input type="text" id="guestlist_type" class="form-control guestlist_type" name="guestlist_type[]" value="{{ $guestlist ? $guestlist->type : old('guestlist_type[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="guestlistQuantity">Guestlist Quantity</label>
            <input type="number" min="0" max="100000000" class="form-control" placeholder="0" name="guestlist_qty[]" value="{{ $guestlist ? $guestlist->qty : old('guestlist_qty[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="guestlistPrice">Guestlist Price (£)</label>
            <input type="number" min="0" max="100000000" class="form-control" placeholder="£0" name="guestlist_price[]" step="any" value="{{ $guestlist ? $guestlist->price : old('guestlist_qty[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="guestlistApproval">Booking Approval</label>
            <select class="form-control approval" name="guestlist_approval[]">
                <option value="Yes" {{ ($guestlist && $guestlist->approval !== 'Yes') ? '' : 'selected' }}>Yes</option>
                <option value="No" {{ ($guestlist && $guestlist->approval === 'No') ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>                                
    <div class="col-md-12">
        <div class="form-group">
            <label for="message">Description</label>
            <textarea class="form-control" rows="3" placeholder="" name="guestlist_description[]">{{$guestlist ? $guestlist->description : ''}}</textarea>
        </div>
    </div>
    <hr class="venue-table-separator mb-3"/>
</div>