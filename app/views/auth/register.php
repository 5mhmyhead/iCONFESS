<div class="form-wrapper">
    <div class="form-container">
        <h1 class="form-title">Sign <span>up!</span></h1>
        <p class="form-subtitle">Join with your school email to start posting and interacting with confessions anonymously.</p>

        <div class="info-banner">
            <span class="info-icon">!</span>
            <p>Only email addresses that end with @iacademy.edu.ph are allowed to register and sign in.</p>
        </div>

        <div id="register-error-alert" style="display: none;"></div>
        <div id="register-success-alert" style="display: none;"></div>

        <form id="register-form">
            <div class="form-group">
                <label for="register-username">username</label>
                <input type="text" id="register-username" placeholder="choose a display handle" required>
            </div>

            <div class="form-group">
                <label for="register-email">school email</label>
                <input 
                    type="email" 
                    id="register-email" 
                    name="email" 
                    placeholder="youremail@iacademy.edu.ph" 
                    pattern="^[a-zA-Z0-9._%+-]+@iacademy\.edu\.ph$" 
                    title="Please use a valid @iacademy.edu.ph email address."
                    required 
                />
            </div>

            <div class="form-group">
                <label for="register-password">password</label>
                <input type="password" id="register-password" placeholder="create a strong password" required>
            </div>

            <div class="form-group" id="mod-secret-group" style="display: none;">
                <label for="register-mod-secret">moderator passcode</label>
                <input type="password" id="register-mod-secret" placeholder="enter secret passcode">
            </div>

            <div class="form-group">
                <label>choose account type</label>
                <div class="role-grid">
                    <label class="role-card">
                        <input type="radio" name="role" value="user" checked>
                        <div class="role-content">
                            <div class="role-header">
                                <div class="radio-indicator"></div>
                                <span class="role-title">User</span>
                            </div>
                            <span class="role-desc">For interacting with community confessions anonymously.</span>
                        </div>
                    </label>
                    <label class="role-card">
                        <input type="radio" name="role" value="moderator">
                        <div class="role-content">
                            <div class="role-header">
                                <div class="radio-indicator"></div>
                                <span class="role-title">Moderator</span>
                            </div>
                            <span class="role-desc">Requires a special password to create with this account type; for reviewing confession quality.</span>
                        </div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-submit">sign up</button>

            <p class="form-footer">
                already have an account? <a href="?url=auth/login" class="text-link">login here</a>
            </p>
        </form>
    </div>
</div>