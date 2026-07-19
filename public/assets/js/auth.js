function appUrl(path) {
    return '?url=' + path;
}

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    if (loginForm) { 
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault(); 

            const usernameInput = document.getElementById('login-username').value;
            const passwordInput = document.getElementById('login-password').value;
            const errorAlert = document.getElementById('login-error-alert');

            if (errorAlert) {
                errorAlert.textContent = '';
                errorAlert.style.display = 'none';
            }

            fetch(appUrl('auth/login'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    username: usernameInput,
                    password: passwordInput
                })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 || res.body.success) {
                    localStorage.setItem('jwt_token', res.body.token);
                    window.location.href = appUrl('confessions');
                } else {
                    if (errorAlert) {
                        errorAlert.textContent = res.body.message || 'Login failed';
                        errorAlert.style.display = 'block';
                    }
                }
            })
            .catch(err => {
                console.error('AJAX Error: ', err);
                if (errorAlert) {
                    errorAlert.textContent = 'An unexpected error occurred.';
                    errorAlert.style.display = 'block';
                }
            });
        });
    }

    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const usernameInput = document.getElementById('register-username').value;
            const emailInput = document.getElementById('register-email').value;
            const passwordInput = document.getElementById('register-password').value;
            const roleInput = document.querySelector('input[name="role"]:checked').value;

            const errorAlert = document.getElementById('register-error-alert');

            if (errorAlert) {
                errorAlert.textContent = '';
                errorAlert.style.display = 'none';
            }

            fetch(appUrl('auth/registerUser'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    username: usernameInput,
                    email: emailInput,
                    password: passwordInput,
                    role: roleInput
                })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 201 || res.body.success) {
                    window.location.href = appUrl('auth/login');
                } else {
                    if (errorAlert) {
                        errorAlert.textContent = res.body.message || 'Registration failed';
                        errorAlert.style.display = 'block';
                    }
                }
            })
            .catch(err => {
                console.error('AJAX Error:', err);
                if (errorAlert) {
                    errorAlert.textContent = 'An unexpected error occurred.';
                    errorAlert.style.display = 'block';
                }
            });
        });
    }
});