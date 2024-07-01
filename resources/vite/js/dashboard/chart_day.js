import Chart from 'chart.js/auto';
import datalabels from 'chartjs-plugin-datalabels';

Chart.register(datalabels);

document.addEventListener('DOMContentLoaded', () => {

    let labels = data20DaysAgo.map(item => item.date).reverse();
    let moneyProfits = data20DaysAgo.map(item => item.money_profit).reverse();
    let betProfits = data20DaysAgo.map(item => item.bet_profit).reverse();

    const options = {
        color: 'white',
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            },
            datalabels: {
                color: 'white',
                formatter: function (value, context) {
                    return value.toLocaleString() + '원';
                },
                align: 'end',
                anchor: 'end'
            }
        },
        scales: {
            x: {
                ticks: {
                    color: 'white',
                    maxTicksLimit: 10
                },
                grid: {
                    color: '#707070',
                }
            },
            y: {
                ticks: {
                    color: 'white',
                    maxTicksLimit: 6
                },
                grid: {
                    color: '#707070',
                }
            },
        },
    };

    const ctx = document.getElementById('myChart').getContext('2d');

    const data = {
        labels: labels,
        datasets: [{
            label: "수익금액",
            data: moneyProfits,
            fill: false,
            borderColor: 'white',
            tension: 0.1,
            showLine: true,
        }, {
            label: "배팅손익",
            data: betProfits,
            fill: false,
            borderColor: '#368ee0',
            tension: 0.1,
            showLine: true,
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: options
    };

    new Chart(ctx, config);
});

$(document).ready(function () {

    let labels_casino_slot = [
        '롤링금액',
        '수익금',
        '승률',
    ];
    let backgroundColor = [
        'rgba(0, 153, 253, 1)',
        'rgba(90, 192, 255, 1)',
        'rgba(0, 206, 255, 1)',
    ];

    new Chart($('#casinoChart')[0], {
        type: 'bar',
        data: {
            labels: labels_casino_slot,
            datasets: [{
                axis: 'y',
                label: '카지노',
                data: [
                    Number(sum_bet_minus_win_today_casino), //money rolling - money win
                    Number(sum_win_today_casino),
                    Number(rate_convert_to_money_win_today_casino),
                ],
                fill: false,
                backgroundColor: backgroundColor,
                borderWidth: 1,
            }],
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: '#fff',
                    },
                },
                tooltip: {
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    footerColor: '#fff',
                },
                datalabels: {
                    color: 'black',
                    formatter: function (value, context) {
                        return value.toLocaleString() + '원';
                    },
                    align: 'end',
                    anchor: 'end'
                }
            },
            scales: {
                x: {
                    position: 'top',
                    ticks: {
                        color: '#fff',
                    }
                },
                y: {
                    ticks: {
                        color: '#fff',
                    }
                }
            },
        },
    });

    new Chart($('#slotChart')[0], {
        type: 'bar',
        data: {
            labels: labels_casino_slot,
            datasets: [{
                axis: 'y',
                data: [
                    Number(sum_bet_minus_win_today_slot),
                    Number(sum_win_today_slot),
                    Number(rate_convert_to_money_win_today_slot),
                ],
                fill: false,
                backgroundColor: backgroundColor,
                borderWidth: 1,
            }],
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: '#fff',
                    },
                },
                tooltip: {
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    footerColor: '#fff',
                },
                datalabels: {
                    color: 'black',
                    formatter: function (value, context) {
                        return value.toLocaleString() + '원';
                    },
                    align: 'end',
                    anchor: 'end'
                }
            },
            scales: {
                x: {
                    position: 'top',
                    ticks: {
                        color: '#fff',
                    }
                },
                y: {
                    ticks: {
                        color: '#fff',
                    }
                }
            },
        },
    });

    new Chart($('#sportsChart')[0], {
        type: 'bar',
        data: {
            labels: labels_casino_slot,
            datasets: [{
                axis: 'y',
                data: [],
                fill: false,
                backgroundColor: backgroundColor,
                borderWidth: 1,
            }],
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: '#fff',
                    },
                },
                tooltip: {
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    footerColor: '#fff',
                },
                datalabels: {
                    color: 'black',
                    formatter: function (value, context) {
                        return value.toLocaleString() + '원';
                    },
                    align: 'end',
                    anchor: 'end'
                }
            },
            scales: {
                x: {
                    position: 'top',
                    ticks: {
                        color: '#fff',
                    }
                },
                y: {
                    ticks: {
                        color: '#fff',
                    }
                }
            },
        },
    });

    new Chart($('#realTimeChart')[0], {
        type: 'bar',
        data: {
            labels: labels_casino_slot,
            datasets: [{
                axis: 'y',
                data: [],
                fill: false,
                backgroundColor: backgroundColor,
                borderWidth: 1,
            }],
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: '#fff',
                    },
                },
                tooltip: {
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    footerColor: '#fff',
                },
                datalabels: {
                    color: 'black',
                    formatter: function (value, context) {
                        return value.toLocaleString() + '원';
                    },
                    align: 'end',
                    anchor: 'end'
                }
            },
            scales: {
                x: {
                    position: 'top',
                    ticks: {
                        color: '#fff',
                    }
                },
                y: {
                    ticks: {
                        color: '#fff',
                    }
                }
            },
        },
    });

    new Chart($('#virtualSportsChart')[0], {
        type: 'bar',
        data: {
            labels: labels_casino_slot,
            datasets: [{
                axis: 'y',
                data: [],
                fill: false,
                backgroundColor: backgroundColor,
                borderWidth: 1,
            }],
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: '#fff',
                    },
                },
                tooltip: {
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    footerColor: '#fff',
                },
                datalabels: {
                    color: 'black',
                    formatter: function (value, context) {
                        return value.toLocaleString() + '원';
                    },
                    align: 'end',
                    anchor: 'end'
                }
            },
            scales: {
                x: {
                    position: 'top',
                    ticks: {
                        color: '#fff',
                    }
                },
                y: {
                    ticks: {
                        color: '#fff',
                    }
                }
            },
        },
    });

    new Chart($('#miniGameChart')[0], {
        type: 'bar',
        data: {
            labels: labels_casino_slot,
            datasets: [{
                axis: 'y',
                data: [],
                fill: false,
                backgroundColor: backgroundColor,
                borderWidth: 1,
            }],
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: '#fff',
                    },
                },
                tooltip: {
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    footerColor: '#fff',
                },
                datalabels: {
                    color: 'black',
                    formatter: function (value, context) {
                        return value.toLocaleString() + '원';
                    },
                    align: 'end',
                    anchor: 'end'
                }
            },
            scales: {
                x: {
                    position: 'top',
                    ticks: {
                        color: '#fff',
                    }
                },
                y: {
                    ticks: {
                        color: '#fff',
                    }
                }
            },
        },
    });
});
