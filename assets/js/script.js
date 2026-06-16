const fileInput = document.getElementById('certificateFile');
const uploadText = document.getElementById('uploadText');

fileInput?.addEventListener('change', () => {
  const file = fileInput.files?.[0];
  if (!file) return;

  uploadText.innerHTML = `${file.name}<br />File berhasil dipilih`;
});

document.addEventListener('DOMContentLoaded', () => {

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
