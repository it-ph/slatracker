$(document).ready(function() {
    REQUEST_VOLUME.load();
});

const REQUEST_VOLUME = (() => {
    let this_request_volume = {}
    let _request_volume_id;

    // store / update data
    $('#requestVolumeForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-primary btn-sm mt-2 mr-2',
            cancelButtonClass: 'btn btn-secondary btn-sm ms-2 mt-2 mr-2',
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
                    url: `${APP_URL}/request/volume/store`,
                    data: formdata
                }).then((response) => {
                    console.log(response.data.status)
                    if (response.data.status === 'success') {
                        $('#loader').show();
                        $("#tbl_request_volumes > tbody").empty();
                        $("#tbl_request_volumes_info").hide();
                        $("#tbl_request_volumes_paginate").hide();
                        resetForm();
                        REQUEST_VOLUME.load();
                        $('#requestVolumeModal').modal('hide');
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
                    $('#btn_save').append('<i class="fa fa-save"></i> Save');
                    $('#btn_save').prop("disabled", false);
                }).catch(error => {
                    toastr.error(error);
                });
            }
        });
    });

    // load data
    this_request_volume.load = () => {
        axios(`${APP_URL}/request/volume/all`).then(function(response) {
            $('#tbl_request_volumes').DataTable().clear().draw();
            $('#tbl_request_volumes').DataTable().destroy();
            var table;
            console.log(response.data.data)
            response.data.data.forEach(val => {
                table +=
                    `<tr>
                        <td hidden>${val.id}</td>
                        <td>${val.name}</td>
                        <td>${val.created_by}</td>
                        <td>${val.created_at}</td>
                        <td>${val.updated_by}</td>
                        <td>${val.updated_at}</td>
                        <td class="text-center">${val.status}</td>
                        <td class="text-center">${val.action}</td>
                    </tr>`;
            });
            $('#tbl_request_volumes tbody').html(table)

            $('#tbl_request_volumes').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="fa fa-forward"></i>',
                        sPrevious: '<i class="fa fa-backward"></i>',
                        sFirst: '<i class="fa fa-step-backward"></i>',
                        sLast: '<i class="fa fa-step-forward"></i>'
                    },
                },
                // dom: 'Bfrtip',
                // buttons: [
                //     'excel'
                // ],
                "pageLength": 10,
                "pagingType": "full_numbers",
                "scrollX": true,
            });

            $('#loader').hide();
            if (response.data.data.length > 0)
                toastr.success(response.data.message);
            else
                toastr.info(response.data.message);
        }).catch(error => {
            toastr.error(null);
        });
    }

    // show modal
    this_request_volume.showModal = () => {
        $('#requestVolumeModal').modal('show');
        $('#requestVolumeModalTitle').text('Create New Request Volume');
        resetForm();
    }

    // show data
    this_request_volume.show = (id) => {
        resetForm();
        $('#requestVolumeModal').modal('show');
        $('#btn_save').empty();
        $('#btn_save').append('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#btn_save').prop("disabled", true);
        toastr.info('Retrieving Request Volume Data...');
        axios(`${APP_URL}/request/volume/show/${id}`).then((response) => {
            _request_volume_id = id;
            $('#requestVolumeModalTitle').text('Update Request Volume');
            $("#edit_id").val(response.data.data.id);
            $("#name").val(response.data.data.name);
            $('#btn_save').empty();
            $('#btn_save').append('<i class="fa fa-save"></i> Update');
            $('#btn_save').prop("disabled", false);
            toastr.success('Request Volume data retrieved successfully!');
        }).catch(error => {
            toastr.error(error);
        });
    }

    // destroy data
    this_request_volume.destroy = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#00599D",
            cancelButtonColor: "#F46A6A",
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                axios({
                        method: 'post',
                        url: `${APP_URL}/request/volume/delete/${id}`,
                    })
                    .then(function(response) {
                        console.log(response.data.status)
                        if (response.data.status === 'success') {
                            $('#loader').show();
                            $("#tbl_request_volumes > tbody").empty();
                            $("#tbl_request_volumes_info").hide();
                            $("#tbl_request_volumes_paginate").hide();
                            resetForm()
                            toastr.success(response.data.message);
                            REQUEST_VOLUME.load();
                        } else {
                            toastr.error(response.data.message);
                        }
                    }).catch(error => {
                        toastr.error(null);
                    });
            }
        });
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
            cancelButtonClass: 'btn btn-secondary btn-sm ms-2 mt-2 mr-2',
            buttonsStyling: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                resetForm();
            }
        });
    });

    function resetForm() {
        $('#requestVolumeModalTitle').text('Create New Request Volume');
        $('#requestVolumeForm')[0].reset();
        $("#edit_id").val(null);
        $("#name").empty();
        $('.error').hide();
        $('.error').text('');
        $('#btn_save').empty();
        $('#btn_save').append('<i class="fa fa-save"></i> Save');
        console.clear();
    }

    return this_request_volume;
})()
