<div class="modal fade" id="requestVolumeModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="requestVolumeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestVolumeModalTitle">Create New Request Volume</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="requestVolumeForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <label for="name" class="col-form-label"><strong>Num Pages:<span class="important">*</span></strong></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter number of Pages E.g 1, 2, 3, etc.">
                        <label id="nameError" class="error"></label>
                    </div>
                    {{-- <div class="form-group">
                        <label for="department_id" class="col-form-label"><strong>Department:<span class="important">*</span></strong></label>
                        <select class="form-control select2" name="department_id" id="department_id" style="width:100%;">
                            <option value="" selected disabled>-- Select Department -- </option>
                                @foreach ($departments as $department )
                                    @if($department)
                                        <option {{ old('department_id') == $department->id ? "selected" : "" }}
                                            value="{{ $department->id }}">{{ ucwords($department->name) }}
                                        </option>
                                    @endif
                                @endforeach
                        </select>
                        <label id="department_idError" class="error" style="display:none"></label>
                    </div> --}}
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
