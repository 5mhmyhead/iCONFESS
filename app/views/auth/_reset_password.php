<div class="form-wrapper">
    <div class="form-container">
        <h1 class="form-title">Reset <span>password</span></h1>
        <p class="form-subtitle">Choose a secure new password for your iACADEMY Confessions account.</p>

        <div id="reset-error-alert" style="display: none;"></div>
        <div id="reset-success-alert" style="display: none;"></div>

        <form id="reset-form">
            <!-- Optional: include token if passed via GET parameter -->
            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

            <div class="form-group">
                <label for="reset-password">new password</label>
                <input type="password" id="reset-password" placeholder="enter a strong password" required>
            </div>

            <div class="form-group">
                <label for="reset-password-confirm">confirm password</label>
                <input type="password" id="reset-password-confirm" placeholder="re-enter your new password" required>
            </div>

            <button type="submit" class="btn-submit">update password</button>

            <p class="form-footer">
                back to <a href="?url=auth/login" class="text-link">sign in</a>
            </p>
        </form>
    </div>
</div>