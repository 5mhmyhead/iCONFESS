<div id="submission-form" class="form-overlay" style="display: none;">
    <div class="form-card">
        <h1 class="form-title">Submit a <span>Confession</span></h1>
        <hr class="form-divider"/>

        <form id="confession-form">
            <div class="form-group">
                <div class="field-header-row">
                    <label for="submit-title">Title</label>
                    <span class="char-counter"><span id="title-count">0</span> / 80</span>
                </div>
                <input type="text" id="submit-title" placeholder="give your confession a title..." maxlength="80" required>
            </div>

            <div class="form-grid-row">
                <div class="form-group flex-1">
                    <label for="submit-category">Category</label>
                    <select id="submit-category" required>
                        <option value="" disabled selected hidden>select category</option>
                        <option value="Academic">Academic</option>
                        <option value="Love">Love</option>
                        <option value="Drama">Drama</option>
                        <option value="Miscellaneous">Miscellaneous</option>
                    </select>
                </div>
                
                <div class="form-group flex-1">
                    <label for="submit-campus">Campus</label>
                    <select id="submit-campus" required>
                        <option value="" disabled selected hidden>select campus</option>
                        <option value="Makati">Makati Campus</option>
                        <option value="Cebu">Cebu Campus</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="field-header-row">
                    <label for="submit-content">Content</label>
                    <span class="char-counter"><span id="content-count">0</span> / 500</span>
                </div>
                <textarea id="submit-content" placeholder="type your confession here..." maxlength="500" rows="10" required></textarea>
            </div>

            <div class="security-banner">
                <span class="info-icon">!</span>
                <p>Please follow the confession board rules when posting your confession. Your confession is fully anonymous but will be reviewed by the moderators before it will appear on the board.</p>
            </div>

            <hr class="form-divider"/>
            <div class="form-actions">
                <button type="button" id="close-form-btn" class="btn btn-browse">cancel</button>
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    post anonymously
                </button>
            </div>
        </form>

        <div id="submission-success" style="display: none;">
            <div class="success-title">Your Confession has been <span>submitted.</span></div>
            <div class="success-message">
                Your confession is now in the moderation queue. A moderator will review it before it appears on the confession feed. This will usually take anywhere from a few hours to a day.
            </div>
            <div class="success-actions">
                <button type="button" id="success-close-btn" class="btn btn-browse">back to feed</button>
                <button type="button" id="success-another-btn" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    post another confession
                </button>
            </div>
        </div>
    </div>
</div>