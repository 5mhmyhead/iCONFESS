<div class="form-container">
    <h1 class="form-title">Welcome <span>back!</span></h1>
    <p class="form-subtitle">Sign in with your school email so that you can post and interact with the confessions feed.</p>

    <div class="info-banner">
        <span class="info-icon">!</span>
        <p>You can check out the confessions feed without an account, but you cannot interact with the feed without logging in.</p>
    </div>

    <div id="login-error-alert" style="display: none;"></div>

    <form id="login-form">
        <div class="form-group">
            <label for="login-email">school email</label>
            <input type="email" id="login-email" placeholder="youremail@iacademy.edu.ph" autocomplete="email" required>
        </div>

        <div class="form-group">
            <label for="login-password">password</label>
            <input type="password" id="login-password" placeholder="enter your password" autocomplete="current-password" required>
            <div class="forgot-password-wrapper">
                <a href="#" class="text-link secondary-link">forgot password?</a>
            </div>
        </div>

        <button type="submit" class="btn-submit">sign in</button>

        <div class="divider">
            <span>or</span>
        </div>

        <a href="?url=confessions" class="btn-browse">browse without signing in</a>

        <p class="form-footer">
            don't have an account? <a href="?url=auth/register" class="text-link">create one here</a>
        </p>
    </form>
</div>