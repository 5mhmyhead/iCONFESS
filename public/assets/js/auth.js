document.addEventListener('DOMContentLoaded', function() {
    if (!getTokenPayload()) {
        document.body.classList.add('user-logged-out');
    } else {
        document.body.classList.remove('user-logged-out');
    }

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
                    // set as cookie for heart interactions
                    document.cookie = `jwt_token=${res.body.token}; path=/; max-age=${res.body.expires_in}; SameSite=Lax`;
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

    const roleRadios = form.querySelectorAll('input[name="role"]');
    const modSecretGroup = document.getElementById('mod-secret-group');
    const modSecretInput = document.getElementById('register-mod-secret');

    // toggle moderator input when radio buttons change
    roleRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'moderator') {
                modSecretGroup.style.display = 'block';
                modSecretInput.required = true;
            } else {
                modSecretGroup.style.display = 'none';
                modSecretInput.required = false;
                modSecretInput.value = '';
            }
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const errorAlert   = document.getElementById('register-error-alert');
        const successAlert = document.getElementById('register-success-alert');
        hideAlert(errorAlert);

        const roleInput = document.querySelector('input[name="role"]:checked');
        const selectedRole = roleInput ? roleInput.value : 'user';

        if (selectedRole === 'moderator' && !modSecretInput.value.trim()) {
            showAlert(errorAlert, 'Please enter the moderator passcode.');
            return;
        }

        const data = {
            username: document.getElementById('register-username').value,
            email: document.getElementById('register-email').value,
            password: document.getElementById('register-password').value,
            role: selectedRole,
            mod_secret: modSecretInput.value
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

document.getElementById('auth-action-btn')?.addEventListener('click', function(e) {
    if (this.dataset.action !== 'logout') return;
    e.preventDefault();
    localStorage.removeItem('jwt_token');
    document.cookie = 'jwt_token=; path=/; max-age=0';
    window.location.href = appUrl('auth/login');
});

document.getElementById('forgot-form')?.addEventListener('submit', function (e) {
    e.preventDefault();
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending...';

    const errorAlert = document.getElementById('forgot-error-alert');
    const successAlert = document.getElementById('forgot-success-alert');
    hideAlert(errorAlert);
    hideAlert(successAlert);

    const email = document.getElementById('forgot-email').value;

    postJson('auth/sendPasswordReset', { email })
        .then(res => {
            if (res.body.success) {
                showAlert(successAlert, res.body.message);
            } else {
                showAlert(errorAlert, res.body.message || 'Something went wrong.');
            }
        })
        .catch(() => showAlert(errorAlert, 'An unexpected error occurred.'))
        .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'send reset link';
        });
});

document.getElementById('reset-form')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const errorAlert = document.getElementById('reset-error-alert');
    const successAlert = document.getElementById('reset-success-alert');
    hideAlert(errorAlert);
    hideAlert(successAlert);

    const token = document.querySelector('input[name="token"]').value;
    const password = document.getElementById('reset-password').value;
    const confirmPassword = document.getElementById('reset-password-confirm').value;

    if (password !== confirmPassword) {
        showAlert(errorAlert, 'Passwords do not match.');
        return;
    }

    postJson('auth/resetPassword', { token, password, confirmPassword })
        .then(res => {
            if (res.body.success) {
                showAlert(successAlert, 'Password updated! Redirecting to login...');
                setTimeout(() => window.location.href = appUrl('auth/login'), 1500);
            } else {
                showAlert(errorAlert, res.body.message || 'Reset failed.');
            }
        })
        .catch(() => showAlert(errorAlert, 'An unexpected error occurred.'));
});