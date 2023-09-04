import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    try {
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="to[]"]');

        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
        });
    } catch (error) {
        // Ignore the Error
    }
});

