<?php
    /** @var int|null $totalConfessions */
    /** @var int|null $weeklyConfessions */
    /** @var int|null $accountsLive */
?>

<div class="split-layout">
    <div class="split-left noselect">
        <div class="logo">
            <span class="logo-sans">iACADEMY</span><span class="logo-dot">.</span><span class="logo-serif">Confessions</span>
        </div>

        <div class="left-wrapper">
            <div class="left-content">
                <h1 class="hero-title">Wake up, get up, <span>get out there.</span></h1>
                <p class="hero-description">
                    iACADEMY confessions is an anonymous space for iACADEMY students to share confessions, thoughts, and stories.
                </p>
            </div>

            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?= htmlspecialchars($totalConfessions) ?></div>
                    <div class="stat-label">total confessions</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?= htmlspecialchars($weeklyConfessions) ?></div>
                    <div class="stat-label">confessions in the last week</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?= htmlspecialchars($accountsLive) ?></div>
                    <div class="stat-label">accounts live</div>
                </div>
            </div>
        </div>

        <div class="left-footer">
            &copy; <?= date('Y') ?> iACADEMY Confessions. All rights reserved.
        </div>
    </div>

    <div class="split-right">
        <?php if (isset($formView)) require $formView; ?>
    </div>
</div>