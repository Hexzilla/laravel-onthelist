<div id="venue-offer-list" class="col-md-12">
    <div id="venue-offer-default" class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="offerType">Offer Type</label>
                <select class="form-control" name="offer_type[]">
                    <option value="Discount" {{$offer? '': 'selected'}}>Discount</option>
                    <option value="Type 2" {{ ($offer && $offer->type === 'Type 2') ? 'selected' : '' }}>Type 2</option>
                    <option value="Type 3" {{ ($offer && $offer->type === 'Type 3') ? 'selected' : '' }}>Type 3</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="offerQuantity">Offer Quantity</label>
                <input type="number" class="form-control" placeholder="0" name="offer_qty[]" value="{{ $offer ? $offer->qty : old('offer_qty[]') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="offerPrice">Offer Price</label>
                <input type="number" class="form-control" placeholder="£0" name="offer_price[]" value="{{ $offer ? $offer->price : old('offer_price[]') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="offerApproval">Offer Approval</label>
                <select class="form-control" name="offer_approval[]">
                    <option value="Yes" {{ ($offer && $offer->approval === 'Yes') ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($offer && $offer->approval === 'Yes') ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="message">Description</label>
                <textarea class="form-control" rows="3" name="offer_description[]" placeholder=""></textarea>
            </div>
        </div>
        <hr class="venue-offer-separator mb-3"/>
    </div>
</div>