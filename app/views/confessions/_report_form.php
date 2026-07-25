<div id="report-form" class="form-overlay" style="display: none;">
    <div class="form-card">
        <h1 class="form-title">Report a <span>Confession</span></h1>
        <hr class="form-divider"/>

        <form id="report-confession-form">
            <input type="hidden" id="report-confession-id">

            <div class="form-group">
                <label for="report-reason">Reason</label>
                <select id="report-reason" required>
                    <option value="" disabled selected hidden>select a reason</option>
                    <option value="Spam">Spam</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Hate Speech">Hate Speech</option>
                    <option value="Inappropriate Content">Inappropriate Content</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group" id="custom-reason-group">
                <div class="field-header-row">
                    <label for="report-custom-reason">Details</label>
                    <span class="char-counter"><span id="custom-reason-count">0</span> / 300</span>
                </div>
                <textarea id="report-custom-reason" placeholder="describe the issue..." maxlength="300" rows="5"></textarea>
            </div>

            <hr class="form-divider"/>
            <div class="form-actions">
                <button type="button" id="close-report-form-btn" class="btn btn-browse">cancel</button>
                <button type="submit" class="btn btn-primary">submit report</button>
            </div>
        </form>

        <div id="report-success" style="display: none;">
            <div class="success-title">Report <span>submitted.</span></div>
            <div class="success-message">
                Thanks for flagging this confession. Your report will be sent to a moderator and will be reviewed shortly.
            </div>
            <div class="success-actions">
                <button type="button" id="report-success-close-btn" class="btn btn-browse">back to feed</button>
            </div>
        </div>
    </div>
</div>