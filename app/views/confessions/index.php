<?php include '../app/views/layouts/partials/header.php'; ?>

<div class="feed-content">
    <?php include '../app/views/layouts/partials/left_sidebar.php'; ?>

    <section class="confessions-list">
        <?php require '../app/views/layouts/partials/feed_header.php'; ?>
        <?php require '../app/views/confessions/_cards.php'; ?>
    </section>

    <?php include '../app/views/layouts/partials/right_sidebar.php'; ?>
</div>