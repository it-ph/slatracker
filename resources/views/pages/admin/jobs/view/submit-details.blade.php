<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <p class="fw-bold mb-1">Submit Details</p>
                        <form id="addJobForm" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <input type="hidden" name="edit_id" id="edit_id" value="{{ $job['id'] }}">
                                    <label for="template_followed" class="col-sm-3 col-form-label fw-bold">Template Followed <strong><span class="important">*</span></strong></label>
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

                                <div class="form-group row">
                                    <label for="template_issue" class="col-sm-3 col-form-label fw-bold">Any Issue with Template <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_issue" id="template_issue_yes" value="1">
                                            <label class="form-check-label" for="template_issue_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="template_issue" id="template_issue_no" value="0">
                                            <label class="form-check-label" for="template_issue_no">No</label>
                                        </div><br>
                                        <label id="template_issueError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="comments_template_issue" class="col-sm-3 col-form-label fw-bold">Comments for Issue in Template <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="comments_template_issue" id="comments_template_issue" cols="30" rows="4" placeholder="Enter comments for issue in template."></textarea>
                                        <label id="comments_template_issueError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="auto_recommended" class="col-sm-3 col-form-label fw-bold">Automation Recommended <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="auto_recommended" id="auto_recommended_yes" value="1">
                                            <label class="form-check-label" for="auto_recommended_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="auto_recommended" id="auto_recommended_no" value="0">
                                            <label class="form-check-label" for="auto_recommended_no">No</label>
                                        </div><br>
                                        <label id="auto_recommendedError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="comments_auto_recommend" class="col-sm-3 col-form-label fw-bold">Comments for Automation Recommendation <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="comments_auto_recommend" id="comments_auto_recommend" cols="30" rows="4" placeholder="Enter comments for automation recommendation."></textarea>
                                        <label id="comments_auto_recommendError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="img_localstock" class="col-sm-3 col-form-label fw-bold">Image(s) used from Localstock <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="img_localstock" id="img_localstock_yes" value="1">
                                            <label class="form-check-label" for="img_localstock_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="img_localstock" id="img_localstock_no" value="0">
                                            <label class="form-check-label" for="img_localstock_no">No</label>
                                        </div><br>
                                        <label id="img_localstockError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="img_customer" class="col-sm-3 col-form-label fw-bold">Image(s) provided by Customer <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="img_customer" id="img_customer_yes" value="1">
                                            <label class="form-check-label" for="img_customer_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="img_customer" id="img_customer_no" value="0">
                                            <label class="form-check-label" for="img_customer_no">No</label>
                                        </div><br>
                                        <label id="img_customerError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="num_new_images" class="col-sm-3 col-form-label fw-bold">Num of new images used <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="num_new_images" id="num_new_images" placeholder="Enter num of new images used" value="0">
                                        <label id="num_new_imagesError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="shared_folder_loc" class="col-sm-3 col-form-label fw-bold">Shared Folder Location <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="shared_folder_loc" id="shared_folder_loc" placeholder="Enter shared folder location">
                                        <label id="shared_folder_locError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="dev_comments" class="col-sm-3 col-form-label fw-bold">Developer Comments <strong><span class="important">*</span></strong></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="dev_comments" id="dev_comments" cols="30" rows="4" placeholder="Enter developer comments."></textarea>
                                        <label id="dev_commentsError" class="error" style="display:none"></label>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                                    <button type="button" id="btn_cancel" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>