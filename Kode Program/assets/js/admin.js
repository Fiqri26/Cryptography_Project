cument.addEventListener('DOMContentLoaded', () => {

    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {

        setTimeout(() => {

            alert.classList.add('alert-hide');

            setTimeout(() => {
                alert.remove();
            }, 500);

        }, 3000);

    });

});
