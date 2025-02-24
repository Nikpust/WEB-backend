document.addEventListener("DOMContentLoaded", function() {
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownButton.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownMenu.classList.toggle('open');
    });

    const dropdownButton2 = document.getElementById('dropdownButton2');
    const dropdownMenu2 = document.getElementById('dropdownMenu2');
    
    dropdownButton2.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownMenu2.classList.toggle('open');
    });

    window.Select_Option = function(value) {
        document.getElementById('selected-option').textContent = value;
        document.getElementById('selected-age').value = value;
        dropdownMenu2.classList.remove('open');
    };
});
