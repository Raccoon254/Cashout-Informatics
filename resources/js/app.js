import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="to[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
