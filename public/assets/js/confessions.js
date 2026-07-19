$(function() {
    // left sidebar link functionality
    $(document).on('click', '.sidebar-link[data-category]', function() {
        $('.sidebar-link[data-category]').removeClass('active');
        $(this).addClass('active');
    });

    $(document).on('click', '.sidebar-link[data-sort]', function() {
        $('.sidebar-link[data-sort]').removeClass('active');
        $(this).addClass('active');
    });

    // right sidebar link dropdown
    $(document).on('click', '.sidebar-link[data-category]', function() {
        $('.sidebar-link[data-category]').removeClass('active');
        $(this).addClass('active');
    });

    $(document).on('click', '.sidebar-link[data-sort]', function() {
        $('.sidebar-link[data-sort]').removeClass('active');
        $(this).addClass('active');
    });

    $(document).on('click', '.rule-header', function() {
        const body = $(this).closest('.rule-item').find('.rule-body');
        const caret = $(this).find('.rule-caret');
        body.toggleClass('open');
        caret.toggleClass('open');
    });
});

// code that handles users liking a confession
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.heart-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const liked = btn.dataset.liked === 'true';
            const action = liked ? 'decrement' : 'increment';

            btn.disabled = true;

            fetch(appUrl('heart'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    action: action
                })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200) {
                    btn.querySelector('span').textContent = `${res.body.hearts} hearts`;
                    btn.dataset.liked = (!liked).toString();
                } else {
                    throw new Error('Request failed');
                }
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => {
                btn.disabled = false;
            });
        });
    });
});

function appUrl(path) {
    return '?url=' + path;
}

const token = localStorage.getItem('token');

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
        // not logged in — redirect to login or show a prompt
        return;
    }
    if (res.status === 200) {
        btn.querySelector('span').textContent = `${res.body.hearts} hearts`;
        btn.dataset.liked = (!liked).toString();
    } else {
        throw new Error('Request failed');
    }
})
.catch(err => console.error(err))
.finally(() => { btn.disabled = false; });