document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formCade');
    const btnSubmit = document.getElementById('btnSubmit');

    if (!form || !btnSubmit) {
        return;
    }

    const dniInput = document.getElementById('dni');
    if (dniInput) {
        dniInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 8);
        });
    }

    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
        });
    }

    const terminoInput = document.getElementById('terminos');

    form.addEventListener('submit', function (event) {
        if (terminoInput && !terminoInput.checked) {
            event.preventDefault();
            return;
        }

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
    });
});
