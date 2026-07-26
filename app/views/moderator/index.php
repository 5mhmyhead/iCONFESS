<?php include '../app/views/moderator/_mod_header.php'; ?>
<?php include '../app/views/moderator/_metrics.php'; ?>

<?php 
    /** @var int|null $page        */
    /** @var int|null $totalPages  */
    /** @var string|null $status   */
    /** @var string|null $campus   */
    /** @var string|null $category */
    /** @var string|null $keyword  */

    $current = ['status' => $status, 'category' => $category, 'campus' => $campus, 'sort' => '', 'keyword' => $keyword]; 
?>

<div class="queue-tabs">
    <a href="<?= $this -> filterUrl(['status' => 'pending'], $current, 'moderator/panel') ?>" class="tab-btn <?= $status === 'pending' ? 'active' : '' ?>">queue</a>
    <a href="<?= $this -> filterUrl(['status' => 'flagged'], $current, 'moderator/panel') ?>" class="tab-btn <?= $status === 'flagged' ? 'active' : '' ?>">flagged</a>
    <a href="<?= $this -> filterUrl(['status' => 'approved'], $current, 'moderator/panel') ?>" class="tab-btn <?= $status === 'approved' ? 'active' : '' ?>">approved</a>
    <a href="<?= $this -> filterUrl(['status' => 'rejected'], $current, 'moderator/panel') ?>" class="tab-btn <?= $status === 'rejected' ? 'active' : '' ?>">rejected</a>
</div>

<form class="filter-toolbar" method="GET" action="">
    <input type="hidden" name="url" value="moderator/panel">
    <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">

    <div class="filter-search-wrap">
        <svg class="search-icon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M28 28L22.2 22.2M25.3333 14.6667C25.3333 20.5577 20.5577 25.3333 14.6667 25.3333C8.77563 25.3333 4 20.5577 4 14.6667C4 8.77563 8.77563 4 14.6667 4C20.5577 4 25.3333 8.77563 25.3333 14.6667Z" stroke="#505050" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input type="text" name="keyword" class="filter-search-input" placeholder="search confessions..." value="<?= htmlspecialchars($keyword) ?>">
    </div>

    <select name="category" class="category-select" onchange="this.form.submit()">
        <option value="" <?= $category === '' ? 'selected' : '' ?>>all categories</option>
        <option value="Academic" <?= $category === 'Academic' ? 'selected' : '' ?>>academic</option>
        <option value="Love" <?= $category === 'Love' ? 'selected' : '' ?>>love</option>
        <option value="Drama" <?= $category === 'Drama' ? 'selected' : '' ?>>drama</option>
        <option value="Miscellaneous" <?= $category === 'Miscellaneous' ? 'selected' : '' ?>>miscellaneous</option>
    </select>

    <select name="campus" class="campus-select" onchange="this.form.submit()">
        <option value="" <?= $campus === '' ? 'selected' : '' ?>>all campuses</option>
        <option value="Makati" <?= $campus === 'Makati' ? 'selected' : '' ?>>makati</option>
        <option value="Cebu" <?= $campus === 'Cebu' ? 'selected' : '' ?>>cebu</option>
    </select>
</form>

<div class="confessions-list-inner">
    <?php include '../app/views/moderator/_moderator_cards.php'; ?>
</div>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="<?= $this -> filterUrl(['page' => $page - 1], $current, 'moderator/panel') ?>">&laquo; Prev</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= $this -> filterUrl(['page' => $i], $current, 'moderator/panel') ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="<?= $this -> filterUrl(['page' => $page + 1], $current, 'moderator/panel') ?>">Next &raquo;</a>
    <?php endif; ?>
</div>

<?php include '../app/views/moderator/_reject_form.php'; ?>
<?php include '../app/views/layouts/alert.php'; ?>