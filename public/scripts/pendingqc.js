$(document).ready(function() {
    JOB.load();
});

const JOB = (() => {
    let this_job = {}
    let _job_id;

    // store / update data
    $('#jobForm').on('submit', function(e) {
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
                    url: `${APP_URL}/pendingqc/store`,
                    data: formdata
                }).then((response) => {
                    console.log(response.data.status)
                    if (response.data.status === 'success') {
                        $('#loader').show();
                        $("#tbl_jobs > tbody").empty();
                        $("#tbl_jobs_info").hide();
                        $("#tbl_jobs_paginate").hide();
                        resetForm();
                        JOB.load();
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
    this_job.load = () => {
        axios(`${APP_URL}/pendingqc/all`).then(function(response) {
            $('#tbl_jobs').DataTable().clear().draw();
            $('#tbl_jobs').DataTable().destroy();
            var table;
            console.log(response.data.data)
            response.data.data.forEach(val => {
                table +=
                    `<tr>
                        <td>${val.name}</td>
                        <td>${val.request_type}</td>
                        <td class="text-center">${val.request_volume}</td>
                        <td class="text-center">${val.special_request}</td>
                        <td class="text-center">${val.created_at}</td>
                        <td class="text-center">${val.agreed_sla}</td>
                        <td class="text-center">${val.time_taken}</td>
                        <td class="text-center">${val.sla_missed}</td>
                        <td class="text-center">${val.developer}</td>
                        <td class="text-center">${val.qc_round}</td>
                        <td class="text-center">${val.auditor}</td>
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
                "order": [4, "desc"],
                "columnDefs": [{ type: 'date', 'targets': [4] }],
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

    // pick job
    this_job.pick = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, pick it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-primary btn-sm mt-2 mr-2',
            cancelButtonClass: 'btn btn-secondary btn-sm ms-2 mt-2 mr-2',
            buttonsStyling: false,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                $('#btn_pick_' + id).empty();
                $('#btn_pick_' + id).append('<i class="fa fa-spinner fa-spin"></i>');
                $('#btn_pick_' + id).prop("disabled", true);
                axios({
                        method: 'get',
                        url: `${APP_URL}/pendingqc/pick/${id}`,
                    })
                    .then(function(response) {
                        console.log(response.data.status)
                        if (response.data.status === 'success') {
                            JOB.load();
                            toastr.success(response.data.message);
                        } else {
                            toastr.error(response.data.message);
                        }
                    }).catch(error => {
                        toastr.error(null);
                    });
            }
        });
    }

    return this_job;
})()