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

    return this_job;
})()