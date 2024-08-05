const JOB = (() => {
    let this_job = {}
    let _job_id;

    // show modal
    this_job.showModal = () => {
        $('#startJobModal').modal('show');
    }

    // start job
    this_job.start = (id) => {
        $('#btn_start').empty();
        $('#btn_start').append('<i class="fa fa-spinner fa-spin"></i> Starting...');
        $('#btn_start').prop("disabled", true);
        axios({
                method: 'get',
                url: `${APP_URL}/myjob/start/${id}`,
            })
            .then(function(response) {
                console.log(response.data.status)
                if (response.data.status === 'success') {
                    toastr.success(response.data.message);
                    $('#startJobModal').modal('hide');
                    location.reload();
                } else {
                    toastr.error(response.data.message);
                }
            }).catch(error => {
                toastr.error(null);
            });
    }

    // submit details
    $('#submitDetailsForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-primary btn-sm mt-2 mr-2',
            cancelButtonClass: 'btn btn-danger btn-sm ms-2 mt-2 mr-2',
            buttonsStyling: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                var formdata = new FormData(this);
                $('.error').hide();
                $('.error').text('');
                $('#btn_save').empty();
                $('#btn_save').append('<i class="fa fa-spinner fa-spin"></i> Saving...');
                $('#btn_save').prop("disabled", true);
                // Send a POST request
                axios({
                    method: 'POST',
                    url: `${APP_URL}/myjob/submitdetails`,
                    data: formdata
                }).then((response) => {
                    console.log(response.data.status)
                    if (response.data.status === 'success') {
                        toastr.success(response.data.message);
                        location.reload();
                    } else if (response.data.status === 'warning') {
                        Object.keys(response.data.error).forEach((key) => {
                            $(`#${[key]}Error`).show();
                            $(`#${[key]}Error`).text(response.data.error[key][0]);
                            toastr.error(response.data.error[key][0]);
                        });
                    } else {
                        toastr.error(response.data.message);
                    }
                    $('#btn_save').empty();
                    $('#btn_save').append('<i class="fa fa-save"></i> Submit');
                    $('#btn_save').prop("disabled", false);
                }).catch(error => {
                    toastr.error(error);
                });
            }
        });
    });

    // send for QC
    $('#sendForQCForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-primary btn-sm mt-2 mr-2',
            cancelButtonClass: 'btn btn-danger btn-sm ms-2 mt-2 mr-2',
            buttonsStyling: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                var formdata = new FormData(this);
                $('.error').hide();
                $('.error').text('');
                $('#btn_send').empty();
                $('#btn_send').append('<i class="fa fa-spinner fa-spin"></i> Sending...');
                $('#btn_send').prop("disabled", true);
                // Send a POST request
                axios({
                    method: 'POST',
                    url: `${APP_URL}/myjob/sendforqc`,
                    data: formdata
                }).then((response) => {
                    console.log(response.data.status)
                    if (response.data.status === 'success') {
                        toastr.success(response.data.message);
                        location.reload();
                    } else if (response.data.status === 'warning') {
                        Object.keys(response.data.error).forEach((key) => {
                            $(`#${[key]}Error`).show();
                            $(`#${[key]}Error`).text(response.data.error[key][0]);
                            toastr.error(response.data.error[key][0]);
                        });
                    } else {
                        toastr.error(response.data.message);
                    }
                    $('#btn_send').empty();
                    $('#btn_send').append('<i class="fa fa-paper-plane"></i> Submit');
                    $('#btn_send').prop("disabled", false);
                }).catch(error => {
                    toastr.error(error);
                });
            }
        });
    });

    // auto NA when the user clicks no
    $('.no').click((e) => {
        let name = $(e.target).attr('name');
        var na = $('input[name = "' + name + '"]:checked').val();
        var value = na == 0 ? "NA" : null;
        $('#comments_' + name).val(value);
    });

    // cancel
    $('#btn_cancel').click(() => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonClass: 'btn btn-primary btn-sm mt-2 mr-2',
            cancelButtonClass: 'btn btn-danger btn-sm ms-2 mt-2 mr-2',
            buttonsStyling: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                toastr.success('Cancelled successfully!');
                location.reload();
            }
        });
    });

    return this_job;
})()