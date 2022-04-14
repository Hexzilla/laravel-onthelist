<div id="event-ticket-default" class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="ticket_type">Ticket Type</label>
            <input id="ticket_type" class="form-control ticket_type" name="ticket_type[]" value="{{ $ticket ? $ticket->type : old('ticket_type[]') }}"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="ticketQuantity">Ticket Quantity</label>
            <input type="number" min="0" class="form-control" placeholder="0" name="ticket_qty[]" value="{{ $ticket ? $ticket->qty : old('ticket_qty[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="ticketPrice">Ticket Price (£)</label>
            <input type="number" min="0" class="form-control" placeholder="£0" name="ticket_price[]" value="{{ $ticket ? $ticket->price : old('ticket_price[]') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="ticketApproval">Booking Approval</label>
            <select class="form-control approval" name="ticket_approval[]">
                <option value="Yes" {{ ($ticket && $ticket->approval === 'Yes') ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ ($ticket && $ticket->approval === 'No') ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="message">Description</label>
            <textarea class="form-control" rows="3" name="ticket_description[]" placeholder="">
                {{$ticket ? $ticket->description : old('ticket_description[]')}}
            </textarea>
        </div>
    </div>
    <hr class="venue-table-separator mb-3"/>
</div>