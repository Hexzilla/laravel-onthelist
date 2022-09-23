<div id="event-table-default" class="row event-table">
    <input type="hidden" name="table_id[]" value="{{ $table ? $table->id : old('table_id[]')}}">
    <div class="col-md-12">
        <a class="remove-event-table add-another-link float-right d-none"><i class="mdi mdi-minus"></i> Remove table</a>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="table_type">Table Type</label>
            <input type="text" id="table_type" class="form-control table_type" name="table_type[]" value="{{ $table ? $table->type : old('table_type[]')}}"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tableQuantity">Table Quantity</label>
            <input type="number" min="0" max="100000000" class="form-control" placeholder="0" name="table_qty[]" value="{{ $table ? $table->qty : old('table_qty[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tablePrice">Table Price (£)</label>
            <input type="number" min="0" max="100000000" class="form-control" placeholder="£0" name="table_price[]" step="any" value="{{ $table ? $table->price : old('table_price[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tableApproval">Booking Approval</label>
            <select class="form-control approval" name="table_approval[]">
                <option value="Yes" {{ ($table && $table->approval !== 'Yes') ? '' : 'selected' }}>Yes</option>
                <option value="No" {{ ($table && $table->approval === 'No') ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="message">Description</label>
            <textarea class="form-control" rows="3" placeholder="" name="table_description[]">{{$table ? $table->description : old('table_description[]')}}</textarea>
        </div>
    </div>
    <hr class="venue-table-separator mb-3"/>
</div>