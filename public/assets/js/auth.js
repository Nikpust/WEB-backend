document.addEventListener('DOMContentLoaded', () => {
    initFormHandlingRegister();
    initFormHandlingLogin();
    
    const container = document.getElementById('auth-container');
    const signUpBtn = document.getElementById('to-signup');
    const signInBtn = document.getElementById('to-signin');
    const adminCheckbox = document.getElementById('is-admin');
    const adminKeyWrapper = document.getElementById('admin-key-wrapper');

    function switchPanel(toSignup = false) {
        container.classList.add('switching');
        container.classList.toggle('right-panel-active', toSignup);
        container.classList.remove('switching');
        clearForms();
    }

    signUpBtn?.addEventListener('click', () => {
        switchPanel(true);
        history.pushState(null, '', '/register');
    });

    signInBtn?.addEventListener('click', () => {
        switchPanel(false);
        history.pushState(null, '', '/login');
    });

    adminCheckbox?.addEventListener('change', (e) => {
        adminKeyWrapper?.classList.toggle('visible', e.target.checked);
    });

    document.body.addEventListener('click', (e) => {
        const btn = e.target.closest('.message-close');
        if (btn) closeMessage(btn.dataset.close);
    });
});

function initFormHandlingRegister() {
    const formRegister = document.getElementById('register-form');

    formRegister.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(formRegister);
        const submitButton = formRegister.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        fetch(formRegister.action, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(result => {
            const success = result.success;

            if (success) {
                formRegister.reset();
                document.getElementById('to-signin').click();
            } else {
                showMessage('register', result.message);
            }
        })
        .catch(() => {
            showMessage('register', 'Ошибка при регистрации. Попробуйте позже.');
        })
        .finally(() => {
            submitButton.disabled = false;
        });
    });
}

function initFormHandlingLogin() {
    const formLogin = document.getElementById('login-form');

    formLogin.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(formLogin);
        const submitButton = formLogin.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        fetch(formLogin.action, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(result => {
            const success = result.success;

            if (success && result.redirect) {
                window.location.href = result.redirect;
            } else {
                showMessage('login', result.message);
            }
        })
        .catch(() => {
            showMessage('login', 'Ошибка при входе. Попробуйте позже.');
        })
        .finally(() => {
            submitButton.disabled = false;
        });
    });
}

function showMessage(type, text) {
    const box     = document.getElementById(`${type}-message`);
    const content = document.getElementById(`${type}-message-content`);

    content.textContent = text;
    box.classList.remove('hidden', 'success', 'error');
    box.classList.add('show', 'error');
    box.style.display = 'block';
}

function closeMessage(type) {
    const box     = document.getElementById(`${type}-message`);
    const content = document.getElementById(`${type}-message-content`);

    box.classList.remove('show');
    box.style.display = 'none';
    content.textContent = '';
}

function clearForms() {
    const formRegister = document.getElementById('register-form');
    const formLogin = document.getElementById('login-form');

    formRegister?.reset();
    formLogin?.reset();

    closeMessage('register');
    closeMessage('login');

    const adminKeyWrapper = document.getElementById('admin-key-wrapper');
    adminKeyWrapper?.classList.remove('visible');
}