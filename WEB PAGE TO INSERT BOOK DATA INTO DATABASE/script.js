document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const yearInput = document.getElementById('year');

    function validateYear(year) {
        const currentYear = new Date().getFullYear();
        return year >= 1500 && year <= currentYear;
    }

    form.addEventListener('submit', function (event) {
        if (!validateYear(parseInt(yearInput.value))) {
            event.preventDefault();
            alert("Please enter a valid year between 1500 and the current year.");
        }
    });
});
