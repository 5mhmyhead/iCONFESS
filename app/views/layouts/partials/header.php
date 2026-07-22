<?php
    /** @var bool|null $isLoggedIn */
?>

<header>
    <div class="logo noselect">
        <span class="logo-sans">iACADEMY</span><span class="logo-dot">.</span><span class="logo-serif">Confessions</span>
    </div>
    <form class="search-container">
        <div class="search-wrap">
            <svg class="search-icon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M28 28L22.2 22.2M25.3333 14.6667C25.3333 20.5577 20.5577 25.3333 14.6667 25.3333C8.77563 25.3333 4 20.5577 4 14.6667C4 8.77563 8.77563 4 14.6667 4C20.5577 4 25.3333 8.77563 25.3333 14.6667Z" stroke="#6F91D0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <form class="search-container" method="GET" action="">
                <input type="hidden" name="url" value="confessions">
                <input type="hidden" name="category" value="<?= htmlspecialchars($category ?? '') ?>">
                <input type="hidden" name="campus" value="<?= htmlspecialchars($campus ?? '') ?>">
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sort ?? '') ?>">

                <div class="search-wrap">
                    <svg class="search-icon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M28 28L22.2 22.2M25.3333 14.6667C25.3333 20.5577 20.5577 25.3333 14.6667 25.3333C8.77563 25.3333 4 20.5577 4 14.6667C4 8.77563 8.77563 4 14.6667 4C20.5577 4 25.3333 8.77563 25.3333 14.6667Z" stroke="#6F91D0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="search" name="keyword" id="search-keyword" class="search-input" value="<?= htmlspecialchars($keyword ?? '') ?>" placeholder="Search for a confession..." aria-label="search confessions">
                </div>
            </form>
        </div>
    </form>
    <div class="btn-actions">
        <?php if ($isLoggedIn): ?>
            <button id="open-form-btn" class="btn btn-primary">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                post a confession
            </button>

            <a href="#" id="auth-action-btn" class="btn btn-secondary" data-action="logout">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                sign out
            </a>
        <?php else: ?>
            <a href="?url=auth/login" id="auth-action-btn" class="btn btn-secondary">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <path d="M10 17l5-5-5-5"/>
                    <path d="M15 12H3"/>
                </svg>
                sign in
            </a>
        <?php endif; ?>
    </div>
</header>