$(document).ready(function() {
    REQUEST_SLA.load();
});

const REQUEST_SLA = (() => {
    let this_request_sla = {}
    let _request_sla_id;

    // store / update data
    $('#requestSLAForm').on('submit', function(e) {
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
                    url: `${APP_URL}/request/sla/store`,
                    data: formdata
                }).then((response) => {
                    console.log(response.data.status)
                    if (response.data.status === 'success') {
                        $('#loader').show();
                        $("#tbl_request_slas > tbody").empty();
                        $("#tbl_request_slas_info").hide();
                        $("#tbl_request_slas_paginate").hide();
                        resetForm();
                        REQUEST_SLA.load();
                        $('#requestSLAModal').modal('hide');
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
    this_request_sla.load = () => {
        axios(`${APP_URL}/request/sla/all`).then(function(response) {
            $('#tbl_request_slas').DataTable().clear().draw();
            $('#tbl_request_slas').DataTable().destroy();
            var table;
            console.log(response.data.data)
            response.data.data.forEach(val => {
                table +=
                    `<tr>
                        <td>${val.request_type}</td>
                        <td class="text-center">${val.num_pages}</td>
                        <td class="text-center">${val.agreed_sla}</td>
                        <td>${val.created_by}</td>
                        <td>${val.created_at}</td>
                        <td>${val.updated_by}</td>
                        <td>${val.updated_at}</td>
                        <td class="text-center">${val.status}</td>
                        <td class="text-center">${val.action}</td>
                    </tr>`;
            });
            $('#tbl_request_slas tbody').html(table)

            $('#tbl_request_slas').DataTable({
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
    this_request_sla.showModal = () => {
        $('#requestSLAModal').modal('show');
        $('#requestSLAModalTitle').text('Create New Request SLA');
        resetForm();
    }

    // show data
    this_request_sla.show = (id) => {
        resetForm();
        $('#requestSLAModal').modal('show');
        $('#btn_save').empty();
        $('#btn_save').append('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#btn_save').prop("disabled", true);
        $('#requestSLAModalTitle').text('Update Request SLA');
        toastr.info('Retrieving Request SLA Data...');
        axios(`${APP_URL}/request/sla/show/${id}`).then((response) => {
            _request_sla_id = id;
            $("#edit_id").val(response.data.data.id);
            $("#request_type_id").val(response.data.data.request_type_id).trigger("change");
            $("#request_volume_id").val(response.data.data.request_volume_id).trigger("change");
            $("#agreed_sla").val(response.data.data.agreed_sla);
            $('#btn_save').empty();
            $('#btn_save').append('<i class="fa fa-save"></i> Update');
            $('#btn_save').prop("disabled", false);
            toastr.success('Request SLA data retrieved successfully!');
        }).catch(error => {
            toastr.error(error);
        });
    }

    // destroy data
    this_request_sla.destroy = (id) => {
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
                        url: `${APP_URL}/request/sla/delete/${id}`,
                    })
                    .then(function(response) {
                        console.log(response.data.status)
                        if (response.data.status === 'success') {
                            $('#loader').show();
                            $("#tbl_request_slas > tbody").empty();
                            $("#tbl_request_slas_info").hide();
                            $("#tbl_request_slas_paginate").hide();
                            resetForm()
                            toastr.success(response.data.message);
                            REQUEST_SLA.load();
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
        $('#requestSLAModalTitle').text('Create New Request SLA');
        $('#requestSLAForm')[0].reset();
        $("#edit_id").val(null);
        $("#request_type_id").val(null).trigger("change");
        $("#request_volume_id").val(null).trigger("change");
        $('.error').hide();
        $('.error').text('');
        $('#btn_save').empty();
        $('#btn_save').append('<i class="fa fa-save"></i> Save');
        console.clear();
    }

    return this_request_sla;
})()
