<?php
    /** @var int|null $totalConfessions */
    /** @var int|null $weeklyConfessions */
    /** @var string|null $viewMode */
    /** @var string|null $sort */
    /** @var array|null $current */
?>

<div class="feed-header">
    <div class="feed-title">
        Confessions <span>Feed</span>
    </div>
    <div class="feed-subtitle">
        <span class="status-dot"></span> 
        <?= $totalConfessions; ?> confession<?= $totalConfessions === 1 ? '' : 's'; ?> · 
        <?= $weeklyConfessions; ?> new in the past week
    </div>

    <hr class="feed-divider">

    <div class="feed-controls">
        <div class="sort-toggle">
            <a href="<?= $this -> filterUrl(['sort' => 'recent'], $current) ?>" class="sort-btn <?= ($sort === 'recent' || $sort === '') ? 'active' : '' ?>">recent</a>
            <a href="<?= $this -> filterUrl(['sort' => 'top'], $current) ?>" class="sort-btn <?= $sort === 'top' ? 'active' : '' ?>">top</a>
            <a href="<?= $this -> filterUrl(['sort' => 'hot'], $current) ?>" class="sort-btn <?= $sort === 'hot' ? 'active' : '' ?>">hot</a>
        </div>

        <div class="view-toggle">
            <button type="button" class="view-btn <?= $viewMode === 'list' ? 'active' : '' ?>" id="btn-list-view">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6C4 5.44772 4.44772 5 5 5H19C19.5523 5 20 5.44772 20 6C20 6.55228 19.5523 7 19 7H5C4.44772 7 4 6.55228 4 6Z"/>
                    <path d="M4 12C4 11.4477 4.44772 11 5 11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H5C4.44772 13 4 12.5523 4 12Z"/>
                    <path d="M4 18C4 17.4477 4.44772 17 5 17H19C19.5523 17 20 17.4477 20 18C20 18.5523 19.5523 19 19 19H5C4.44772 19 4 18.5523 4 18Z"/>
                </svg>
            </button>
            <button type="button" class="view-btn <?= $viewMode === 'grid' ? 'active' : '' ?>" id="btn-grid-view">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
            </button>
        </div>
    </div>
</div>