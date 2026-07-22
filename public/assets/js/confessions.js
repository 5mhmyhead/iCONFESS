$(function() {
    window.appUrl = function(path) {
        return '?url=' + path;
    };

    // shared alert
    function showAlert(message) {
        document.getElementById('alert-modal-message').textContent = message;
        document.getElementById('alert-modal').style.display = 'flex';
    }
    document.getElementById('alert-modal-close-btn')?.addEventListener('click', () => {
        document.getElementById('alert-modal').style.display = 'none';
    });

    // shared char counter
    function updateCounter(inputEl, countEl, maxLen) {
        if (!inputEl || !countEl) return;
        const currentLength = inputEl.value.length;
        countEl.textContent = currentLength;
        const counterWrapper = countEl.closest('.char-counter');
        if (counterWrapper) {
            counterWrapper.classList.toggle('near-limit', currentLength >= maxLen * 0.9);
        }
    }

    // shared modal factory
    function createFormModal({ overlayId, formSelector, successId, closeBtnId, successCloseBtnId, onSubmit }) {
        const overlay = document.getElementById(overlayId);
        const form = overlay ? overlay.querySelector(formSelector) : null;
        const success = document.getElementById(successId);

        function showSuccess() {
            const mainTitle = overlay?.querySelector('.form-title');
            const mainDivider = overlay?.querySelector('.form-divider');
            if (form) form.style.display = 'none';
            if (mainTitle) mainTitle.style.display = 'none';
            if (mainDivider) mainDivider.style.display = 'none';
            if (success) success.style.display = 'flex';
        }

        function hideSuccess() {
            const mainTitle = overlay?.querySelector('.form-title');
            const mainDivider = overlay?.querySelector('.form-divider');
            if (success) success.style.display = 'none';
            if (mainTitle) mainTitle.style.display = 'block';
            if (mainDivider) mainDivider.style.display = 'block';
            if (form) form.style.display = 'block';
        }

        function reset() {
            if (form) form.reset();
            overlay?.querySelectorAll('.char-counter').forEach(el => {
                el.classList.remove('near-limit');
                const span = el.querySelector('span');
                if (span) span.textContent = '0';
            });
        }

        function close() {
            reset();
            hideSuccess();
            if (overlay) overlay.style.display = 'none';
        }

        function open() {
            if (overlay) overlay.style.display = 'flex';
        }

        document.getElementById(closeBtnId)?.addEventListener('click', close);
        document.getElementById(successCloseBtnId)?.addEventListener('click', close);
        overlay?.addEventListener('click', (e) => { if (e.target === overlay) close(); });

        form?.addEventListener('submit', function (e) {
            e.preventDefault();
            onSubmit({ showSuccess, reset });
        });

        return { open, close, reset, showSuccess, hideSuccess };
    }

    // confession submission form
    const submissionModal = createFormModal({
        overlayId: 'submission-form',
        formSelector: 'form',
        successId: 'submission-success',
        closeBtnId: 'close-form-btn',
        successCloseBtnId: 'success-close-btn',
        onSubmit: ({ showSuccess }) => {
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
                    showSuccess();
                } else {
                    showAlert(res.body.message || 'Submission failed! This might be an error on our part.');
                }
            })
            .catch(err => console.error('AJAX Submission Error:', err));
        }
    });

    document.getElementById('open-form-btn')?.addEventListener('click', (e) => {
        e.preventDefault();
        submissionModal.open();
    });

    document.getElementById('success-another-btn')?.addEventListener('click', () => {
        submissionModal.reset();
        submissionModal.hideSuccess();
    });

    // char counters for submission form
    const titleInput = document.getElementById('submit-title');
    const titleCount = document.getElementById('title-count');
    const contentInput = document.getElementById('submit-content');
    const contentCount = document.getElementById('content-count');
    titleInput?.addEventListener('input', () => updateCounter(titleInput, titleCount, 80));
    contentInput?.addEventListener('input', () => updateCounter(contentInput, contentCount, 500));

    // report form
    const reasonSelect = document.getElementById('report-reason');
    const customReasonInput = document.getElementById('report-custom-reason');
    const customReasonCount = document.getElementById('custom-reason-count');
    customReasonInput?.addEventListener('input', () => updateCounter(customReasonInput, customReasonCount, 300));

    const reportModal = createFormModal({
        overlayId: 'report-form',
        formSelector: 'form',
        successId: 'report-success',
        closeBtnId: 'close-report-form-btn',
        successCloseBtnId: 'report-success-close-btn',
        onSubmit: ({ showSuccess }) => {
            const token = localStorage.getItem('jwt_token');
            const payload = {
                confessionId: document.getElementById('report-confession-id').value,
                reason: reasonSelect.value,
                customReason: customReasonInput.value
            };

            fetch(appUrl('confessions/report'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(token ? { 'Authorization': `Bearer ${token}` } : {})
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 401) {
                    showAlert('You must be signed in to report a confession.');
                    return;
                }
                if (res.status === 201 || res.body.success) {
                    showSuccess();
                } else {
                    showAlert(res.body.message || 'Report failed. This may be an error on our part.');
                }
            })
            .catch(err => console.error('Report Error:', err));
        }
    });

    $(document).on('click', '.report-btn', function () {
        if (!getTokenPayload()) {
            showAlert('You must be signed in to report a confession.');
            return;
        }

        document.getElementById('report-confession-id').value = $(this).data('id');
        reportModal.open();
    });

    // heart interaction
    $(document).on('click', '.heart-btn', function() {
        const $btn = $(this);
        const token = localStorage.getItem('jwt_token');
        const id = $btn.data('id');
        const liked = $btn.attr('data-liked') === 'true';
        const action = liked ? 'decrement' : 'increment';

        $btn.prop('disabled', true);

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
                showAlert('You must be signed in to like confessions.');
                return;
            }
            if (res.status === 200) {
                $btn.find('span').text(`${res.body.hearts} hearts`);
                $btn.attr('data-liked', (!liked).toString());
            } else {
                throw new Error('Heart updates rejected');
            }
        })
        .catch(err => console.error('Like Processing Error:', err))
        .finally(() => { $btn.prop('disabled', false); });
    });

    // sidebar filter and search
    $(document).on('click', '.rule-header', function() {
        const body = $(this).closest('.rule-item').find('.rule-body');
        const caret = $(this).find('.rule-caret');
        body.toggleClass('open');
        caret.toggleClass('open');
    });

    $(document).on('click', '.sidebar-link[data-category]', function() {
        $('.sidebar-link[data-category]').removeClass('active');
        $(this).addClass('active');
        reloadFeed();
    });

    $(document).on('click', '.sort-btn', function() {
        $('.sort-btn').removeClass('active');
        $(this).addClass('active');
        reloadFeed();
    });

    $(document).on('click', '.sidebar-link[data-campus]', function() {
        $('.sidebar-link[data-campus]').removeClass('active');
        $(this).addClass('active');
        reloadFeed();
    });

    let searchTimeout = null;
    $(document).on('input', '#search-keyword', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(reloadFeed, 300);
    });

    function reloadFeed() {
        const category = $('.sidebar-link[data-category].active').data('category') || '';
        const campus = $('.sidebar-link[data-campus].active').data('campus') || '';
        const sort = $('.sort-btn.active').data('sort') || 'recent';
        const keyword = $('#search-keyword').val().trim();
        const token = localStorage.getItem('jwt_token');

        fetch(appUrl('confessions/filter'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(token ? { 'Authorization': `Bearer ${token}` } : {})
            },
            body: JSON.stringify({ category, campus, sort, keyword })
        })
        .then(r => r.text())
        .then(html => {
            const listContainer = document.querySelector('.confessions-list-inner');
            if (listContainer) listContainer.innerHTML = html;
        })
        .catch(err => console.error('Filter error:', err));
    }

    // list/grid view toggle
    function initViewToggle() {
        const $container = $('.confessions-list-inner');
        const $btnList = $('#btn-list-view');
        const $btnGrid = $('#btn-grid-view');

        if (!$btnList.length || !$btnGrid.length) return;

        // restore saved view mode on load
        const savedView = localStorage.getItem('confessions_view_mode') || 'list';
        if (savedView === 'grid') {
            $container.addClass('grid-view');
            $btnGrid.addClass('active');
            $btnList.removeClass('active');
        }

        $(document).on('click', '#btn-list-view', function() {
            $container.removeClass('grid-view');
            $btnList.addClass('active');
            $btnGrid.removeClass('active');
            localStorage.setItem('confessions_view_mode', 'list');
        });

        $(document).on('click', '#btn-grid-view', function() {
            $container.addClass('grid-view');
            $btnGrid.addClass('active');
            $btnList.removeClass('active');
            localStorage.setItem('confessions_view_mode', 'grid');
        });
    }

    initViewToggle();

    $(document).on('click', '.message-link', function(e) {
        e.preventDefault();
        const email = "c202401138@iacademy.edu.ph";
        const subject = encodeURIComponent("iACADEMY Confessions Moderator Inquiry");
        window.open(`https://mail.google.com/mail/?view=cm&fs=1&to=${email}&su=${subject}`, '_blank', 'noopener,noreferrer');
    });
});