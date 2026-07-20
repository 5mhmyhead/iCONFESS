document.addEventListener('DOMContentLoaded', function() {
    initLoginForm();
    initRegisterForm();
    syncAuthState();
});

function appUrl(path) {
    return '?url=' + path;
}

function postJson(path, data) {
    return fetch(appUrl(path), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response =>
        response.json().then(body => ({ status: response.status, body }))
    );
}

function showAlert(el, message) {
    if(!el) return;
    el.textContent = message;
    el.style.display = 'flex';
}

function hideAlert(el) {
    if(!el) return;
    el.textContent = '';
    el.style.display = 'none';
}

function initLoginForm() {
    const form = document.getElementById('login-form');
    if(!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const errorAlert = document.getElementById('login-error-alert');
        hideAlert(errorAlert);

        const data = {
            username: document.getElementById('login-username').value,
            password: document.getElementById('login-password').value
        };

        postJson('auth/loginUser', data)
            .then(res => {
                if(res.status === 200 || res.body.success) {
                    localStorage.setItem('jwt_token', res.body.token);
                    window.location.href = appUrl('confessions');
                } else {
                    showAlert(errorAlert, res.body.message || 'Login failed.');
                }
            })
            .catch(() => showAlert(errorAlert, 'An unexpected error occurred.'));
    });
}

function initRegisterForm() {
    const form = document.getElementById('register-form');
    if(!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const errorAlert   = document.getElementById('register-error-alert');
        const successAlert = document.getElementById('register-success-alert');
        hideAlert(errorAlert);

        const roleInput = document.querySelector('input[name="role"]:checked');

        const data = {
            username: document.getElementById('register-username').value,
            email:    document.getElementById('register-email').value,
            password: document.getElementById('register-password').value,
            role:     roleInput ? roleInput.value : ''
        };

        postJson('auth/registerUser', data)
            .then(res => {
                if(res.status === 201 || res.body.success) {
                    hideAlert(errorAlert);
                    showAlert(successAlert, 'Registration successful! Redirecting to login...');
                    setTimeout(() => window.location.href = appUrl('auth/login'), 1500);
                } else {
                    showAlert(errorAlert, res.body.message || 'Registration failed.');
                }
            })
            .catch(() => showAlert(errorAlert, 'An unexpected error occurred.'));
    });
}

function syncAuthState() {
    const token = localStorage.getItem('jwt_token');
    const postBtn = document.getElementById('open-form-btn');
    const authBtn = document.getElementById('auth-action-btn');

    if (!authBtn) return;

    if (token) {
        if (postBtn) {
            postBtn.style.display = 'inline-flex';
        }

        authBtn.setAttribute('href', '#');
        authBtn.innerHTML = `
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            sign out
        `;

        authBtn.addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('jwt_token');
            window.location.href = appUrl('confessions');
        });

    } else {
        if (postBtn) {
            postBtn.style.display = 'none';
        }
    }
}