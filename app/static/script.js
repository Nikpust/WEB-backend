document.addEventListener("DOMContentLoaded", function() {
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownButton.addEventListener('click', function(event) {
        eventоиог.preventDefault();
        dropdownMenu.classList.toggle('open');
    });
});
