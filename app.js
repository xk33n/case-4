document.getElementById('surveyForm').addEventListener('submit', function(event) {
    // Проверяем обязательные поля
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const country = document.getElementById('country');

    if (!name.value || !email.value || !country.value) {
        alert("Пожалуйста, заполните все обязательные поля.");
        event.preventDefault(); // Отменяем отправку формы
    }
});

$(document).ready(function() {
    $.ajax({
        url: 'get_results.php',
        type: 'GET',
        success: function(response) {
            let results = JSON.parse(response);

            // Построение графика распределения полов
            let genderLabels = Object.keys(results.genderCount);
            let genderValues = Object.values(results.genderCount);

            createBarChart(genderLabels, genderValues, '#genderChart', 'Распределение полов');

            // Построение круговой диаграммы популярных языков программирования
            let languageLabels = Object.keys(results.languageCount);
            let languageValues = Object.values(results.languageCount);

            createDoughnutChart(languageLabels, languageValues, '#languageChart', 'Популярные языки программирования');

            // Построение столбчатой диаграммы стран проживания
            let countryLabels = Object.keys(results.countryCount);
            let countryValues = Object.values(results.countryCount);

            createHorizontalBarChart(countryLabels, countryValues, '#countryChart', 'Страны проживания');
        },
        error: function(xhr, status, error) {
            console.error('Ошибка загрузки данных:', xhr.responseText);
        }
    });
});

function createBarChart(labels, values, canvasId, title) {
    let ctx = $(canvasId);
    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                data: values,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)'
                ]
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

function createDoughnutChart(labels, values, canvasId, title) {
    let ctx = $(canvasId);
    let chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56'],
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        },
        options: {
            title: {
                display: true,
                text: title
            }
        }
    });
}

function createHorizontalBarChart(labels, values, canvasId, title) {
    let ctx = $(canvasId);
    let chart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                data: values,
                fill: false,
                borderWidth: 1,
                barPercentage: 0.5,
                categoryPercentage: 0.5
            }]
        },
        options: {
            legend: {
                position: 'top'
            },
            scales: {
                xAxes: [{ ticks: { beginAtZero: true } }],
                yAxes: []
            }
        }
    });
}
