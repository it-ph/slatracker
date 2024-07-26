<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="userModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <label for="username" class="col-form-label"><strong>FullName:<span class="important">*</span></strong></label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter Full Name">
                        <label id="usernameError" class="error" style="display:none"></label>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-form-label"><strong>Email Address:<span class="important">*</span></strong></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Addrress">
                        <label id="emailError" class="error" style="display:none"></label>
                    </div>
                    <div class="form-group">
                        <label for="client_id" class="col-form-label"><strong>Client:<span class="important">*</span></strong></label>
                        <select class="form-control select2" name="client_id" id="client_id" style="width:100%;">
                            <option value="" selected disabled>-- Select Client -- </option>
                                @foreach ($clients as $client )
                                    @if($client)
                                        <option {{ old('client_id') == $client->id ? "selected" : "" }}
                                            value="{{ $client->id }}">{{ ucwords($client->name) }}
                                        </option>
                                    @endif
                                @endforeach
                        </select>
                        <label id="client_idError" class="error" style="display:none"></label>
                    </div>
                    <div class="form-group">
                        <label for="role" class="col-form-label"><strong>Roles:<span class="important">*</span></strong></label>
                        <div class="roles-checklists">
                            <input type="hidden" class="form-control" name="role-ctr" id="role-ctr">
                            @if(in_array('admin',$user['roles']))
                            <div class="form-check">
                                <input class="form-check-input theroles" type="checkbox" name="roles[]" value="admin" id="admin">
                                <label class="form-check-label" for="admin">
                                    Admin
                                </label>
                            </div>
                            @endif
                            <div class="form-check">
                                <input class="form-check-input theroles" type="checkbox" name="roles[]" value="developer" id="developer">
                                <label class="form-check-label" for="developer">
                                    Developer
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input theroles" type="checkbox" name="roles[]" value="auditor" id="auditor">
                                <label class="form-check-label" for="auditor">
                                    Auditor
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input theroles" type="checkbox" name="roles[]" value="team lead" id="team_lead">
                                <label class="form-check-label" for="team_lead">
                                    Team Lead
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input theroles" type="checkbox" name="roles[]" value="manager" id="manager">
                                <label class="form-check-label" for="manager">
                                    Manager
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input theroles" type="checkbox" name="roles[]" value="client" id="client">
                                <label class="form-check-label" for="client">
                                    Client
                                </label>
                            </div>
                        </div>
                        <label id="role-ctrError" class="error" style="display:none"></label>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-form-label"><strong>Status:<span class="important">*</span></strong></label>
                        <select class="form-select" name="status" id="status_">
                            <option value="active">Active</option>
                            <option value="deactivated" >Deactivated</option>
                        </select>
                        <label id="statusError" class="error" style="display:none"></label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn_save"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
