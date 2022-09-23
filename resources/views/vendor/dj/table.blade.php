<div id="venue-table-default" class="row venue-table">
    <input type="hidden" name="table_id[]" value="{{ $table ? $table->id : old('table_id[]')}}">
    <div class="col-md-12">
        <a class="remove-venue-table add-another-link float-right"><i class="mdi mdi-minus"></i> Remove table</a>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="offerType">Table Type</label>
            <select class="form-control" name="table_type[]">
                <option value="Type 1" {{ ($table && $table->type !== 'Type 1') ? '' : 'selected' }}>Type 1</option>
                <option value="Type 2" {{ ($table && $table->type === 'Type 2') ? 'selected' : '' }}>Type 2</option>
                <option value="Type 3" {{ ($table && $table->type === 'Type 2') ? 'selected' : '' }}>Type 3</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="offerQuantity">Table Quantity</label>
            <input type="number" min="0" max="100000000" class="form-control" placeholder="0" name="table_qty[]" value="{{ $table ? $table->qty : old('table_qty[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="offerPrice">Table Price</label>
            <input type="number" min="0" max="100000000" class="form-control" placeholder="£0" step="any" name="table_price[]" value="{{ $table ? $table->price : old('table_price[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="offerApproval">Booking Approval</label>
            <select class="form-control" name="table_approval[]">
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