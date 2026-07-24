<?php 
    /** @var array|null $metrics */ 
?>

<div class="feed-header">
    <h1 class="feed-title">Moderation <span>Queue</span></h1>
    <div class="feed-subtitle"><?= $metrics['pending'] ?> confession<?= $metrics['pending'] === 1 ? '' : 's' ?> waiting for review</div>
</div>

<hr class="feed-divider" style="margin: 0 30px;">

<div class="metrics-grid">
    <div class="metric-card">
        <span class="metric-title">TOTAL POSTS</span>
        <span class="metric-value"><?= $metrics['totalPosts'] ?></span>
        <span class="metric-subtitle highlight-new"><?= $metrics['newToday'] ?> new today</span>
    </div>
    <div class="metric-card">
        <span class="metric-title">PENDING</span>
        <span class="metric-value"><?= $metrics['pending'] ?></span>
        <span class="metric-subtitle highlight-pending">needs review</span>
    </div>
    <div class="metric-card">
        <span class="metric-title">FLAGGED</span>
        <span class="metric-value"><?= $metrics['flagged'] ?></span>
        <span class="metric-subtitle highlight-flagged">reported by users</span>
    </div>
    <div class="metric-card">
        <span class="metric-title">REGISTERED USERS</span>
        <span class="metric-value"><?= $metrics['registeredUsers'] ?></span>
        <span class="metric-subtitle highlight-new"><?= $metrics['newUsersThisWeek'] ?> new this week</span>
    </div>
</div>