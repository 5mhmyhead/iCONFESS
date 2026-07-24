<?php include '../app/views/moderator/_mod_header.php'; ?>
<?php include '../app/views/moderator/_metrics.php'; ?>

<div class="queue-tabs">
    <a class="tab-btn active">queue</a>
    <a class="tab-btn">flagged</a>
    <a class="tab-btn">approved</a>
    <a class="tab-btn">rejected</a>
</div>

<div class="filter-toolbar">
    <div class="filter-search-wrap">
        <svg class="search-icon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M28 28L22.2 22.2M25.3333 14.6667C25.3333 20.5577 20.5577 25.3333 14.6667 25.3333C8.77563 25.3333 4 20.5577 4 14.6667C4 8.77563 8.77563 4 14.6667 4C20.5577 4 25.3333 8.77563 25.3333 14.6667Z" stroke="#505050" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input type="text" class="filter-search-input" placeholder="search confessions...">
    </div>
    <select class="category-select">
        <option>all categories</option>
        <option>academic</option>
        <option>love</option>
        <option>drama</option>
        <option>miscellaneous</option>
    </select>
</div>

<div class="confessions-list-inner">
    <?php include '../app/views/moderator/_moderator_cards.php'; ?>
</div>