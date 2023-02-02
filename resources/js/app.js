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
                type: 'line',
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


Alpine.start();
