<?php include '../app/views/layouts/partials/header.php'; ?>

<div class="feed-content">
    <?php include '../app/views/layouts/partials/left_sidebar.php'; ?>

    <div class="confessions-list">
        <?php require '../app/views/confessions/_cards.php'; ?>
    </div>

    <?php include '../app/views/layouts/partials/right_sidebar.php'; ?>
</div>