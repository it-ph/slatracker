/** APEX CHARTS - DONUT */
// Jobs Closed By Request Type
var options = {
    chart: {
        height: 280,
        type: 'donut'
    },
    series: [44, 55, 41, 17, 15],
    labels: ["A", "B", "C", "D", "E"],
    colors: ["#34c38f", "#556ee6", "#f46a6a", "#50a5f1", "#f1b44c"],
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        verticalAlign: 'middle',
        floating: false,
        fontSize: '14px',
        offsetX: 0
    },
    responsive: [{
        breakpoint: 600,
        options: {
            chart: {
                height: 240
            },
            legend: {
                show: false
            }
        }
    }]
};
var chart = new ApexCharts(document.querySelector("#jobs_closed_by_request_type"), options);
chart.render();

// SLA Summary
var options = {
    chart: {
        height: 280,
        type: 'donut'
    },
    series: [44, 55, 41, 17, 15],
    labels: ["A", "B", "C", "D", "E"],
    colors: ["#34c38f", "#556ee6", "#f46a6a", "#50a5f1", "#f1b44c"],
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        verticalAlign: 'middle',
        floating: false,
        fontSize: '14px',
        offsetX: 0
    },
    responsive: [{
        breakpoint: 600,
        options: {
            chart: {
                height: 240
            },
            legend: {
                show: false
            }
        }
    }]
};
var chart = new ApexCharts(document.querySelector("#sla_summary"), options);
chart.render();

// QC Rounds
var options = {
    chart: {
        height: 280,
        type: 'donut'
    },
    series: [44, 55, 41, 17, 15],
    labels: ["A", "B", "C", "D", "E"],
    colors: ["#34c38f", "#556ee6", "#f46a6a", "#50a5f1", "#f1b44c"],
    legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        verticalAlign: 'middle',
        floating: false,
        fontSize: '14px',
        offsetX: 0
    },
    responsive: [{
        breakpoint: 600,
        options: {
            chart: {
                height: 240
            },
            legend: {
                show: false
            }
        }
    }]
};
var chart = new ApexCharts(document.querySelector("#qc_rounds"), options);
chart.render();

/** CHART JS - BAR */

// Closed Jobs Internal QC Summary %
new Chart($('#closed_jobs_internal_qc_summary'), {
    type: 'bar',
    data: {
        labels: ["A", "B", "C", "D", "E"],
        datasets: [{
            label: "Population (millions)",
            backgroundColor: ["#00599D", "#00599D", "#00599D", "#00599D", "#00599D"],
            data: [80, 100, 150, 200, 300, 400]
        }]
    },
    options: {
        legend: { display: false },
    }
});

// Internal Quality Summary %
new Chart($('#internal_quality_summary_percentage'), {
    type: 'bar',
    data: {
        labels: ["A", "B", "C", "D", "E"],
        datasets: [{
            label: "Population (millions)",
            backgroundColor: ["#00599D", "#00599D", "#00599D", "#00599D", "#00599D"],
            data: [80, 100, 150, 200, 300, 400]
        }]
    },
    options: {
        legend: { display: false },
    }
});

// External Quality Summary %
new Chart($('#external_quality_summary_percentage'), {
    type: 'bar',
    data: {
        labels: ["A", "B", "C", "D", "E"],
        datasets: [{
            label: "Population (millions)",
            backgroundColor: ["#00599D", "#00599D", "#00599D", "#00599D", "#00599D"],
            data: [80, 100, 150, 200, 300, 400]
        }]
    },
    options: {
        legend: { display: false },
    }
});