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
