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

<?php include '../app/views/confessions/_confessions_header.php'; ?>

<div class="feed-content">
    <?php include '../app/views/confessions/_left_sidebar.php'; ?>

    <section class="confessions-list">
        <?php require '../app/views/confessions/_feed_header.php'; ?>
        
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

    <?php include '../app/views/confessions/_right_sidebar.php'; ?>
    <?php include '../app/views/confessions/_submission_form.php'; ?>
    <?php include '../app/views/confessions/_report_form.php'; ?>
    <?php include '../app/views/layouts/alert.php'; ?>

    <?php if (!empty($unseenRejections)): ?>
    <div id="rejection-notice-modal" class="form-overlay" style="display: flex;">
        <div class="form-card">
            <h1 class="form-title">Confession <span>Update</span></h1>
            <hr class="form-divider"/>
            <?php foreach ($unseenRejections as $rejected): ?>
                <div class="rejection-item">
                    <p class="rejection-title">"<?= htmlspecialchars($rejected -> getTitle()) ?>" was rejected.</p>
                    <p class="rejection-reason"><?= htmlspecialchars($rejected -> getRejectionReason()) ?></p>
                </div>
            <?php endforeach; ?>
            <div class="form-actions">
                <button type="button" id="close-rejection-notice-btn" class="btn btn-primary">okay</button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>