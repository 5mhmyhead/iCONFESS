<?php
    /** @var int|null $page */
    /** @var int|null $totalPages */
    /** @var string|null $category */
    /** @var string|null $campus */
    /** @var string|null $sort */
    /** @var string|null $keyword */
    /** @var string|null $viewMode */

    $current = compact('category', 'campus', 'sort', 'keyword');
?>

<?php include '../app/views/layouts/partials/header.php'; ?>

<div class="feed-content">
    <?php include '../app/views/layouts/partials/left_sidebar.php'; ?>

    <section class="confessions-list">
        <?php require '../app/views/layouts/partials/feed_header.php'; ?>
        
        <div class="confessions-list-inner <?= $viewMode === 'grid' ? 'grid-view' : '' ?>">
            <?php require '../app/views/confessions/_cards.php'; ?>
        </div>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="<?= $this -> filterUrl(['page' => $page - 1], $current) ?>">&laquo; Prev</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= $this -> filterUrl(['page' => $i], $current) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="<?= $this -> filterUrl(['page' => $page + 1], $current) ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </section>

    <?php include '../app/views/layouts/partials/right_sidebar.php'; ?>
    <?php include '../app/views/layouts/partials/submission_form.php'; ?>
    <?php include '../app/views/layouts/partials/report_form.php'; ?>
    <?php include '../app/views/layouts/partials/alert.php'; ?>
</div>