
$(function() {
    'use strict';

    // Define chart data
    const chartData = [
        {
            id: 'chartBar1',
            type: 'bar',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Sales',
                data: [24, 10, 32, 24, 26, 20],
                backgroundColor: '#664dc9'
            }],
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: { display: false },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, fontSize: 10, max: 80 } }],
                    xAxes: [{ barPercentage: 0.6, ticks: { beginAtZero: true, fontSize: 11 } }]
                }
            }
        },
        {
            id: 'chartBar2',
            type: 'bar',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Sales',
                data: [14, 12, 34, 25, 24, 20],
                backgroundColor: '#44c4fa'
            }],
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: { display: false },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, fontSize: 10, max: 80 } }],
                    xAxes: [{ barPercentage: 0.6, ticks: { beginAtZero: true, fontSize: 11 } }]
                }
            }
        },
        {
            id: 'chartBar3',
            type: 'bar',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Sales',
                data: [14, 12, 34, 25, 24, 20],
                backgroundColor: (ctx) => {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
                    gradient.addColorStop(0, '#44c4fa');
                    gradient.addColorStop(1, '#664dc9');
                    return gradient;
                }
            }],
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: { display: false },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, fontSize: 10, max: 80 } }],
                    xAxes: [{ barPercentage: 0.6, ticks: { beginAtZero: true, fontSize: 11 } }]
                }
            }
        },
        {
            id: 'chartBar4',
            type: 'bar',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Sales',
                data: [14, 12, 34, 25, 24, 20],
                backgroundColor: ['#664dc9', '#44c4fa', '#38cb89', '#3e80eb', '#ffab00', '#ef4b4b']
            }],
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, fontSize: 10 } }],
                    xAxes: [{ ticks: { beginAtZero: true, fontSize: 11, max: 80 } }]
                }
            }
        },
        {
            id: 'chartBar5',
            type: 'bar',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [
                {
                    data: [14, 12, 34, 25, 24, 20],
                    backgroundColor: ['#664dc9', '#38cb89', '#116e7c', '#ffab00', '#ef4b4b']
                },
                {
                    data: [22, 30, 25, 30, 20, 40],
                    backgroundColor: '#44c4fa'
                }
            ],
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, fontSize: 11 } }],
                    xAxes: [{ ticks: { beginAtZero: true, fontSize: 11, max: 80 } }]
                }
            }
        },
        {
            id: 'chartStacked1',
            type: 'bar',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    data: [14, 12, 34, 25, 24, 20],
                    backgroundColor: '#664dc9',
                    borderWidth: 1,
                    fill: true
                },
                {
                    data: [14, 12, 34, 25, 24, 20],
                    backgroundColor: '#44c4fa',
                    borderWidth: 1,
                    fill: true
                }
            ],
            options: {
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    yAxes: [{ stacked: true, ticks: { beginAtZero: true, fontSize: 11 } }],
                    xAxes: [{ barPercentage: 0.5, stacked: true, ticks: { fontSize: 11 } }]
                }
            }
        },
        {
            id: 'chartStacked2',
            type: 'bar',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    data: [14, 12, 34, 25, 24, 20],
                    backgroundColor: '#664dc9',
                    borderWidth: 1,
                    fill: true
                },
                {
                    data: [14, 12, 34, 25, 24, 20],
                    backgroundColor: '#44c4fa',
                    borderWidth: 1,
                    fill: true
                }
            ],
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    yAxes: [{ stacked: true, ticks: { beginAtZero: true, fontSize: 10, max: 80 } }],
                    xAxes: [{ stacked: true, ticks: { beginAtZero: true, fontSize: 11 } }]
                }
            }
        },
        {
            id: 'chartLine1',
            type: 'line',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    data: [14, 12, 34, 25, 44, 36, 35, 25, 30, 32, 20, 25],
                    borderColor: '#664dc9',
                    borderWidth: 1,
                    fill: false
                },
                {
                    data: [35, 30, 45, 35, 55, 40, 10, 20, 25, 55, 50, 45],
                    borderColor: '#44c4fa',
                    borderWidth: 1,
                    fill: false
                }
            ],
            options: {
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, fontSize: 10, max: 80 } }],
                    xAxes: [{ ticks: { beginAtZero: true, fontSize: 11 } }]
                }
            }
        },
        {
            id: 'chartArea1',
            type: 'line',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    data: [14, 12, 34, 25, 44, 36, 35, 25, 30, 32, 20, 25],
                    borderColor: '#664dc9',
                    borderWidth: 1,
                    backgroundColor: (ctx) => {
                        const gradient1 = ctx.createLinearGradient(0, 350, 0, 0);
                        gradient1.addColorStop(0, 'rgba(102, 77, 201, 0)');
                        gradient1.addColorStop(1, 'rgba(102, 77, 201, .5)');
                        return gradient1;
                    }
                },
                {
                    data: [35, 30, 45, 35, 55, 40, 10, 20, 25, 55, 50, 45],
                    borderColor: '#44c4fa',
                    borderWidth: 1,
                    backgroundColor: (ctx) => {
                        const gradient2 = ctx.createLinearGradient(0, 280, 0, 0);
                        gradient2.addColorStop(0, 'rgba(91, 115, 232, 0)');
                        gradient2.addColorStop(1, 'rgba(91, 115, 232, .5)');
                        return gradient2;
                    }
                }
            ],
            options: {
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, fontSize: 10, max: 80 } }],
                    xAxes: [{ ticks: { beginAtZero: true, fontSize: 11 } }]
                }
            }
        },
        {
            id: 'chartPie',
            type: 'doughnut',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                data: [35, 20, 8, 15, 24],
                backgroundColor: ['#664dc9', '#44c4fa', '#38cb89', '#3e80eb', '#ffab00', '#ef4b4b']
            }],
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: { display: false },
                animation: { animateScale: true, animateRotate: true }
            }
        },
        {
            id: 'chartDonut',
            type: 'pie',
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                data: [35, 20, 8, 15, 24],
                backgroundColor: ['#664dc9', '#44c4fa', '#38cb89', '#3e80eb', '#ffab00', '#ef4b4b']
            }],
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: { display: false },
                animation: { animateScale: true, animateRotate: true }
            }
        }
    ];

    // Initialize charts
    chartData.forEach(chart => {
        const ctx = document.getElementById(chart.id).getContext('2d');
        new Chart(ctx, {
            type: chart.type,
            data: {
                labels: chart.labels,
                datasets: chart.datasets.map(dataset => ({
                    ...dataset,
                    backgroundColor: typeof dataset.backgroundColor === 'function' 
                                      ? dataset.backgroundColor(ctx) 
                                      : dataset.backgroundColor
                }))
            },
            options: chart.options
        });
    });
});

