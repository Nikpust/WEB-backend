document.addEventListener("DOMContentLoaded", function() {
    const dropdownButtonGenre = document.getElementById('drop-button-genre');
    const dropdownMenuGenre = document.getElementById('dropdown-menu-genre');

    dropdownButtonGenre.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownMenuGenre.classList.toggle('open');
    });

    const dropdownButtonAge = document.getElementById('drop-button-age');
    const dropdownMenuAge = document.getElementById('dropdown-menu-age');
    
    dropdownButtonAge.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownMenuAge.classList.toggle('open');
    });

    Select_Option = function(value) {
        document.getElementById('selected-option').textContent = value;
        document.getElementById('selected-age').value = value;

        const labels = dropdownMenuAge.querySelectorAll('label');
        labels.forEach(label => {
            const input = label.querySelector('input[type="radio"]');
            if (input.value === value) {
                input.checked = true;
                label.classList.add('selected');
            } else {
                input.checked = false;
                label.classList.remove('selected');
            }
        });

        dropdownMenuAge.classList.remove('open');
    };

    document.addEventListener('click', function (event) {
        if (!dropdownButtonGenre.contains(event.target) && !dropdownMenuGenre.contains(event.target)) {
            dropdownMenuGenre.classList.remove('open');
        }
        if (!dropdownButtonAge.contains(event.target) && !dropdownMenuAge.contains(event.target)) {
            dropdownMenuAge.classList.remove('open');
        }
    });

    
});
