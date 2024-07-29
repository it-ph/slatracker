$(document).ready(function() {
    CLIENT.load();
});

const CLIENT = (() => {
    let this_client = {}
    let _client_id;

    // store / update data
    $('#addJobForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
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
                $('#btn_save').append('<i class="fa fa-spinner fa-spin"></i> Updating...');
                $('#btn_save').prop("disabled", true);
                // Send a POST request
                axios({
                    method: 'POST',
                    url: `${APP_URL}/client/updateEmailConfig`,
                    data: formdata
                }).then((response) => {
                    console.log(response.data.status)
                    if (response.data.status === 'success') {
                        CLIENT.load();
                        toastr.success(response.data.message);
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
                    $('#btn_save').append('<i class="fa fa-save"></i> Update');
                    $('#btn_save').prop("disabled", false);
                }).catch(error => {
                    toastr.error(error);
                });
            }
        });
    });

    function resetForm() {
        $('#addJobForm')[0].reset();
        $("#platform").val(null).trigger("change");
        $("#developer_id").val(null).trigger("change");
        $("#request_type_id").val(null).trigger("change");
        $("#request_volume_id").val(null).trigger("change");
        $('.error').hide();
        $('.error').text('');
        $('#btn_save').empty();
        $('#btn_save').append('<i class="fa fa-save"></i> Save');
        console.clear();
    }

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
                resetForm();
            }
        });
    });

    return this_client;
})()
