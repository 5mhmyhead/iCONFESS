<div class="form-wrapper">
    <div class="form-container">
        <h1 class="form-title">Forgot <span>password?</span></h1>
        <p class="form-subtitle">Enter your registered school email address and we'll send you instructions to reset your password.</p>

        <div class="info-banner">
            <span class="info-icon">!</span>
            <p>Make sure to use your official @iacademy.edu.ph school email.</p>
        </div>

        <div id="forgot-error-alert" style="display: none;"></div>
        <div id="forgot-success-alert" style="display: none;"></div>

        <form id="forgot-form">
            <div class="form-group">
                <label for="forgot-email">school email</label>
                <input 
                    type="email" 
                    id="forgot-email" 
                    name="email" 
                    placeholder="youremail@iacademy.edu.ph" 
                    pattern="^[a-zA-Z0-9._%+-]+@iacademy\.edu\.ph$" 
                    title="Please use a valid @iacademy.edu.ph email address."
                    required 
                />
            </div>

            <button type="submit" class="btn-submit">send reset link</button>

            <p class="form-footer">
                remembered your password? <a href="?url=auth/login" class="text-link">sign in here</a>
            </p>
        </form>
    </div>
</div>