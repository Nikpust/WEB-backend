document.addEventListener('DOMContentLoaded', () => {
    initFormHandling();
    initEditButtons();
    initDeleteButtons();
});

// Отправка формы (создание или обновление книги)
function initFormHandling() {
    const form = document.getElementById('add-book-form');
    const messageBox = document.getElementById('message');
    const messageContent = document.getElementById('message-content');
    const submitButton = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        submitButton.disabled = true;

        // Если редактирование — добавляем ID книги
        if (form.dataset.editing === 'true') {
            formData.append('id', form.dataset.id);
        }

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(result => {
            const success = result.success;
            showMessage(result.message, success);

            if (success) {
                form.reset();
                document.getElementById('modal-title').textContent = 'Добавить книгу';

                if (form.dataset.editing === 'true') {
                    setTimeout(() => {
                        closeModal();
                        location.reload();
                    }, 2500);
                }

                form.removeAttribute('data-editing');
                form.removeAttribute('data-id');
            }
        })
        .catch(() => {
            showMessage('Произошла ошибка. Попробуйте позже.', false);
        })
        .finally(() => {
            submitButton.disabled = false;
        });
    });
}

// Обработка кнопки "редактировать"
function initEditButtons() {
    document.addEventListener('click', function (e) {
        if (!e.target.classList.contains('btn-edit')) return;

        const id = e.target.dataset.id;

        fetch('/book/get?id=' + encodeURIComponent(id))
        .then(res => res.json())
        .then(result => {
            if (!result.success) return showMessage(result.message, false);

            const book = result.data;
            const form = document.getElementById('add-book-form');

            openModal();
            form.action = '/book/update';
            form.dataset.editing = 'true';
            form.dataset.id = book.book_id;

            fillFormWithBookData(book);
            document.getElementById('modal-title').textContent = 'Обновить данные книги';
        });
    });
}

// Обработка кнопки "удалить"
function initDeleteButtons() {
    document.addEventListener('click', function (e) {
        if (!e.target.classList.contains('btn-delete')) return;

        const id = e.target.dataset.id;
        if (!confirm('Удалить эту книгу?')) return;

        fetch('/book/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) location.reload();
        });
    });
}

// Заполняет форму данными книги
function fillFormWithBookData(book) {
    const form = document.getElementById('add-book-form');

    form.book.value = book.book_name;
    form.author.value = book.book_author;
    form.year.value = book.book_year;
    form.publisher.value = book.book_publisher;
    form.isbn.value = book.book_isbn;
    form.pages.value = book.book_pages;
    form.release_date.value = book.book_release_date;
    form.weight.value = book.book_weight;
    form.price.value = book.book_price;
    form.summary.value = book.book_summary;

    document.getElementById('selected-age').value = book.book_age;
    document.getElementById('selected-option').textContent = book.book_age;

    const genres = book.genres.split(',').map(g => g.trim());
    document.querySelectorAll('#dropdown-menu-genre input[type="checkbox"]').forEach(ch => {
        ch.checked = genres.includes(ch.value);
    });
}

// Показывает сообщение об ошибке или успехе
function showMessage(message, isSuccess) {
    const box = document.getElementById('message');
    const content = document.getElementById('message-content');
    
    box.style.display = 'block';
    box.classList.remove('hidden', 'success', 'error');
    box.classList.add('show', isSuccess ? 'success' : 'error');
    content.textContent = message;
}

// Закрытие уведомления вручную
function closeMessage() {
    const box = document.getElementById('message');
    const content = document.getElementById('message-content');

    box.classList.remove('show', 'success', 'error');
    box.style.display = 'none';
    content.textContent = '';
}