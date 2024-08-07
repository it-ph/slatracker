<div class="modal fade" id="reallocateModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="reallocateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reallocateModalTitle">Reallocate Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reallocateForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="edit_id" id="edit_id">                                    
                        <label for="developer_id" class="col-sm-3 col-form-label fw-bold">Developer <strong><span class="important">*</span></strong></label>
                        <select class="form-control select2" name="developer_id" id="developer_id"  style="width:100%;">
                            <option value=""disabled selected>-- Select Developer -- </option>
                                @foreach ($developers as $developer)
                                    @if(!$developer->hasActiveJob($developer->id))
                                        <option value="{{ $developer->id }}">{{ ucwords($developer->username) }}</option>
                                    @endif
                                @endforeach
                        </select>
                        <label id="developer_idError" class="error" style="display:none"></label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn_save"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-handshake-o"></i> Reallocate</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
