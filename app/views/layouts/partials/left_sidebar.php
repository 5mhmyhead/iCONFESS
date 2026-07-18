<?php
    /** @var string|null $category */
    /** @var string|null $sort     */
?>

<aside class="sidebar">
    <div class="sidebar-label noselect">BOARDS</div>
    <div class="sidebar-link <?= $category === '' ? 'active' : '' ?>" data-category="">all confessions</div>
    <div class="sidebar-link <?= $category === 'School Issues' ? 'active' : '' ?>" data-category="School Issues">school issues</div>
    <div class="sidebar-link <?= $category === 'Love' ? 'active' : '' ?>" data-category="Love">love</div>
    <div class="sidebar-link <?= $category === 'Drama' ? 'active' : '' ?>" data-category="Drama">drama</div>
    <div class="sidebar-link <?= $category === 'Miscellaneous' ? 'active' : '' ?>" data-category="Miscellaneous">miscellaneous</div>

    <hr class="sidebar-divider">

    <div class="sidebar-label noselect">SORT BY</div>
    <div class="sidebar-link <?= $sort === 'recent' ? 'active' : '' ?>" data-sort="recent">recent</div>
    <div class="sidebar-link <?= $sort === 'hot' ? 'active' : '' ?>" data-sort="hot">hot</div>
    <div class="sidebar-link <?= $sort === 'top' ? 'active' : '' ?>" data-sort="top">top</div>

    <hr class="sidebar-divider">
</aside>