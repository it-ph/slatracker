$(document).ready(function() {
    USER.load();
});

const USER = (() => {
    let this_user = {}
    let _user_id;

    // store / update data
    $('#userForm').on('submit', function(e) {
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
                    url: `${APP_URL}/job/store`,
                    data: formdata
                }).then((response) => {
                    console.log(response.data.status)
                    if (response.data.status === 'success') {
                        $('#loader').show();
                        $("#tbl_jobs > tbody").empty();
                        $("#tbl_jobs_info").hide();
                        $("#tbl_jobs_paginate").hide();
                        resetForm();
                        USER.load();
                        $('#userModal').modal('hide');
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
    this_user.load = () => {
        axios(`${APP_URL}/job/all`).then(function(response) {
            $('#tbl_jobs').DataTable().clear().draw();
            $('#tbl_jobs').DataTable().destroy();
            var table;
            console.log(response.data.data)
            response.data.data.forEach(val => {
                table +=
                    `<tr>
                        <td>${val.name}</td>
                        <td>${val.request_type}</td>
                        <td>${val.request_volume}</td>
                        <td>${val.is_special_request}</td>
                        <td>${val.created_at}</td>
                        <td>${val.start_at}</td>
                        <td>${val.end_at}</td>
                        <td>${val.agreed_sla}</td>
                        <td>${val.time_taken}</td>
                        <td>${val.sla_missed}</td>
                        <td>${val.internal_quality}</td>
                        <td>${val.external_quality}</td>
                        <td>${val.developer}</td>
                        <td class="text-center">${val.status}</td>
                        <td class="text-center">${val.action}</td>
                    </tr>`;
            });
            $('#tbl_jobs tbody').html(table)

            $('#tbl_jobs').DataTable({
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
    this_user.showModal = () => {
        $('#userModal').modal('show');
        $('#default-status').hide();
        $('#userModalTitle').text('Create User');
        resetForm();
    }

    // show data
    this_user.show = (id) => {
        resetForm();
        $('#userModal').modal('show');
        $('#default-status').show();
        $('#btn_save').empty();
        $('#btn_save').append('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#btn_save').prop("disabled", true);
        $('#userModalTitle').text('Update User');
        toastr.info('Retrieving User Data...');
        axios(`${APP_URL}/job/show/${id}`).then((response) => {
            _user_id = id;

            let roles = [];
            response.data.data.theroles.forEach(role => {
                roles.push(role.name);
            });
            $('#role-ctr').val(roles);
            $('input[name="roles[]"]').val(roles);
            $("#edit_id").val(response.data.data.id);
            $("#username").val(response.data.data.username);
            $("#email").val(response.data.data.email);
            $("#client_id").val(response.data.data.client_id).trigger("change");
            $("#status_").val(response.data.data.status).trigger("change");
            $('#btn_save').empty();
            $('#btn_save').append('<i class="fa fa-save"></i> Update');
            $('#btn_save').prop("disabled", false);
            toastr.success('User data retrieved successfully!');
        }).catch(error => {
            toastr.error(error);
        });
    }
    return this_user;
})()
