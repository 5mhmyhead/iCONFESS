<?php include '../app/views/layouts/page_loader.php'; ?>
<?php include '../app/views/layouts/partials/header.php'; ?>

<div class="feed-content">
    <?php include '../app/views/layouts/partials/left_sidebar.php'; ?>

    <section class="confessions-list">
        <?php require '../app/views/layouts/partials/feed_header.php'; ?>
        
        <div class="confessions-list-inner">
            <?php require '../app/views/confessions/_cards.php'; ?>
        </div>
    </section>

    <?php include '../app/views/layouts/partials/right_sidebar.php'; ?>
    <?php include '../app/views/layouts/partials/submission_form.php'; ?>
    <?php include '../app/views/layouts/partials/report_form.php'; ?>
    <?php include '../app/views/layouts/partials/alert.php'; ?>
</div>