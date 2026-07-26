<?php
    $referrer = urldecode($_SERVER['HTTP_REFERER'] ?? '');
    $view = $view ?? '';

    $isFeedPage = $view === 'confessions/index';
    $isModeratorPage = $view === 'moderator/index';

    $cameFromFeed = strpos($referrer, 'url=confessions') !== false;
    $cameFromModerator = strpos($referrer, 'url=moderator/panel') !== false;

    $actionJustHappened = isset($_GET['actionDone']);

    $skipLoader = !$actionJustHappened && (
        ($isFeedPage && $cameFromFeed) || ($isModeratorPage && $cameFromModerator)
    );
?>

<?php if (!$skipLoader): ?>
    <div id="page-loader" class="page-loader">
        <div class="loader-logo">
            <svg class="loader-icon" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 21 7 21 17 12 22 3 17 3 7 12 2" />
            </svg>
            <div class="loader-text">
                <span class="logo-sans">iACADEMY</span><span class="logo-dot">.</span><span class="logo-serif">Confessions</span>
            </div>
        </div>
    </div>
<?php endif; ?>