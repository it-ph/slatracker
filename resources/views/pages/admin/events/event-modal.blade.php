<div class="modal fade" id="eventModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalTitle">Create New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <label for="title" class="col-form-label"><strong>Title:<span class="important">*</span></strong></label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter event title">
                        <label id="titleError" class="error" style="display:none"></label>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label"><strong>Title:<span class="important">*</span></strong></label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="3" placeholder="Enter event description"></textarea>
                        <label id="descriptionError" class="error" style="display:none"></label>
                    </div>
                    <div class="form-group">
                        <label for="event_type" class="col-form-label"><strong>Event Type:<span class="important">*</span></strong></label>
                        <select class="form-select" name="event_type" id="event_type">
                            <option value="" disabled selected>-- Select Event Type --</option>
                            <option value="Client Holiday">Client Holiday</option>
                            <option value="eClerx Holiday" >eClerx Holiday</option>
                            <option value="Meeting" >Meeting</option>
                            <option value="Reminder" >Reminder</option>
                            <option value="Others" >Others</option>
                        </select>
                        <label id="event_typeError" class="error" style="display:none"></label>
                    </div>
                    <div class="form-group">
                        <label for="start" class="col-form-label"><strong>Start Day:<span class="important">*</span></strong></label>
                        <input type="datetime-local" class="form-control" name="start" id="start">
                        <label id="startError" class="error" style="display:none"></label>
                    </div>
                    <div class="form-group">
                        <label for="end" class="col-form-label"><strong>End Day:<span class="important">*</span></strong></label>
                        <input type="datetime-local" class="form-control" name="end" id="end">
                        <label id="endError" class="error" style="display:none"></label>
                    </div>
                    <div class="form-group">
                        <label for="color" class="col-form-label"><strong>Color:<span class="important">*</span></strong></label>
                        <input type="color" class="form-control" name="color" id="color">
                        <label id="colorError" class="error" style="display:none"></label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save</button>
                <button type="button" id="btn_delete" class="btn btn-danger waves-effect waves-light" style="display: none"><i class="fa fa-trash"></i> Delete</button>
                <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
