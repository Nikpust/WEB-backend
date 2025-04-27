function openModal() {
    const overlay = document.getElementById('modal-overlay');
    overlay.classList.add('open');
    document.body.classList.add('blurred');
}

function closeModal() {
    const overlay = document.getElementById('modal-overlay');
    const form = document.getElementById('add-book-form');
    overlay.classList.remove('open');
    document.body.classList.remove('blurred');
    form.reset();
    closeMessage();
    location.reload();
}

document.addEventListener('click', function (event) {
    const modal = document.getElementById('modal-overlay');
    if (modal.classList.contains('open') && event.target === modal) {
        closeModal();
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});