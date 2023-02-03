import './bootstrap';

import Alpine from 'alpinejs';

import Chart from 'chart.js/auto';

window.Alpine = Alpine;

window.Chart = Chart;

const defaultColor = '#818CF8';


window.teacherCourses = (config) => {
    return {
        init() {
            new Chart(config.element, {
                type: 'bar',
                data: {
                    labels: config.labels,
                    datasets: [{
                        label: 'Courses',
                        data: config.data,
                        backgroundColor: defaultColor,
                        // borderRadius: Number.MAX_VALUE,
                        borderSkipped: false,
                        barPercentage: 0.5,
                        // barThickness: 6,
                        maxBarThickness: 80,
                        // minBarLength: 2,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            display: true,
                        },
                        x: {
                            display: false,
                            grid: {
                                offset: true
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                        },
                        tooltip: {
                            enabled: true,
                            displayColors: false,
                        }
                    }
                }
            });
        }
    }
}

window.courseTypes = (config) => {
    return {
        init() {
            new Chart(config.element, {
                type: 'doughnut',
                data: {
                    labels: config.labels,
                    datasets: [{
                        label: 'Courses',
                        data: config.data,
                        backgroundColor: config.backgroundColors,
                        color:['red', 'blue', 'green']
                    }],
                },
                options: {
                    cutout: '75%',
                    borderWidth: 0,
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                    }
                },
                plugins: [counter],
            });
        }
    }
}

const counter = {
    id: 'counter',
    beforeDraw(chart, args, options) {
        const {ctx, chartArea: {width, height}} = chart;
        const data = chart.data.datasets[0].data;
        const fontSize = 35;
        ctx.save();

        ctx.font = fontSize + 'px Nunito';
        ctx.textAlign = 'center';
        ctx.fillStyle = 'rgb(107 114 128)'
        ctx.fillText(data.reduce((a, b) => a + b, 0), width / 2, (height / 2) + fontSize * 0.34)
    }
}

Alpine.start();
