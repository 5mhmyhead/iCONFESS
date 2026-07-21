<?php
    /** @var int|null $totalConfessions */
    /** @var int|null $weeklyConfessions */
?>

<div class="feed-header">
    <div class="feed-title">
        Confessions Feed
    </div>
    <div class="feed-subtitle">
        <?= $totalConfessions; ?> confession<?= $totalConfessions === 1 ? '' : 's'; ?> · 
        <?= $weeklyConfessions; ?> new in the past week
    </div>
    <hr class="feed-divider">
</div>