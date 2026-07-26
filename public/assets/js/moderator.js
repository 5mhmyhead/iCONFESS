$(function() {
    const token = () => localStorage.getItem('jwt_token');

    function moderationAction(endpoint, id, extra = {}) {
        return fetch(appUrl(endpoint), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token()}`
            },
            body: JSON.stringify({ id, ...extra })
        }).then(r => r.json().then(body => ({ status: r.status, body })));
    }

    $(document).on('click', '.mod-btn-approve', function() {
        const id = $(this).data('id');

        moderationAction('moderator/approve', id).then(res => {
            if (res.body.success) {
                reloadWithLoader();
            } else {
                showAlert(res.body.message || 'Action failed.');
            }
        });
    });

    $(document).on('click', '.mod-btn-return', function() {
        const id = $(this).data('id');

        moderationAction('moderator/returnToQueue', id).then(res => {
            if (res.body.success) {
                reloadWithLoader();
            } else {
                showAlert(res.body.message || 'Action failed.');
            }
        });
    });

    // reject modal
    const rejectOverlay = document.getElementById('reject-form');
    const rejectForm = document.getElementById('reject-confession-form');
    let rejectTargetId = null;

    $(document).on('click', '.mod-btn-reject', function() {
        rejectTargetId = $(this).data('id');
        document.getElementById('reject-reason-text').value = '';
        rejectOverlay.style.display = 'flex';
    });

    document.getElementById('close-reject-form-btn')?.addEventListener('click', () => {
        rejectOverlay.style.display = 'none';
    });

    rejectForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        const reason = document.getElementById('reject-reason-text').value.trim();

        if (!reason) {
            alert('Please provide a reason.');
            return;
        }

        moderationAction('moderator/reject', rejectTargetId, { reason }).then(res => {
            if (res.body.success) reloadWithLoader();
            else alert(res.body.message || 'Action failed.');
        });
    });

    // shared alert
    function showAlert(message) {
        document.getElementById('alert-modal-message').textContent = message;
        document.getElementById('alert-modal').style.display = 'flex';
    }
    document.getElementById('alert-modal-close-btn')?.addEventListener('click', () => {
        document.getElementById('alert-modal').style.display = 'none';
    });

    function reloadWithLoader() {
        const url = new URL(window.location.href);
        url.searchParams.set('actionDone', '1');
        window.location.href = url.toString();
    }
});