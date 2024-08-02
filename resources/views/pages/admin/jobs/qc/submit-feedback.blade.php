<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <p class="fw-bold mb-1 text-primary">Submit Feedback</p>
                        <form id="addJobForm" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group row mb-2">
                                    <input type="hidden" name="edit_id" id="edit_id" value="{{ $job['id'] }}">
                                    <label for="platform" class="col-sm-3 col-form-label fw-bold">QC Status <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="platform" id="platform">
                                            <option value=""disabled selected>-- Select QC Status -- </option>
                                            <option value="Pass" >Pass</option>
                                            <option value="Fail" >Fail</option>
                                        </select>
                                        <label id="platformError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="template_followed" class="col-sm-3 col-form-label fw-bold">Call for Rework <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_yes" value="1">
                                            <label class="form-check-label" for="template_followed_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_no" value="0">
                                            <label class="form-check-label" for="template_followed_no">No</label>
                                        </div><br>
                                        <label id="template_followedError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="num_new_images" class="col-sm-3 col-form-label fw-bold">Num of Times <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="num_new_images" id="num_new_images" placeholder="Enter num of times" value="0">
                                        <label id="num_new_imagesError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="comments_template_issue" class="col-sm-3 col-form-label fw-bold">Alignment & Aesthetics <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_yes" value="1">
                                            <label class="form-check-label" for="template_followed_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_no" value="0">
                                            <label class="form-check-label" for="template_followed_no">No</label>
                                        </div><br>
                                        <label id="template_followedError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="comments_auto_recommend" class="col-sm-3 col-form-label fw-bold">Comments for Alignment & Aesthetics <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="comments_auto_recommend" id="comments_auto_recommend" cols="30" rows="4" placeholder="Enter comments for alignment & aesthetics ."></textarea>
                                        <label id="comments_auto_recommendError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="comments_template_issue" class="col-sm-3 col-form-label fw-bold">Availability and Formats <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_yes" value="1">
                                            <label class="form-check-label" for="template_followed_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_no" value="0">
                                            <label class="form-check-label" for="template_followed_no">No</label>
                                        </div><br>
                                        <label id="template_followedError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="comments_auto_recommend" class="col-sm-3 col-form-label fw-bold">Comments for Availability and Formats <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="comments_auto_recommend" id="comments_auto_recommend" cols="30" rows="4" placeholder="Enter comments for availability and formats ."></textarea>
                                        <label id="comments_auto_recommendError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="comments_template_issue" class="col-sm-3 col-form-label fw-bold">Accuracy <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_yes" value="1">
                                            <label class="form-check-label" for="template_followed_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_no" value="0">
                                            <label class="form-check-label" for="template_followed_no">No</label>
                                        </div><br>
                                        <label id="template_followedError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="comments_auto_recommend" class="col-sm-3 col-form-label fw-bold">Comments for Accuracy <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="comments_auto_recommend" id="comments_auto_recommend" cols="30" rows="4" placeholder="Enter comments for accuracy ."></textarea>
                                        <label id="comments_auto_recommendError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="comments_template_issue" class="col-sm-3 col-form-label fw-bold">Functionality <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_yes" value="1">
                                            <label class="form-check-label" for="template_followed_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_followed" id="template_followed_no" value="0">
                                            <label class="form-check-label" for="template_followed_no">No</label>
                                        </div><br>
                                        <label id="template_followedError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="dev_comments" class="col-sm-3 col-form-label fw-bold">Comments for Functionality <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="dev_comments" id="dev_comments" cols="30" rows="4" placeholder="Enter comments for functionality."></textarea>
                                        <label id="dev_commentsError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="dev_comments" class="col-sm-3 col-form-label fw-bold">QC Comments <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="dev_comments" id="dev_comments" cols="30" rows="4" placeholder="Enter qc comments."></textarea>
                                        <label id="dev_commentsError" class="error" style="display:none"></label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                                    <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
