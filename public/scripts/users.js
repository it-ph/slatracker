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
                    url: `${APP_URL}/user/store`,
                    data: formdata
                }).then((response) => {
                    console.log(response.data.status)
                    if (response.data.status === 'success') {
                        $('#loader').show();
                        $("#tbl_users > tbody").empty();
                        $("#tbl_users_info").hide();
                        $("#tbl_users_paginate").hide();
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
        axios(`${APP_URL}/user/all`).then(function(response) {
            $('#tbl_users').DataTable().clear().draw();
            $('#tbl_users').DataTable().destroy();
            var table;
            console.log(response.data.data)
            response.data.data.forEach(val => {
                table +=
                    `<tr>
                        <td>${val.username}</td>
                        <td>${val.email_address}</td>
                        <td>${val.client}</td>
                        <td>${val.roles}</td>
                        <td>${val.last_login_at}</td>
                        <td class="text-center">${val.status}</td>
                        <td class="text-center">${val.action}</td>
                    </tr>`;
            });
            $('#tbl_users tbody').html(table)

            $('#tbl_users').DataTable({
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
        $('#userModalTitle').text('Create User');
        resetForm();
    }

    // show data
    this_user.show = (id) => {
        resetForm();
        $('#userModal').modal('show');
        $('#btn_save').empty();
        $('#btn_save').append('<i class="fa fa-spinner fa-spin"></i> Loading...');
        $('#btn_save').prop("disabled", true);
        toastr.info('Retrieving User Data...');
        axios(`${APP_URL}/user/show/${id}`).then((response) => {
            _user_id = id;

            let roles = [];
            response.data.data.theroles.forEach(role => {
                roles.push(role.name);
            });
            $('#role-ctr').val(roles);
            $('input[name="roles[]"]').val(roles);
            $('#userModalTitle').text('Update User');
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

    // check if has role
    $('.theroles').change(function() {
        let roles = [];
        $.each($("input[name='roles[]']:checked"), function() {
            roles.push($(this).val());
        });

        $('#role-ctr').val(roles);
    });

    // destroy data
    this_user.destroy = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#00599D",
            cancelButtonColor: "#F46A6A",
            confirmButtonText: 'Yes, deactivate it!',
            cancelButtonText: 'No, cancel!',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                axios({
                        method: 'post',
                        url: `${APP_URL}/user/delete/${id}`,
                    })
                    .then(function(response) {
                        console.log(response.data.status)
                        if (response.data.status === 'success') {
                            $('#loader').show();
                            $("#tbl_users > tbody").empty();
                            $("#tbl_users_info").hide();
                            $("#tbl_users_paginate").hide();
                            resetForm();
                            toastr.success(response.data.message);
                            USER.load();
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
        $('#userModalTitle').text('Create New User');
        $('#userForm')[0].reset();
        $("#edit_id").val(null);
        $("#username").empty();
        $("#email").empty();
        $("#client_id").val(null).trigger("change");
        $("#status_").val('active').trigger("change");
        $('.error').hide();
        $('.error').text('');
        $('#btn_save').empty();
        $('#btn_save').append('<i class="fa fa-save"></i> Save');
        console.clear();
    }

    return this_user;
})()
