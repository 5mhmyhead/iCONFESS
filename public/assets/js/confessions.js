$(function() {
    window.appUrl = function(path) {
        return '?url=' + path;
    };

    // right sidebar categories
    $(document).on('click', '.sidebar-link[data-category]', function() {
        $('.sidebar-link[data-category]').removeClass('active');
        $(this).addClass('active');
    });

    $(document).on('click', '.sidebar-link[data-sort]', function() {
        $('.sidebar-link[data-sort]').removeClass('active');
        $(this).addClass('active');
    });

    // left sidebar confession rules
    $(document).on('click', '.rule-header', function() {
        const body = $(this).closest('.rule-item').find('.rule-body');
        const caret = $(this).find('.rule-caret');
        body.toggleClass('open');
        caret.toggleClass('open');
    });

    // confession form 
    const modalOverlay = document.getElementById('submission-form');
    const openBtn = document.getElementById('open-form-btn'); 
    const closeBtn = document.getElementById('close-form-btn'); 

    if (openBtn && modalOverlay) {
        openBtn.addEventListener('click', (e) => {
            e.preventDefault();
            modalOverlay.style.display = 'flex'; 
        });
    }

    if (closeBtn && modalOverlay) {
        closeBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'none';
        });

        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.style.display = 'none';
            }
        });
    }

    // form submission
    const internalForm = modalOverlay ? modalOverlay.querySelector('form') : null;

    if (internalForm) {
        internalForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const token = localStorage.getItem('jwt_token');
            const dataPayload = {
                title: document.getElementById('submit-title').value,
                category: document.getElementById('submit-category').value,
                campus: document.getElementById('submit-campus').value,
                content: document.getElementById('submit-content').value
            };

            fetch(appUrl('confessions/submit'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(token ? { 'Authorization': `Bearer ${token}` } : {})
                },
                body: JSON.stringify(dataPayload)
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 201 || res.body.success) {
                    modalOverlay.style.display = 'none';
                    window.location.href = appUrl('confessions');
                } else {
                    alert(res.body.message || 'Submission failed');
                }
            })
            .catch(err => console.error('AJAX Submission Error:', err));
        });
    }

    // handle heart interaction
    document.querySelectorAll('.heart-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const token = localStorage.getItem('jwt_token');
            const id = this.dataset.id;
            const liked = this.dataset.liked === 'true';
            const action = liked ? 'decrement' : 'increment';

            this.disabled = true;

            fetch(appUrl('heart'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(token ? { 'Authorization': `Bearer ${token}` } : {})
                },
                body: JSON.stringify({ id, action })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 401) {
                    alert('You must be signed in to like confessions.');
                    return;
                }
                if (res.status === 200) {
                    this.querySelector('span').textContent = `${res.body.hearts} hearts`;
                    this.dataset.liked = (!liked).toString();
                } else {
                    throw new Error('Heart updates rejected');
                }
            })
            .catch(err => console.error('Like Processing Error:', err))
            .finally(() => { 
                this.disabled = false; 
            });
        });
    });
});