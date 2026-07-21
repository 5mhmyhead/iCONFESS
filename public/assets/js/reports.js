const reportOverlay = document.getElementById('report-form');
const reportForm = document.getElementById('report-confession-form');
const reasonSelect = document.getElementById('report-reason');
const customReasonGroup = document.getElementById('custom-reason-group');
const customReasonInput = document.getElementById('report-custom-reason');
const customReasonCount = document.getElementById('custom-reason-count');

$(document).on('click', '.report-btn', function () {
    const token = localStorage.getItem('jwt_token');

    if (!token) {
        alert('You must be signed in to report a confession.');
        return;
    }

    const confessionId = $(this).data('id');
    document.getElementById('report-confession-id').value = confessionId;
    reportOverlay.style.display = 'flex';
});

customReasonInput?.addEventListener('input', () => {
    customReasonCount.textContent = customReasonInput.value.length;
});

function resetReportForm() {
    if (reportForm) reportForm.reset();
    if (customReasonCount) customReasonCount.textContent = '0';
}

function showReportSuccess() {
    const mainTitle = reportOverlay?.querySelector('.form-title');
    const mainDivider = reportOverlay?.querySelector('.form-divider');

    if (reportForm) reportForm.style.display = 'none';
    if (mainTitle) mainTitle.style.display = 'none';
    if (mainDivider) mainDivider.style.display = 'none';

    document.getElementById('report-success').style.display = 'flex';
}

function hideReportSuccess() {
    const mainTitle = reportOverlay?.querySelector('.form-title');
    const mainDivider = reportOverlay?.querySelector('.form-divider');

    document.getElementById('report-success').style.display = 'none';

    if (mainTitle) mainTitle.style.display = 'block';
    if (mainDivider) mainDivider.style.display = 'block';
    if (reportForm) reportForm.style.display = 'block';
}

document.getElementById('close-report-form-btn')?.addEventListener('click', () => {
    resetReportForm();
    hideReportSuccess();
    reportOverlay.style.display = 'none';
});

document.getElementById('report-success-close-btn')?.addEventListener('click', () => {
    resetReportForm();
    hideReportSuccess();
    reportOverlay.style.display = 'none';
});

reportForm?.addEventListener('submit', function (e) {
    e.preventDefault();

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
            alert('You must be signed in to report a confession.');
            return;
        }
        if (res.status === 201 || res.body.success) {
            showReportSuccess();
        } else {
            alert(res.body.message || 'Report failed');
        }
    })
    .catch(err => console.error('Report Error:', err));
});